<?php

namespace App\Repositories;

use App\SpotifyUser;
use App\User;
use GuzzleHttp\Client;

class SpotifyRepository
{
    /** @var Client */
    private $client;

    /** @var SpotifyUser */
    private $user;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getProfile(string $accessToken)
    {
        return \json_decode($this->get('me', $accessToken)->getBody());
    }

    public function getTopTracks(SpotifyUser $user)
    {
        return $this->get(
            'me/top/tracks',
            $user->access_token,
            [
                'query' => [
                    'limit' => 50,
                ],
            ]
        );
    }

    public function refreshToken(User $user): void
    {
        $refreshToken = $this->client->post(
            'https://accounts.spotify.com/api/token',
            [
                'form_params' => [
                    'client_id' => config("services.spotify.client_id"),
                    'client_secret' => config("services.spotify.client_secret"),
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $user->refresh_token,
                    'redirect_uri' => config("services.spotify.redirect"),
                ],
            ]
        );

        $refreshToken = json_decode($refreshToken->getBody());

        $user->access_token = $refreshToken->access_token;

        if (isset($refreshToken->refresh_token)) {
            $user->refresh_token = $refreshToken->refresh_token;
        }

        $user->save();
    }

    public function get(string $uri, string $accessToken, array $data = [])
    {
        return $this->spotifyCall('GET', $uri, $accessToken, $data);
    }

    public function post(string $uri, string $accessToken, array $data = [])
    {
        return $this->spotifyCall('POST', $uri, $accessToken, $data);
    }

    public function put(string $uri, string $accessToken, array $data = [])
    {
        return $this->spotifyCall('PUT', $uri, $accessToken, $data);
    }

    private function spotifyCall(string $method, string $uri, string $accessToken, array $data)
    {
        return $this->client->request(
            $method,
            "https://api.spotify.com/v1/$uri",
            \array_merge(
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $accessToken,
                    ],
                ],
                $data
            )
        );
    }
}
