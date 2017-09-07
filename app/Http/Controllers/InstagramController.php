<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\instagram\Profile;

class InstagramController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, ['username' => 'required']);
        $username = $request->username;
        $username = $this->getUsernameFormLink($username);
        session(['username' => $username]);
        $profile = new Profile($username);
        $profile = $profile->request();
        if ($profile['code'] == 200 & isset($profile['data']['items'])) {
            if (count($profile['data']['items']) > 0) {
                return view('instagram.profile', compact('profile'));
            } else {
                flash('Can\'t find user or private user', 'danger');
                return back();
            }

        } else {
            flash('Can\'t find user or private user', 'danger');
            return back();
        }
    }

    /**
     * @param $username
     * @return array|mixed
     */
    private function getUsernameFormLink($username)
    {
        if (str_contains($username, 'instagram')) {
            $username = explode('/', $username);
            $username = array_diff($username, ['']);
            $username = last($username);
        }
        return $username;
    }

    public function pagination()
    {
        $max_id = session('last_id');
        $profile_data = new Profile(session('username'), $max_id);
        $profile_data = $profile_data->request();
        return view('instagram.componant.profile_page')->with('items',$profile_data['data']['items']);
    }

    public function download()
    {
        $url = \request()->url;
        $filename = basename($url);
        $download_path = base_path('download/' . $filename);
        copy($url, $download_path);
        return response()->download($download_path)->deleteFileAfterSend(true);
    }
}
/**
 * ["https:", "", "www.instagram.com" ,"shxyxy" , ""]
 */