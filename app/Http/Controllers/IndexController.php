<?php

namespace App\Http\Controllers;

use App\Repositories\DockerRepository;
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

        $containers=$this->dockerRepo->getAllContainers();
        return view('index', compact('containers'));
    }


    public function add()
    {

        return view('container.add');
    }

    public function create_container()
    {
        $domain=\request('domain');
        $result=$this->dockerRepo->add($domain,'');
//        dd($result);
        return redirect('/')->with(['message'=>'server created press start to start server!']);
    }

    public function start_container($id){
        $this->dockerRepo->start($id);
        return back()->with('message','server started!');
    }

    public function delete_container($id){
        $this->dockerRepo->delete($id);
        return back()->with('message','server deleted!');
    }
}
