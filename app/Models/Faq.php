<?php

namespace App\Models;

use App\Enums\FaqCategory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'question',
    'answer',
    'category',
    'sort_order',
    'is_published',
])]
class Faq extends Model
{
    use HasFactory;

    public function categoryEnum(): FaqCategory
    {
        return $this->category ?? FaqCategory::Planning;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_published' => 'boolean',
            'category' => FaqCategory::class,
        ];
    }
}
