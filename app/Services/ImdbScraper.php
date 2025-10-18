<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use App\DTO\ImdbTitle;

class ImdbScraper
{
    public function getMovie(string $imdbId): array
    {
        $url = "https://www.imdb.com/title/{$imdbId}/";
        $html = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0',
        ])->get($url)->body();

        $crawler = new Crawler($html);

        return [
            'title' => trim($crawler->filter('h1')->text('')),
            'rating' => trim($crawler->filter('span[data-testid="hero-rating-bar__aggregate-rating__score"]')->text('')),
            'summary' => trim($crawler->filter('span[data-testid="plot-xl"]')->text('')),
        ];
    }

    /**
     * Search IMDb for anime titles matching the query.
     *
     * @param string $query
     * @return ImdbTitle[]
     */
    public function search(string $query): array
    {
        $url = 'https://www.imdb.com/search/title/?genres=animation&keywords=' . urlencode($query);
        $html = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0',
        ])->get($url)->body();

        $crawler = new Crawler($html);
        $results = [];

        // Each result row
        $crawler->filter('.ipc-metadata-list-summary-item')->each(function (Crawler $node) use (&$results) {
            $titleNode = $node->filter('a.ipc-title-link-wrapper');
            if ($titleNode->count() === 0) {
                return;
            }

            // Raw title may include "1. Naruto"
            $rawTitle = trim($titleNode->text());
            $title = preg_replace('/^\d+\.\s*/', '', $rawTitle);
            
            $url = 'https://www.imdb.com' . $titleNode->attr('href');

            $year = null;
            if ($node->filter('span.ipc-title__meta-year')->count()) {
                $year = trim($node->filter('span.ipc-title__meta-year')->text());
            }

            $results[] = new ImdbTitle(
                title: $year ? "{$title} ({$year})" : $title,
                url: $url,
            );
        });

        return $results;
    }
}
