<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Character extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'role',
        'anime_id',
    ];

    /**
     * @return BelongsTo<Anime, Character>
     */
    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    /**
     * @return BelongsToMany<VoiceActor>
     */
    public function voiceActors(): BelongsToMany
    {
        return $this->belongsToMany(VoiceActor::class)->withTimestamps();
    }
}
