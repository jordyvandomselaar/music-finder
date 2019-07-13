<?php

namespace App\Console\Commands;

use App\Album;
use App\Artist;
use App\Repositories\SpotifyRepository;
use App\SpotifyUser;
use App\Track;
use Illuminate\Console\Command;

class SyncSpotifyUserTracksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotify:syncUserTracks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync a user\'s tracks.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->addArgument('id', null, 'Spotify user id');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var SpotifyUser $spotifyUser */
        $spotifyUser = SpotifyUser::findOrFail($this->argument('id'));
        $spotifyRepository = new SpotifyRepository($spotifyUser->access_token);
        $topTracksResponse = $spotifyRepository->getTopTracks($spotifyUser);

        $topTracks = \json_decode($topTracksResponse->getBody());

        $tracks = array_map(
            function ($topTrack): Track {
                /** @var Album $album */
                $album = Album::firstOrCreate(
                    [
                        'spotify_id' => $topTrack->album->id,
                    ],
                    [
                        'name' => $topTrack->album->name,
                    ]
                );

                /** @var Track $track */
                $track = Track::firstOrCreate(
                    [
                        'spotify_id' => $topTrack->id,
                    ],
                    [
                        'name' => $topTrack->name,
                        'popularity' => $topTrack->popularity,
                        'album_id' => $album->id,
                    ]
                );

                // Store artists
                $artists = array_map(
                    function ($artist) {
                        return Artist::firstOrCreate(
                            [
                                'spotify_id' => $artist->id,
                            ],
                            [
                                'name' => $artist->name,
                            ]
                        );
                    },
                    $topTrack->artists
                );

                $track->artists()->sync(collect($artists)->pluck('id'));
                $album->artists()->sync(collect($artists)->pluck('id'));

                return $track;
            },
            $topTracks->items
        );

        $spotifyUser->tracks()->syncWithoutDetaching(collect($tracks)->pluck('id'));
    }
}
