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
        if ($profile['code'] == 200 & count($profile['data']['items']) > 0) {
            return view('instagram.profile', compact('profile'));
        } else {
            flash('Can\'t find user or private user', 'danger');
            return back();
        }
    }

    public function download()
    {
        $url = \request()->url;
        $filename = basename($url);
        $download_path = base_path('/download/' . $filename);
        copy($url, $download_path);
        return response()->download($download_path)->deleteFileAfterSend(true);
    }
}
