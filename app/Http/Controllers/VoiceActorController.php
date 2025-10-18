<?php

namespace App\Http\Controllers;

use App\Models\VoiceActor;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class VoiceActorController extends Controller
{
    public function index(): View
    {
        $voiceActors = VoiceActor::query()
            ->with(['characters.anime'])
            ->orderBy('name')
            ->get()
            ->map(function (VoiceActor $voiceActor): ?array {
                $roles = $voiceActor->characters
                    ->map(function ($character) {
                        $anime = $character->anime;

                        return [
                            'character_id' => $character->slug,
                            'character_name' => $character->name,
                            'character_role' => $character->role,
                            'anime_id' => $anime?->slug ?? '',
                            'anime_title' => $anime?->title ?? 'Unknown Anime',
                        ];
                    })
                    ->values();

                if ($roles->isEmpty()) {
                    return null;
                }

                $roleCollection = Collection::make($roles);

                return [
                    'id' => $voiceActor->slug,
                    'name' => $voiceActor->name,
                    'language' => $voiceActor->language,
                    'roles' => $roleCollection->toArray(),
                    'anime_count' => $roleCollection->pluck('anime_id')->filter()->unique()->count(),
                    'character_count' => $roleCollection->count(),
                ];
            })
            ->filter()
            ->values();

        return view('voice-actors.index', [
            'voiceActors' => $voiceActors,
        ]);
    }
}
