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

    public function show(string $voiceActor): View
    {
        $voiceActorModel = VoiceActor::query()
            ->where('slug', $voiceActor)
            ->with(['characters.anime'])
            ->firstOrFail();

        $roles = $voiceActorModel->characters
            ->map(function ($character) {
                $anime = $character->anime;

                return [
                    'id' => $character->slug,
                    'name' => $character->name,
                    'role' => $character->role,
                    'anime' => [
                        'id' => $anime?->slug ?? '',
                        'title' => $anime?->title ?? 'Unknown Anime',
                    ],
                ];
            })
            ->values();

        $animeCredits = $roles
            ->pluck('anime')
            ->filter(fn (array $anime) => filled($anime['id']))
            ->unique(fn (array $anime) => $anime['id'])
            ->values();

        return view('voice-actors.show', [
            'voiceActor' => [
                'id' => $voiceActorModel->slug,
                'name' => $voiceActorModel->name,
                'language' => $voiceActorModel->language,
                'anime_count' => $animeCredits->count(),
                'character_count' => $roles->count(),
                'animes' => $animeCredits->toArray(),
                'roles' => $roles->toArray(),
            ],
        ]);
    }
}
