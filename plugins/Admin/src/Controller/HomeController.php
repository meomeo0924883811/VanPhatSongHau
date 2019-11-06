<?php

namespace Admin\Controller;

use Admin\Controller\AppController;

class HomeController extends AppController
{

    public function index()
    {
        return $this->redirect(["controller" => "Users", "action" => "index"]);
    }

    public function icon()
    {

    }
}