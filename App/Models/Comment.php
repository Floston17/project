<?php

namespace App\Models;

use App\Model;

class Comment extends Model
{
    protected const TABLE = 'comments';
    public int $id;
    public string $movie_imdbID;
    public int $user_id;
    public string $commentary;
    public string $time;
    public string $timeDifferance;
    public User $user;

    /**
     * Creates instance of Comment class
     */
    public static function create($movie_imdbID, $user_id, $commentary): Comment
    {
        $comment = new self;
        $comment->movie_imdbID = $movie_imdbID;
        $comment->user_id = $user_id;
        $comment->commentary = $commentary;
        return $comment;
    }

    /**
     * Calculates time difference between now and when the comment was written.
     */
    public static function timeDifference(string $time): string
    {
        $date = new \DateTime($time);
        $interval = $date->diff(new \DateTime('now'));

        $timeVars = [
            'years' => '%y',
            'months' => '%m',
            'days' => '%d',
            'hours' => '%h',
            'minutes' => '%i'
        ];

        foreach ($timeVars as $key => $value) {
            $timeDifferance[$key] = $interval->format($value);
        }

        if ($timeDifferance['years'] != 0) {
            $timeDiff = $timeDifferance['years'] . ' years ago';
        } elseif ($timeDifferance['months'] != 0) {
            $timeDiff = $timeDifferance['months'] . ' month ago';
        } elseif ($timeDifferance['days'] != 0) {
            $timeDiff = $timeDifferance['days'] . ' days ago';
        } elseif ($timeDifferance['hours'] != 0) {
            $timeDiff = $timeDifferance['hours'] . ' hours ago';
        } elseif ($timeDifferance['minutes'] != 0) {
            $timeDiff = $timeDifferance['minutes'] . ' minutes ago';
        } else {
            $timeDiff = 'less then 1 minute ago';
        }

        return $timeDiff;
    }
}