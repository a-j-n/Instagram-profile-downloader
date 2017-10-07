<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insta:update';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $x = 1;
        $folders = scandir(env('DOWNLOAD_PATH'));
        $folders = array_diff($folders, ['.', '..', '.DS_Store']);
        $this->comment("I'm checking " . count($folders) . " Folder");
         shuffle($folders);

        foreach ($folders as $folder) {
            $this->line('This folder number '.$x);
            \Artisan::call("insta:profile",['user'=>$folder],$this->output);
            $x++;
        }
    }
}
