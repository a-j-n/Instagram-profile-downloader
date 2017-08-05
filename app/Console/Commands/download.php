<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class download extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'down:load';

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
        $this->info('---------------START---------------');
        $LinksFile = base_path('insta2');
        $read = file_get_contents($LinksFile);
        $read = trim($read);
        $read = explode(PHP_EOL, $read);
        dd($read);
        $x = 0;
        foreach ($read as $link) {
            $this->info('handel : ' . $link);
            $fileName = last(explode('/', $link));
            $this->info($x . "- Download file :" . $fileName);
            try{
                copy($link, base_path('download/' . $fileName));
            }catch (\Exception $exception){
                $this->error('fail at :'.$link);
            }

            file_put_contents($LinksFile,str_replace($link.PHP_EOL,null,file_get_contents($LinksFile)));
            $x++;
        }
        $this->info('---------------END---------------');


    }
}
