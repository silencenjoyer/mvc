<?php

declare(strict_types=1);

namespace app\controllers;

use app\core\Controller;
use app\core\MVC;
use app\models\RegisterModel;

class SiteController extends Controller
{
    public function homepage(): string
    {
        $name = 'Andrey';
        return $this->render('homepage');
    }

    public function register(): string
    {

        $model = new RegisterModel();

        if (MVC::$app->request->isPost()) {
            $model->load(MVC::$app->request->post());
            $model->validate();
        }

        return $this->render('register', [
            'model' => $model
        ]);
    }
}
