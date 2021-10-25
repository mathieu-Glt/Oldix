<?php

namespace App\Utils;

/**
 * Classe permettant de communiquer avec l'API OMDB Api
 */
class OmdbApi {

    public function getInfosFromApi(string $movieTitle) {
        $movieEncoded = urlencode($movieTitle);
        $json = file_get_contents("http://www.omdbapi.com/?&apikey=bfe2847c&t=" . $movieEncoded);
        $movieInfos = json_decode($json);
        return $movieInfos;
    }
}