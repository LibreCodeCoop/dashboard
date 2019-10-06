<?php

namespace App\Controllers;

class PanelController extends BaseController
{
    public function dashboard()
    {
        $this->render('dashboard.html');
    }
}
