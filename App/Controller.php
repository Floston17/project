<?php

namespace App;

abstract class Controller
{
    public View $view;

    public function __construct()
    {
        $this->view = new View();
    }
}