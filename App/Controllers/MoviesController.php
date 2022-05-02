<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Comment;
use App\Models\Movie;
use App\Models\User;

class MoviesController extends Controller
{

    /**
     * Displays all favourite movies receiving data from database.
     * If there are get request parameters, receives data from API resource.
     */
    public function index()
    {
        if (isset($_GET['title']) && $_GET['title'] != '') {
            $searchTitle = trim($_GET['title'], ' ');
            $apiResponse = (isset($_GET['page']) && $_GET['page'] != '') ?
                Movie::searchMoviesByTitle($searchTitle, $_GET['page']) :
                Movie::searchMoviesByTitle($searchTitle);
            $movies = $apiResponse->Search;
            if (isset($movies)) {
                $pages = Movie::countPages($apiResponse->totalResults);
                foreach ($movies as $movie) {
                    $movie->inFavorites = Movie::checkInFavorites($movie->imdbID);
                }
                $this->view->display('index', ['movies' => $movies, 'pages' => $pages]);
            } else {
                $feedback = 'No match was found!';
                $favoriteMovies = Movie::selectAll();
                $this->view->display('index', ['favourites' => $favoriteMovies, 'feedback' => $feedback]);
            }
        } else {
            $favoriteMovies = Movie::selectAll();
            $this->view->display('index', ['favourites' => $favoriteMovies]);
        }
    }

    /**
     * If movie in the favorites list:
     * displays the movie and it's comments receiving data from database.
     * else:
     *receive data from API resource.
     */
    public function show()
    {
        if (isset($_GET['imdbId']) && $_GET['imdbId'] != '') {
            $apiResponse = Movie::getMovieByImdbID($_GET['imdbId']);
            $movie = get_object_vars($apiResponse);
            $this->view->display('show', ['movie' => $movie]);
        } elseif (isset($_GET['favImdbId']) && $_GET['favImdbId'] != '') {
            $movie = Movie::findByColumn('imdbID', $_GET['favImdbId']);
            $movie = get_object_vars($movie[0]);

            $comments = Comment::findByColumn('movie_imdbID', $_GET['favImdbId']);
            foreach ($comments as $comment) {
                $comment->timeDifferance = Comment::timeDifference($comment->time);
                $comment->user = User::findByColumn('id', $comment->user_id)[0];
            }

            $this->view->display('show', ['favouriteMovie' => $movie, 'comments' => $comments]);
        } else {
            echo 'No title is given';
        }
    }

    /**
     * Checks whether movie in the favorites list.
     * If it's not, receives movie's data from API resource, creates instance of Movie and inserts record into database.
     * Redirects to previous page.
     */
    public function store()
    {
        if (isset($_POST['imdbId']) && $_POST['imdbId'] != '') {
            $movie = Movie::findByColumn('imdbID', $_POST['imdbId']);
            if (!isset($movie[0])) {
                try {
                    $apiResponse = Movie::getMovieByImdbID($_POST['imdbId']);
                    $movie = Movie::create($apiResponse);
                    $movie->insert();
                    $this->view->redirect($_POST['url']);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                $this->view->redirect($_POST['url']);
            }
        }
    }

    /**
     * Deletes movie and it's comments from the favorites list.
     * Redirects to main page.
     */
    public function destroy()
    {
        if (isset($_POST['imdbId']) && $_POST['imdbId'] != '') {
            try {
                Comment::deleteByColumn('movie_imdbID', $_POST['imdbId']);
                Movie::deleteByColumn('imdbID', $_POST['imdbId']);
                $this->view->redirect('');
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        } else {
            $this->view->redirect('');
        }
    }
}