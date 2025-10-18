<?php

namespace App\Jobs;

use App\Enums\ScrapeStatus;
use App\Models\Anime;
use App\Services\ImdbScraper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;

class ImdbTitleListFetcher implements ShouldQueue
{
    use Queueable;

    private string $title;

    /**
     * Create a new job instance.
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Execute the job.
     */
    public function handle(ImdbScraper $imdbScraper): void
    {
        $result = $imdbScraper->search($this->title);

        // todo - do not enter duplicate. 
        foreach ($result as $item) {
            try {
                $newAnime = new Anime();
                $newAnime->title = $item->title;
                $newAnime->slug =  Str::slug($item->title);
                $newAnime->synopsis = 'todo';
                // todo - imdb url
                // $newAnime->url = $item->url;
                $newAnime->scrape_status = ScrapeStatus::NEEDS_DATA;
                $newAnime->save();
            } catch (\Exception $e) {
                // todo log
            }
        }
    }
}