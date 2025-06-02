<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        // Dummy user data for development
        $user = (object)[
            'name' => 'John Doe',
            'profile_photo_url' => 'https://ui-avatars.com/api/?name=John+Doe&background=0D8ABC&color=fff',
        ];

        return view('dashboard', compact('user'));
    }
}