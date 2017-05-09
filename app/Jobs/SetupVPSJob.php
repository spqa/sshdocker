<?php

namespace App\Jobs;

use App\Repositories\DockerRepository;
use App\Vps;
use Collective\Remote\RemoteFacade;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;

class SetupVPSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $vps;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Vps $vps)
    {
        $this->vps = $vps;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Config::set('remote.connections.runtime.host', $this->vps->ip);
        Config::set('remote.connections.runtime.port', !empty($this->vps->port) ? $this->vps->port : 22);
        Config::set('remote.connections.runtime.username', !empty($this->vps->username) ? $this->vps->username : 'root');
        Config::set('remote.connections.runtime.password', $this->vps->password);

        $commands = [
            'firewall-cmd --zone=public --permanent --add-port=2375/tcp',
            'firewall-cmd --reload',
//            'sudo yum install -y yum-utils',
//            'sudo yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo',
//            'sudo yum-config-manager --disable docker-ce-edge',
//            'sudo yum makecache fast',
//            'sudo yum -y install docker-ce ',
            'wget -qO- https://get.docker.com/ | sh'

        ];
        RemoteFacade::into('runtime')->run($commands, function ($line) {
            $this->vps->progress .= $line . PHP_EOL;
            $this->vps->save();
        });

        RemoteFacade::into('runtime')->putString('/etc/docker/daemon.json',
            '{
            "hosts": ["tcp://' . $this->vps->ip . ':2375","unix:///var/run/docker.sock"]
            } '
        );
//
        $commands = [
            'service docker restart'
        ];
        RemoteFacade::into('runtime')->run($commands, function ($line) {
            $this->vps->progress .= $line . PHP_EOL;
            $this->vps->save();
        });

        $dockerRepo = new DockerRepository(new Client());
        $dockerRepo->endpoint = 'http://' . $this->vps->ip . ':' . $dockerRepo->port;
        $result = $dockerRepo->build('jwilder%2Fnginx-proxy', 'latest');
//        $dockerRepo->setup_nginx();

        $this->vps->status = 'ready';
        $this->vps->save();
        $commands = [
            'docker run -d -p 80:80 -v /var/run/docker.sock:/tmp/docker.sock:ro jwilder/nginx-proxy'];

        RemoteFacade::into('runtime')->run($commands, function ($line) {
            $this->vps->progress .= $line . PHP_EOL;
            $this->vps->save();
        });

    }
}
