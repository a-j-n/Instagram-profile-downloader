<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\instagram\Profile;

class InstagramController extends Controller
{
    public function index($username)
    {
        $profile = new Profile($username);
        $profile = $profile->request();
        if ($profile['code'] == 200) {
            dd($profile['data']);
        } else {
            flash('Can\'t find user or private user');
            return back();
        }
    }
}
