<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageElevationSeeder extends Seeder
{
    public function run(): void
    {
        $elevationProfiles = [
            'Everest Base Camp Trek' => [
                ['stop_name' => 'Kathmandu', 'altitude_meters' => 1400],
                ['stop_name' => 'Lukla', 'altitude_meters' => 2860],
                ['stop_name' => 'Phakding', 'altitude_meters' => 2610],
                ['stop_name' => 'Namche Bazaar', 'altitude_meters' => 3440],
                ['stop_name' => 'Tengboche', 'altitude_meters' => 3860],
                ['stop_name' => 'Dingboche', 'altitude_meters' => 4410],
                ['stop_name' => 'Lobuche', 'altitude_meters' => 4910],
                ['stop_name' => 'Everest Base Camp', 'altitude_meters' => 5364],
            ],
            'Annapurna Base Camp Trek' => [
                ['stop_name' => 'Ghandruk', 'altitude_meters' => 1940],
                ['stop_name' => 'Chhomrong', 'altitude_meters' => 2170],
                ['stop_name' => 'Dovan', 'altitude_meters' => 2600],
                ['stop_name' => 'Deurali', 'altitude_meters' => 3230],
                ['stop_name' => 'Annapurna Base Camp', 'altitude_meters' => 4130],
                ['stop_name' => 'Bamboo', 'altitude_meters' => 2310],
                ['stop_name' => 'Jhinu Danda', 'altitude_meters' => 1780],
                ['stop_name' => 'Landruk', 'altitude_meters' => 1565],
                ['stop_name' => 'Pokhara', 'altitude_meters' => 822],
            ],
            'Manaslu Circuit Trek' => [
                ['stop_name' => 'Machha Khola', 'altitude_meters' => 900],
                ['stop_name' => 'Jagat', 'altitude_meters' => 1340],
                ['stop_name' => 'Deng', 'altitude_meters' => 1860],
                ['stop_name' => 'Namrung', 'altitude_meters' => 2630],
                ['stop_name' => 'Samagaun', 'altitude_meters' => 3530],
                ['stop_name' => 'Samdo', 'altitude_meters' => 3875],
                ['stop_name' => 'Dharamsala', 'altitude_meters' => 4460],
                ['stop_name' => 'Larkya La Pass', 'altitude_meters' => 5106],
                ['stop_name' => 'Bimthang', 'altitude_meters' => 3720],
                ['stop_name' => 'Gho', 'altitude_meters' => 2560],
                ['stop_name' => 'Dharapani', 'altitude_meters' => 1860],
                ['stop_name' => 'Besisahar', 'altitude_meters' => 760],
            ],
            'Langtang Valley Trek' => [
                ['stop_name' => 'Syabrubesi', 'altitude_meters' => 1460],
                ['stop_name' => 'Lama Hotel', 'altitude_meters' => 2480],
                ['stop_name' => 'Langtang Village', 'altitude_meters' => 3430],
                ['stop_name' => 'Kyanjin Gompa', 'altitude_meters' => 3870],
                ['stop_name' => 'Lama Hotel', 'altitude_meters' => 2480],
                ['stop_name' => 'Syabrubesi', 'altitude_meters' => 1460],
            ],
            'Island Peak Climbing' => [
                ['stop_name' => 'Kathmandu', 'altitude_meters' => 1400],
                ['stop_name' => 'Lukla', 'altitude_meters' => 2860],
                ['stop_name' => 'Phakding', 'altitude_meters' => 2610],
                ['stop_name' => 'Namche Bazaar', 'altitude_meters' => 3440],
                ['stop_name' => 'Tengboche', 'altitude_meters' => 3860],
                ['stop_name' => 'Dingboche', 'altitude_meters' => 4410],
                ['stop_name' => 'Chhukung', 'altitude_meters' => 4730],
                ['stop_name' => 'Island Peak Base Camp', 'altitude_meters' => 5087],
                ['stop_name' => 'Island Peak Summit', 'altitude_meters' => 6189],
                ['stop_name' => 'Chhukung', 'altitude_meters' => 4730],
                ['stop_name' => 'Namche Bazaar', 'altitude_meters' => 3440],
                ['stop_name' => 'Lukla', 'altitude_meters' => 2860],
            ],
            'Mera Peak Climbing' => [
                ['stop_name' => 'Kathmandu', 'altitude_meters' => 1400],
                ['stop_name' => 'Lukla', 'altitude_meters' => 2860],
                ['stop_name' => 'Paiya', 'altitude_meters' => 2730],
                ['stop_name' => 'Panguam', 'altitude_meters' => 2850],
                ['stop_name' => 'Ningsow', 'altitude_meters' => 2860],
                ['stop_name' => 'Kothe', 'altitude_meters' => 3600],
                ['stop_name' => 'Thangnak', 'altitude_meters' => 4350],
                ['stop_name' => 'Khare', 'altitude_meters' => 5045],
                ['stop_name' => 'Mera High Camp', 'altitude_meters' => 5780],
                ['stop_name' => 'Mera Peak Summit', 'altitude_meters' => 6476],
                ['stop_name' => 'Kothe', 'altitude_meters' => 3600],
                ['stop_name' => 'Thuli Kharka', 'altitude_meters' => 4300],
                ['stop_name' => 'Lukla', 'altitude_meters' => 2860],
            ],
            'Kathmandu Valley Heritage Tour' => [
                ['stop_name' => 'Kathmandu Durbar Square', 'altitude_meters' => 1400],
                ['stop_name' => 'Patan', 'altitude_meters' => 1400],
                ['stop_name' => 'Boudhanath', 'altitude_meters' => 1400],
                ['stop_name' => 'Bhaktapur', 'altitude_meters' => 1400],
            ],
            'Chitwan Jungle Safari' => [
                ['stop_name' => 'Chitwan', 'altitude_meters' => 500],
                ['stop_name' => 'Rapti River', 'altitude_meters' => 500],
                ['stop_name' => 'Chitwan National Park', 'altitude_meters' => 500],
            ],
        ];

        foreach ($elevationProfiles as $packageName => $points) {
            $package = Package::query()->where('name', $packageName)->firstOrFail();

            if ($package->elevationPoints()->exists()) {
                continue;
            }

            $package->elevationPoints()->createMany(array_map(
                fn (array $point, int $sortOrder): array => [
                    ...$point,
                    'sort_order' => $sortOrder,
                ],
                $points,
                array_keys($points),
            ));
        }
    }
}
