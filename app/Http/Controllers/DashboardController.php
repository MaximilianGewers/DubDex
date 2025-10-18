<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimeRequest;
use App\Models\Anime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $animes = Anime::query()
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard', [
            'animes' => $animes,
        ]);
    }

    public function store(StoreAnimeRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $genres = collect(explode(',', $validated['genres'] ?? ''))
            ->map(static fn (string $genre): string => trim($genre))
            ->filter()
            ->values()
            ->all();

        Anime::query()->create([
            'title' => $validated['title'],
            'slug' => $this->generateUniqueSlug($validated['title']),
            'synopsis' => $validated['synopsis'],
            'genres' => $genres,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('status', __('Anime added successfully.'));
    }

    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);

        if ($baseSlug === '') {
            $baseSlug = Str::uuid()->toString();
        }

        $slug = $baseSlug;
        $suffix = 2;

        while (Anime::query()->where('slug', $slug)->exists()) {
            $slug = sprintf('%s-%d', $baseSlug, $suffix);
            $suffix++;
        }

        return $slug;
    }
}
