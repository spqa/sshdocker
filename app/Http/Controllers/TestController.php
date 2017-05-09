<?php

namespace App\Http\Controllers;

use App\Jobs\FooBarJob;
use App\Jobs\SetupVPSJob;
use App\Post;
use App\Repositories\WPCliRepository;
use App\Vps;
use Docker\Docker;
use Docker\DockerClient;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public $wpRepo;

    /**
     * TestController constructor.
     * @param $wpRepo
     */
    public function __construct(WPCliRepository $wpRepo)
    {
//        $this->wpRepo = $wpRepo;
//        $vps=Vps::whereIp('45.76.141.64')->first();
//        $this->dispatch(new SetupVPSJob($vps));
        $client = new DockerClient(
            [
                'remote_socket' => "tcp://45.76.141.64:2375",
                'ssl' => false,
            ]
        );
        $docker = new Docker($client);
        $containers = $docker->getContainerManager()->findAll();
        dd($containers);

    }

    public function index()
    {
//        dd($this->wpRepo->install_plugin('sunfrog4.tk','https://codeload.github.com/WP-API/Basic-Auth/zip/master' ));
//        dd($this->wpRepo->insert_post('sunfrog4.tk',Post::find(1) ));
//        DB::connection()->statement('create database hah1');
//        DB::connection()->statement('drop database if exists hah1');


    }
}
