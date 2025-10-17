<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class AnimeController extends Controller
{
    public function index(): View
    {
        $data = config('anime');

        $characters = collect($data['characters']);
        $voiceActors = collect($data['voice_actors']);

        $animes = collect($data['animes'])->map(function (array $anime, string $animeId) use ($characters, $voiceActors) {
            $characterDetails = collect($anime['character_ids'])
                ->map(function (string $characterId) use ($characters) {
                    $character = $characters->get($characterId);

                    return array_merge($character, [
                        'id' => $characterId,
                    ]);
                })
                ->values();

            $voiceActorDetails = $characterDetails
                ->flatMap(fn (array $character) => $character['voice_actor_ids'])
                ->unique()
                ->map(function (string $voiceActorId) use ($voiceActors) {
                    $voiceActor = $voiceActors->get($voiceActorId);

                    return array_merge($voiceActor, [
                        'id' => $voiceActorId,
                    ]);
                })
                ->values();

            return array_merge($anime, [
                'id' => $animeId,
                'characters' => $characterDetails,
                'voice_actors' => $voiceActorDetails,
            ]);
        })->values();

        return view('animes.index', [
            'animes' => $animes,
        ]);
    }

    public function show(string $anime): View
    {
        $data = config('anime');

        $animeData = $data['animes'][$anime] ?? null;

        if ($animeData === null) {
            abort(404);
        }

        $characters = collect($data['characters']);
        $voiceActors = collect($data['voice_actors']);

        $characterDetails = collect($animeData['character_ids'])
            ->map(function (string $characterId) use ($characters, $voiceActors) {
                $character = $characters->get($characterId);

                $voiceActorDetails = collect($character['voice_actor_ids'])
                    ->map(function (string $voiceActorId) use ($voiceActors) {
                        $voiceActor = $voiceActors->get($voiceActorId);

                        return array_merge($voiceActor, [
                            'id' => $voiceActorId,
                        ]);
                    })
                    ->values();

                return array_merge($character, [
                    'id' => $characterId,
                    'voice_actors' => $voiceActorDetails,
                ]);
            })
            ->values();

        $voiceActorDetails = $characterDetails
            ->flatMap(fn (array $character) => $character['voice_actors'])
            ->unique('id')
            ->values();

        return view('animes.show', [
            'anime' => array_merge($animeData, [
                'id' => $anime,
                'characters' => $characterDetails,
                'voice_actors' => $voiceActorDetails,
            ]),
        ]);
    }
}
