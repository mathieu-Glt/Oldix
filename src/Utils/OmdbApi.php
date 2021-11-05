<?php

namespace App\Utils;

/**
 * Classe permettant de communiquer avec l'API OMDB Api
 */
class OmdbApi
{

    public function getInfosFromApi(string $movieTitle)
    {
        // J'encode le titre du film passé en parametre
        $movieEncoded = urlencode($movieTitle);
        // Je fais appel à omdbApi pour recuperer les infos du film
        $json = file_get_contents("http://www.omdbapi.com/?&apikey=" . $_ENV['OMDBAPIKEY'] . "&t=" . $movieEncoded);
        $movieInfos = json_decode($json);
        return $movieInfos;
    }
}
