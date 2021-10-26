<?php

namespace App\Utils;

/**
 * Classe permettant de communiquer avec l'API OMDB Api
 */
class Slug {

    public function slugger($movieNameToSlug)
    {
        $slugged = preg_replace('~[^\pL\d]+~u', '-', $movieNameToSlug);
        return $slugged;
    }
}