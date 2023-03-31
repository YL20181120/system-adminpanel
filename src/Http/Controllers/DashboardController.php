<?php

namespace System\Http\Controllers;

class DashboardController
{
    public function index()
    {
        return view('system::dashboard.index');
    }
}
