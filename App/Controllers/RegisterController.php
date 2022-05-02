<?php

namespace App\Controllers;

use App\Controller;
use App\Exceptions\EmailException;
use App\Models\User;
use App\Validation;

class RegisterController extends Controller
{
    /**
     * Shows register page
     */
    public function create()
    {
        return $this->view->display('register');
    }

    /**
     * Checks email if it's already registered.
     * Validates input data of register page.
     * Creates new user, inserts him into user and authorises him.
     * Redirects to home page.
     */
    public function store()
    {
        if ($_POST['name'] && $_POST['email'] && $_POST['city'] && $_POST['password']) {
            try {
                $user = User::findByEmail(($_POST['email']));
                if ($user instanceof User) {
                    $this->view->display('register', ['error' => 'This email is already registered!']);
                }
            } catch (EmailException $e) {
                $validation = Validation::validate($_POST['name'], $_POST['email'], $_POST['city'], $_POST['password']);
                if (!is_array($validation)) {
                    try {
                        $user = User::create($_POST['name'], $_POST['email'], $_POST['city'], $_POST['password']);
                        $user->insert();
                        SessionsController::auth($user);
                        $this->view->redirect('');
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }
                } else {
                    $errors = $validation;
                    $this->view->display('register', $errors);
                }
            }
        } else {
            $this->view->display('register', ['error' => 'Some fields are empty!']);
        }
    }
}