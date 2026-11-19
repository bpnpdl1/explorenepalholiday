<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePackageRequest;
use App\Http\Requests\Admin\UpdatePackageRequest;
use App\Models\Package;
use App\Models\Subcategory;
use App\Services\MediaLibraryService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    private const PACKAGE_ATTRIBUTES = [
        'subcategory_id',
        'name',
        'summary',
        'description',
        'duration_days',
        'duration_nights',
        'difficulty',
        'max_altitude_meters',
        'min_group_size',
        'max_group_size',
        'price_from',
        'compare_at_price',
        'currency',
        'price_qualifier',
        'route_map_url',
        'accommodation',
        'fitness_guidance',
        'permit_notes',
        'safety_notes',
        'weather_notes',
        'meta_title',
        'meta_description',
        'sort_order',
    ];

    public function __construct(private readonly MediaLibraryService $mediaLibraryService) {}

    public function index(Request $request): View
    {
        $search = trim($request->string('search')->toString());
        $status = $request->string('status')->toString();
        $subcategoryId = $request->integer('subcategory_id');
        $featured = $request->string('featured')->toString();

        $packages = Package::query()
            ->with([
                'subcategory:id,category_id,name',
                'subcategory.category:id,destination_id,name',
                'subcategory.category.destination:id,name',
                'media' => fn ($query) => $query->where('collection_name', 'cover'),
            ])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%")
                        ->orWhereHas('subcategory', fn ($subcategoryQuery) => $subcategoryQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($status === 'published', fn ($query) => $query->where('is_published', true))
            ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
            ->when($subcategoryId > 0, fn ($query) => $query->where('subcategory_id', $subcategoryId))
            ->when($featured === 'yes', fn ($query) => $query->where('is_featured', true))
            ->when($featured === 'no', fn ($query) => $query->where('is_featured', false))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.packages.index', [
            'packages' => $packages,
            'subcategories' => $this->subcategoriesForForm(),
            'search' => $search,
            'status' => in_array($status, ['published', 'draft'], true) ? $status : '',
            'subcategoryId' => $subcategoryId,
            'featured' => in_array($featured, ['yes', 'no'], true) ? $featured : '',
            'packageCount' => Package::count(),
            'publishedCount' => Package::where('is_published', true)->count(),
            'draftCount' => Package::where('is_published', false)->count(),
            'featuredCount' => Package::where('is_featured', true)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.packages.create', [
            'package' => new Package([
                'currency' => 'USD',
                'sort_order' => 0,
            ]),
            'subcategories' => $this->subcategoriesForForm(),
        ]);
    }

    public function store(StorePackageRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $attributes = Arr::only($validated, self::PACKAGE_ATTRIBUTES);
        $attributes['is_published'] = $request->boolean('is_published');
        $attributes['is_featured'] = $request->boolean('is_featured');

        $package = DB::transaction(function () use ($attributes, $validated): Package {
            $package = Package::create($attributes);
            $this->syncSeasons($package, $validated['seasons'] ?? []);

            return $package;
        });

        $this->storeMedia($request, $package);

        return to_route('admin.packages.show', $package)
            ->with('success', 'Package created successfully.');
    }

    public function show(Package $package): View
    {
        $package->load([
            'subcategory.category.destination',
            'seasons',
            'media',
        ]);

        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package): View
    {
        $package->load([
            'seasons',
            'media',
        ]);

        return view('admin.packages.edit', [
            'package' => $package,
            'subcategories' => $this->subcategoriesForForm(),
        ]);
    }

    public function update(UpdatePackageRequest $request, Package $package): RedirectResponse
    {
        $validated = $request->validated();
        $attributes = Arr::only($validated, self::PACKAGE_ATTRIBUTES);
        $attributes['is_published'] = $request->boolean('is_published');
        $attributes['is_featured'] = $request->boolean('is_featured');

        DB::transaction(function () use ($package, $attributes, $validated): void {
            $package->update($attributes);
            $this->syncSeasons($package, $validated['seasons'] ?? []);
        });

        $this->storeMedia($request, $package);

        return to_route('admin.packages.show', $package)
            ->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return to_route('admin.packages.index')
            ->with('success', 'Package deleted successfully.');
    }

    /**
     * @param  array<int, string>  $seasons
     */
    private function syncSeasons(Package $package, array $seasons): void
    {
        $package->seasons()->delete();
        $package->seasons()->createMany(array_map(
            fn (string $season): array => ['season' => $season],
            array_values(array_unique($seasons)),
        ));
    }

    private function storeMedia(StorePackageRequest|UpdatePackageRequest $request, Package $package): void
    {
        if ($cover = $request->file('cover')) {
            $this->mediaLibraryService->storeImage($package, $cover, 'cover');
        }

        foreach ($request->file('gallery', []) as $image) {
            $this->mediaLibraryService->storeImage($package, $image, 'gallery');
        }

        $removeIds = $request->validated('remove_gallery', []);

        if ($removeIds !== []) {
            $package->media()
                ->where('collection_name', 'gallery')
                ->whereIn('id', $removeIds)
                ->get()
                ->each
                ->delete();
        }
    }

    private function subcategoriesForForm(): Collection
    {
        return Subcategory::query()
            ->with(['category:id,destination_id,name', 'category.destination:id,name'])
            ->orderBy('name')
            ->get(['id', 'category_id', 'name']);
    }
}
