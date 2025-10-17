<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class VoiceActorController extends Controller
{
    public function index(): View
    {
        $data = config('anime');

        $animes = collect($data['animes']);
        $characters = collect($data['characters']);

        $voiceActors = collect($data['voice_actors'])->map(function (array $voiceActor, string $voiceActorId) use ($characters, $animes) {
            $roles = $characters
                ->filter(fn (array $character) => in_array($voiceActorId, $character['voice_actor_ids'], true))
                ->map(function (array $character, string $characterId) use ($animes) {
                    $anime = $animes->get($character['anime_id']);

                    return [
                        'character_id' => $characterId,
                        'character_name' => $character['name'],
                        'character_role' => $character['role'],
                        'anime_id' => $character['anime_id'],
                        'anime_title' => $anime['title'] ?? 'Unknown Anime',
                    ];
                })
                ->values();

            if ($roles->isEmpty()) {
                return null;
            }

            return array_merge($voiceActor, [
                'id' => $voiceActorId,
                'roles' => $roles->all(),
                'anime_count' => $roles->pluck('anime_id')->unique()->count(),
                'character_count' => $roles->count(),
            ]);
        })
            ->filter()
            ->values();

        return view('voice-actors.index', [
            'voiceActors' => $voiceActors,
        ]);
    }
}
