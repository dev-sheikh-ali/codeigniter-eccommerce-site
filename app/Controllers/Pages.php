<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pages extends Controller
{
    public function index()
    {
        $usersModel = new \App\Models\UsersModel();
        $loggedUserID = session()->get('loggedUser');
        $userInfo = $usersModel ->find($loggedUserID);
        $data = [
            'title' => 'The Wardrobe (Home)',
            'userInfo' => $userInfo
        ];
        
        echo view('templates/header', $data);
        echo view('pages/home', $data);
        echo view('templates/footer', $data);
    }

    public function profile()
    {
        $usersModel = new \App\Models\UsersModel();
        $loggedUserID = session()->get('loggedUser');
        $userInfo = $usersModel ->find($loggedUserID);
        $data = [
            'title' => 'profile',
            'userInfo' => $userInfo
        ];
        echo view('templates/header', $data);
        echo view('pages/profile', $data);
        echo view('templates/footer', $data);
    }
}