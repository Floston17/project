<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Comment;

class CommentsController extends Controller
{

    /**
     * Creates new Comment and inserts it into comments table.
     */
    public function store()
    {
        if (isset($_POST['commentary']) && $_POST['commentary'] != ''
            && isset($_POST['imdbId']) && $_POST['imdbId'] != '') {
            $comment = Comment::create(
                $_POST['imdbId'],
                $_SESSION['userId'],
                htmlspecialchars($_POST['commentary'], ENT_HTML5)
            );
            $comment->insert();
            $this->view->redirect('movie?favImdbId=' . $_POST['imdbId']);

        }
    }

    /**
     * Deletes the comment from comments table.
     */
    public function destroy()
    {
        if (isset($_POST['id']) && $_POST['id'] != '') {
            try {
                Comment::deleteByColumn('id', $_POST['id']);
                $this->view->redirect($_POST['url']);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}