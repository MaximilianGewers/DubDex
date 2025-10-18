<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class AnimeController extends Controller
{
    public function index(): View
    {
        $animes = Anime::query()
            ->with(['characters.voiceActors'])
            ->orderBy('title')
            ->get()
            ->map(function (Anime $anime): array {
                $characterDetails = $anime->characters
                    ->map(function ($character) {
                        $voiceActorDetails = $character->voiceActors
                            ->map(fn ($voiceActor) => [
                                'id' => $voiceActor->slug,
                                'name' => $voiceActor->name,
                                'language' => $voiceActor->language,
                            ])
                            ->values();

                        return [
                            'id' => $character->slug,
                            'name' => $character->name,
                            'role' => $character->role,
                            'voice_actors' => $voiceActorDetails->toArray(),
                        ];
                    })
                    ->values();

                $voiceActorDetails = Collection::make($characterDetails)
                    ->flatMap(fn (array $character) => $character['voice_actors'])
                    ->unique(fn (array $voiceActor) => $voiceActor['id'])
                    ->values();

                return [
                    'id' => $anime->slug,
                    'title' => $anime->title,
                    'synopsis' => $anime->synopsis,
                    'genres' => $anime->genres ?? [],
                    'characters' => $characterDetails->toArray(),
                    'voice_actors' => $voiceActorDetails->toArray(),
                ];
            })
            ->values();

        return view('animes.index', [
            'animes' => $animes,
        ]);
    }

    public function show(string $anime): View
    {
        $animeModel = Anime::query()
            ->where('slug', $anime)
            ->with(['characters.voiceActors'])
            ->firstOrFail();

        $characterDetails = $animeModel->characters
            ->map(function ($character) {
                $voiceActorDetails = $character->voiceActors
                    ->map(fn ($voiceActor) => [
                        'id' => $voiceActor->slug,
                        'name' => $voiceActor->name,
                        'language' => $voiceActor->language,
                    ])
                    ->values();

                return [
                    'id' => $character->slug,
                    'name' => $character->name,
                    'role' => $character->role,
                    'voice_actors' => $voiceActorDetails->toArray(),
                ];
            })
            ->values();

        $voiceActorDetails = Collection::make($characterDetails)
            ->flatMap(fn (array $character) => $character['voice_actors'])
            ->unique(fn (array $voiceActor) => $voiceActor['id'])
            ->values();

        return view('animes.show', [
            'anime' => [
                'id' => $animeModel->slug,
                'title' => $animeModel->title,
                'synopsis' => $animeModel->synopsis,
                'genres' => $animeModel->genres ?? [],
                'characters' => $characterDetails->toArray(),
                'voice_actors' => $voiceActorDetails->toArray(),
            ],
        ]);
    }
}
