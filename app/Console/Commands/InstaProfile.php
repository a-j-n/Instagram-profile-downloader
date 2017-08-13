<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\instagram\Profile;

class InstaProfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insta:profile {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download public instagram profile';

    protected $user;
    protected $items = [];
    protected $page = 0;

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

        $this->user = $this->argument('user');

        $this->comment('Start Find Photos of ' . $this->user);

        $this->downloadPage();

        $this->comment('Oki i\'m done boss :)  ');
    }

    private function downloadPage($max_id = null)
    {
        $profile = $this->getProfile($this->user, $max_id);

        $this->getItemsFormPage($profile);
        $this->downloadItems();
        if ($profile['more_available'] == true) {
            $this->downloadPage(end($profile['items'])['id']);
        }

    }

    private function getProfile($user, $max_id = null)
    {
        $profile = new Profile($user, $max_id);
        $request = $profile->request();

        $this->page = $this->page + 1;
        $this->comment('Get photos form page -> ' . $this->page);
        if ($request['code'] == 200 && count($request['data']['items']) != 0) {
            return $request['data'];
        }
        $this->info('it\'s private user or not founded');
        die();

    }

    private function getItemsFormPage($json)
    {
        foreach ($json['items'] as $item) {
            $this->items[] = $item;
        }

    }

    private function downloadItems()
    {
        foreach ($this->items as $item) {
            $links[] = $this->getLinkFromItem($item);
        }
        $links = array_collapse($links);
        $this->downloadLinks($links);

    }

    private function getLinkFromItem(array $item)
    {
        if ($item['type'] === 'image') {
            $urls[] = $item['images']['standard_resolution']['url'];
        } elseif ($item['type'] === 'video') {
            $urls[] = $item['videos']['standard_resolution']['url'];
        } elseif ($item['type'] === 'carousel') {
            foreach ($item['carousel_media'] as $media) {
                if (isset($media['images'])) {
                    $urls[] = $media['images']['standard_resolution']['url'];
                } else {
                    $urls[] = $media['videos']['standard_resolution']['url'];
                }

            }
        }
        return $urls;


    }

    private function downloadLinks(array $links)
    {
        $pathToDownload = $this->createDirectoryForUser();
        $photosCount = count($links);
        $this->info("Downloading " . $photosCount . " photo ");
        $countOfDownload = 1;
        $this->output->progressStart($photosCount);
        foreach ($links as $url) {
            $fileName = last(explode('/', $url));
            if (!file_exists($pathToDownload . "/" . $fileName)) {
                // $this->comment(($countOfDownload + 1) . " Of " . $photosCount . "- download " . $fileName);
                try {
                    copy($url, $pathToDownload . "/" . $fileName);
                } catch (\Exception $exception) {
                    $this->error('can\'t download ' . $fileName);
                    continue;
                }
            } else {
                $this->info($fileName . " Already downloaded");
            }
            $countOfDownload++;
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
        $this->items = [];
    }

    private function createDirectoryForUser()
    {
        $download_path = env('DOWNLOAD_PATH');
        if (!$download_path) {
            $this->info('you don\'t define download path on env file so it\'s will be in download folder  ' . base_path('download'));
            $download_path = base_path('download');
        }
        if (!file_exists($download_path . "/" . $this->user)) {
            mkdir($download_path . "/" . $this->user, 0777, true);
        }
        return $download_path . "/" . $this->user;
    }
}
