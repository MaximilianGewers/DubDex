<?php

namespace App\Models;

use App\Enums\ScrapeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anime extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'synopsis',
        'genres',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'genres' => 'array',
        'scrape_status' => ScrapeStatus::class,
    ];

    /**
     * @return HasMany<Character>
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }
}
