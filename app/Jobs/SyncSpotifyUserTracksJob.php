<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class SyncSpotifyUserTracksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int */
    private $spotifyUserId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $spotifyUserId)
    {
        $this->spotifyUserId = $spotifyUserId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call(
            'spotify:syncUserTracks',
            [
                'id' => $this->spotifyUserId,
            ]
        );
    }
}
