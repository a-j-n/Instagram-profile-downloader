<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InstaUser extends Command
{

    protected $items = [];
    protected $page = 0;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insta:user {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DownLoad UserTimeLine';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->argument('user');
        $this->info('Start Find Photos of ' . $user);
        $profile = $this->getProfile($user);
        $this->fetchAllProfileData($profile, $user);
        foreach ($this->items as $item) {
            if ($item['type'] == 'image') {
                $urls[] = $this->getLinkFromItem($item);
            } elseif ($item['type'] == 'video') {
                $urls[] = $item['videos']['standard_resolution']['url'];
            }elseif($item['type'] = 'carousel'){
                foreach ($item['carousel_media'] as $media ){
                    $urls[] = $media['images']['standard_resolution']['url'];
                }

            }
        }
        $pathToDownload = $this->CreateDirectoryForUser($user);
        $this->DownloadUrls($urls, $pathToDownload);
    }

    private function getProfile($user, $max_id = null)
    {
        if (!$max_id) {
            $profile = new \App\instagram\Profile($user);
        } else {
            $profile = new \App\instagram\Profile($user, $max_id);
        }

        $request = $profile->request();
        $this->page = $this->page + 1;
        $this->comment('Get photos form page -> ' . $this->page);
        if ($request['code'] == 200 && count($request['data']['items']) != 0) {
            return $request['data'];
        }

        $this->warn('it\'s private user or not founded ');
    }

    private function fetchAllProfileData($json, $user)
    {
        $this->GetItemsFormPage($json);
        if ($json['more_available'] == true) {
            $newPage = $this->getProfile($user, end($this->items)['id']);
            $this->fetchAllProfileData($newPage, $user);
        }

    }

    private function GetItemsFormPage($json)
    {
        foreach ($json['items'] as $item) {
            $this->items[] = $item;
        }

    }

    private function getLinkFromItem(array $array)
    {

        return $array['images']['standard_resolution']['url'];


    }

    private function CreateDirectoryForUser($user)
    {
        $download_path = env('DOWNLOAD_PATH');
        if (!$download_path) {
            $this->info('you don\'t define download path on env file so it\'s will be in download folder  ' . base_path('download'));
            $download_path = base_path('download');
        }
        if (!file_exists($download_path . "/" . $user)) {
            mkdir($download_path . "/" . $user, 0777, true);
        }
        return $download_path . "/" . $user;
    }

    /**
     * @param $urls
     * @param $pathToDownload
     */
    private function DownloadUrls($urls, $pathToDownload)
    {
        $photosCount = count($urls) + 1;
        $this->info("Downloading " . $photosCount . " photo ");
        $countOfDownload = 0;
        foreach ($urls as $url) {
            $countOfDownload++;
            $fileName = last(explode('/', $url));
            if (!file_exists($pathToDownload . "/" . $fileName)) {
                $this->comment(($countOfDownload + 1) . " Of " . $photosCount . "- download " . $fileName);
                try {
                    copy($url, $pathToDownload . "/" . $fileName);
                } catch (\Exception $exception) {
                    $this->error('can\'t download ' . $fileName);
                    continue;
                }
            } else {
                $this->info($fileName . " Already downloaded");
            }
        }
    }
}
