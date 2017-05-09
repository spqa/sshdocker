<?php

namespace App\Jobs;

use App\Repositories\WPCliRepository;
use App\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SetupWordpressJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $server;
    public $tries=5;

    /**
     * Create a new job instance.
     *
     * @internal param WPCliRepository $WPCliRepository
     */
    public function __construct(Server $server)
    {
     $this->server=$server;
    }

    /**
     * Execute the job.
     *
     * @param WPCliRepository $WPCliRepository
     * @return void
     */
    public function handle(WPCliRepository $WPCliRepository)
    {
//        dd($this->server);
//        try {
            //setup admin account and database
            $WPCliRepository->install(
                $this->server->name,
                $WPCliRepository->dockerRepo->generateName($this->server->name)
            );
            //setup plugin for api call
            $WPCliRepository->install_plugin($this->server->name, 'https://codeload.github.com/WP-API/Basic-Auth/zip/master');

            //tranfer data


//        }catch(\Exception $exception){
//            Log::error($exception->getMessage());
//            Log::error($exception->getTraceAsString());
//        }
    }
}
