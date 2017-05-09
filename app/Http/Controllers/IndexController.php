<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpConflictException;
use App\Jobs\SetupWordpressJob;
use App\Repositories\DockerRepository;
use App\Server;
use Collective\Remote\RemoteFacade;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public $dockerRepo;

    /**
     * IndexController constructor.
     */
    public function __construct(DockerRepository $dockerRepository)
    {
        $this->dockerRepo = $dockerRepository;
    }

    public function index()
    {
//        $commands="docker ps";
//        $text='';
//        RemoteFacade::run($commands, function($line)use($text)
//        {
//            $text.= $line.PHP_EOL.'/n';
//        });
//        echo $text;
//        $containers=$this->dockerRepo->getAllContainers();
//        return view('index', compact('containers'));

        return view('index1');
    }

    public function list_domain()
    {
        return Server::all();
    }
}
