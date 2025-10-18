<?php

namespace App\Http\Controllers;

use App\Models\VoiceActor;
use Illuminate\Contracts\View\View;

class VoiceActorController extends Controller
{
    public function index(): View
    {
        $voiceActors = VoiceActor::query()
            ->with(['characters.anime'])
            ->orderBy('name')
            ->get()
            ->map(function (VoiceActor $voiceActor): ?array {
                $characters = $voiceActor->characters;

                if ($characters->isEmpty()) {
                    return null;
                }

                $animeCount = $characters
                    ->map(fn ($character) => $character->anime?->slug)
                    ->filter()
                    ->unique()
                    ->count();

                return [
                    'id' => $voiceActor->slug,
                    'name' => $voiceActor->name,
                    'language' => $voiceActor->language,
                    'description' => $voiceActor->description,
                    'anime_count' => $animeCount,
                    'character_count' => $characters->count(),
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
                'description' => $voiceActorModel->description,
                'anime_count' => $animeCredits->count(),
                'character_count' => $roles->count(),
                'animes' => $animeCredits->toArray(),
                'roles' => $roles->toArray(),
            ],
        ]);
    }
}
