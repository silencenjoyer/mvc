<?php

declare(strict_types=1);

namespace app\controllers;

use app\core\Controller;

class SiteController extends Controller
{
    public function homepage(): string
    {
        return $this->render('homepage');
    }

    public function feedback(): string
    {
        return $this->render('feedback');
    }
}