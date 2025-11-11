<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        helper('html'); // Load the HTML helper
    }

    public function index(): string
    {
        return view('home');

    }
}
