<?php

namespace App\Jobs;

use App\Vps;
use Collective\Remote\RemoteFacade;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;

class ResetVPSJob implements ShouldQueue
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
        $commands = [
            'docker stop $(docker ps -a -q)',
            'yum -y remove docker-ce',
            'rm -rf /var/lib/docker',
            'rm -rf /etc/docker',
            'rm /var/run/docker.pid'
        ];

        Config::set('remote.connections.runtime.host', $this->vps->ip);
        Config::set('remote.connections.runtime.port', !empty($this->vps->port) ? $this->vps->port : 22);
        Config::set('remote.connections.runtime.username', !empty($this->vps->username) ? $this->vps->username : 'root');
        Config::set('remote.connections.runtime.password', $this->vps->password);

        RemoteFacade::into('runtime')->run($commands, function ($line) {
            $this->vps->progress .= $line . PHP_EOL;
            $this->vps->save();
        });

        $this->vps->status = 'Reset Successfully!';
        $this->vps->save();

        dispatch(new SetupVPSJob($this->vps));
    }
}
