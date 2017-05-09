<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpConflictException;
use App\Jobs\SetupWordpressJob;
use App\Jobs\UpdateSunfrogBatch;
use App\Repositories\DockerRepository;
use App\Repositories\SFLaravelRepository;
use App\Server;
use App\Vps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContainerController extends Controller
{
    public $dockerRepo;
    public $sfRepo;

    /**
     * ContainerController constructor.
     * @param $dockerRepo
     */
    public function __construct(DockerRepository $dockerRepo, SFLaravelRepository $laravelRepository)
    {
        $this->dockerRepo = $dockerRepo;
        $this->sfRepo = $laravelRepository;
    }


    public function add()
    {
        $vps = Vps::all();
        return view('container.add', compact('vps'));
    }

    public function create_container()
    {
        $domain = \request('domain');
        $keyword = \request('keyword');
        $vps_id = \request('vps_id');
        $vps = Vps::findOrFail($vps_id);
//        dd($vps);
        try {
            $this->dockerRepo->endpoint = 'http://' . $vps->ip . ':2375';
            $result = $this->dockerRepo->add($domain, $keyword);
//            dd($result);
        } catch (HttpConflictException $exception) {
            return back()->with(['message' => 'conflict domain!']);
        }
        $server = Server::firstOrCreate([
            'docker_id' => $result->Id,
            'vps_id' => $vps_id,
            'name' => $domain,
            'username' => 'captainsunfrog',
            'password' => 123456789,
            'sunfrog_acc_id' => 1,
            'keyword' => $keyword
        ]);

//        dispatch( new SetupWordpressJob($server));
//        dd($result);
        return redirect('/')->with('message', 'server created !');
    }

    public function start_container($id)
    {
        $this->dockerRepo->start($id);
        return back()->with('message', 'server started!');
    }

    public function delete_container($id)
    {
        $this->dockerRepo->delete($id);
        $server = Server::whereName($id)->orWhere('docker_id', $id)->first();
        if ($server) {
            $server->delete();
        }

        return back()->with('message', 'server deleted!');
    }

    public function change_sunfrog_id($domain = null)
    {
        if ($domain == null) {
            if (!empty(\request('sunfrog'))) {
                Cache::forever('SUNFROG_ID', \request('sunfrog'));
                dispatch(new UpdateSunfrogBatch());
                return back()->with('message', 'Processing ...');
            } else {
                return back();
            }
        }

        $id = \request('id');
        $this->sfRepo->change_sunfrog_id($domain, $id);
        return back();
    }

    public function edit_sunfrog_id($domain = null)
    {
        if ($domain == null) {
            $result = cache('SUNFROG_ID');
            return view('container.sunfrog', compact('result'));
        }
        $result = $this->sfRepo->get_sunfrog_id($domain);
        return view('container.sunfrog', compact('result'));
    }


    public function index()
    {
        $servers = Server::orderBy('created_at', 'desc')->paginate(10);
        return view('container.index', compact('servers'));
    }
}
