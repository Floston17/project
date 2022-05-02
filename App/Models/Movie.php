<?php

namespace App\Models;

use App\Model;
use core\Api\ApiConnection;

class Movie extends Model
{
    protected const TABLE = 'movies';
    public string $imdbID;
    public string $title;
    public string $type;
    public string $rated;
    public string $released;
    public string $runtime;
    public string $genre;
    public string $director;
    public string $writer;
    public string $actors;
    public string $language;
    public string $country;
    public string $awards;
    public string $metascore;
    public string $imdbRating;
    public string $imdbVotes;
    public string $dvd;
    public string $boxOffice;
    public string $production;
    public string $website;
    public string $response;
    public string $plot;
    public string $poster;

    /**
     * Creates instance of Movie class
     */
    public static function create($stdObject)
    {
        $movie = new self;
        $movie->imdbID = $stdObject->imdbID;
        $movie->title = $stdObject->Title;
        $movie->type = $stdObject->Type;
        $movie->rated = $stdObject->Rated;
        $movie->released = $stdObject->Released;
        $movie->runtime = $stdObject->Runtime;
        $movie->genre = $stdObject->Genre;
        $movie->director = $stdObject->Director;
        $movie->writer = $stdObject->Writer;
        $movie->actors = $stdObject->Actors;
        $movie->language = $stdObject->Language;
        $movie->country = $stdObject->Country;
        $movie->awards = $stdObject->Awards;
        $movie->metascore = $stdObject->Metascore;
        $movie->imdbRating = $stdObject->imdbRating;
        $movie->imdbVotes = $stdObject->imdbVotes;
        $movie->dvd = $stdObject->DVD;
        $movie->boxOffice = $stdObject->BoxOffice;
        $movie->production = $stdObject->Production;
        $movie->website = $stdObject->Website;
        $movie->response = $stdObject->Response;
        $movie->plot = $stdObject->Plot;
        $movie->poster = $stdObject->Poster;

        return $movie;
    }

    /**
     * Gets movie by imdbID using API.
     */
    public static function getMovieByImdbID(string $imdbId)
    {
        $searchParams = 'i=' . $imdbId . '&plot=full';
        $url = 'http://www.omdbapi.com/';
        return ApiConnection::connectToApi($url, $searchParams);
    }

    /**
     * Search movies by title using API.
     * Page number can be included.
     */
    public static function searchMoviesByTitle(string $title, string $page = '')
    {
        if ($page != '') {
            $searchParams = 's=' . $title . '&page=' . $page;
        } else {
            $searchParams = 's=' . $title;
        }
        $url = 'http://www.omdbapi.com/';
        return ApiConnection::connectToApi($url, $searchParams);
    }

    /**
     * Checks whether movie is in the favorites list or not.
     */
    public static function checkInFavorites(string $imdbId): bool
    {
        $favoriteMovie = Movie::findByColumn('imdbID', $imdbId);
        return !empty($favoriteMovie);
    }

    /**
     * Counts the number of pages found by the search.
     */
    public static function countPages(string $totalResults)
    {
        return $totalResults % 10 != 0 ? intdiv($totalResults, 10) + 1 : $totalResults / 10;
    }
}