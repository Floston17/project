<?php

namespace App\Controllers;

use App\Controller;
use App\Models\User;

class SessionsController extends Controller
{
    /**
     * Shows login page.
     */
    public function create()
    {
        $this->view->display('login');
    }

    /**
     * Checks email if it's not registered.
     * Authorises user if password is verified.
     * Redirects to home page.
     */
    public function store()
    {
        if ($_POST['email'] && $_POST['password']) {
            try {
                $user = User::findByEmail($_POST['email']);
            } catch (\Exception $e) {
                $this->view->display('login', ['error' => $e->getMessage()]);
                die();
            }

            if (password_verify($_POST['password'], $user->password)) {
                SessionsController::auth($user);
                $this->view->redirect('');
            } else {
                $this->view->display('login', ['error' => 'Вы неправильно ввели пароль!']);
            }
        } else {
            $this->view->display('login', ['error' => 'Вы не заполнили все поля!']);
        }
    }

    /**
     * Regenerates sessions id.
     * Login the user.
     */
    public static function auth($user)
    {
        session_regenerate_id();
        $_SESSION['userName'] = $user->name;
        $_SESSION['userId'] = $user->id;
        $_SESSION['admin'] = $user->admin;
    }

    /**
     * Logout the user.
     */
    public function destroy()
    {
        unset($_SESSION['userName']);
        unset($_SESSION['userId']);
        unset($_SESSION['admin']);

        $this->view->redirect('');
    }
}