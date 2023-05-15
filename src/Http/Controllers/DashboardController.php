<?php

namespace Admin\Http\Controllers;

class DashboardController
{
    public function index()
    {
        return view('admin::dashboard.index');
    }
}
