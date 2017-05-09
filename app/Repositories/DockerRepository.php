<?php

namespace App\Repositories;


use App\Exceptions\HttpConflictException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class DockerRepository
{
    public $ip = 'http://45.76.101.61';
    public $port = '2375';
    public $client;
    public $endpoint = '';

    /**
     * DockerRepository constructor.
     * @param string $ip
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->endpoint = $this->ip . ':' . $this->port;
    }


    public function getAllContainers()
    {
        $result = $this->client->request('get', $this->endpoint . '/containers/json?all=true');
        $containers = json_decode($result->getBody());
        return $containers;
    }

    public function add($domain, $keywords)
    {
        if (empty(Cache::get('port'))) {
            Cache::forever('port', 5000);
        }
        Cache::increment('port');
        $port = Cache::get('port');
//        dd($port);
        $params = [
            'body' => json_encode([
                'Image' => 'spqa/sflaravel',
                'Env' => [
                    "VIRTUAL_HOST=" . $domain,
                ],
                'HostConfig' => [
                    'PortBindings' => ['80/tcp' => [["HostPort" => '' . "", "HostIp" => ""]]],
//                    'NetworkMode' => 'docker_default'
                ],

            ]),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'http_errors' => false
        ];

        $result = $this->client->request('post', $this->endpoint . '/containers/create?name=' . $this->generateName($domain), $params);
//        dd($result->getBody()->getContents());
        if ($result->getStatusCode() == 409) {
            throw new HttpConflictException();
        }
        $this->start($this->generateName($domain));
        return json_decode($result->getBody()->getContents());

    }

    public function start($id)
    {
        $result = $this->client->request('post', $this->endpoint . '/containers/' . $id . '/start?detachKeys=ctrl-p ctrl-q');

    }

    public function delete($id)
    {
        $this->client->request('delete', $this->endpoint . '/containers/' . $id . '?force=true');
    }

    public function getIdByName($name)
    {
        return $this->getAllInfo($name)['Id'];
    }

    public function getAllInfo($name)
    {
        return json_decode($this->client->get($this->endpoint . '/containers/' . $name . '/json'));
    }


    public function generateName($domain)
    {
        return str_replace('-', '', str_slug($domain));
    }

    public function exec($id, $command)
    {
        $params = [
            'body' => json_encode([
                'AttachStdin' => true,
                'AttachStdout' => true,
                'AttachStderr' => true,
                'DetachKeys' => 'ctrl-p,ctrl-q',
                'Tty' => false,
                'Cmd' => $command
            ]),
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ];
//        dd(json_encode($params));
        $exec_id = json_decode($this->client->post($this->endpoint . '/containers/' . $id . '/exec', $params)->getBody()->getContents())->Id;
        $result = $this->client->post($this->endpoint . '/exec/' . $exec_id . '/start', ['json' => [
            "Detach" => false,
            'Tty' => false
        ]])->getBody()->getContents();
        return $result;
    }

    public function setup_nginx()
    {
        $params = [
            'body' => json_encode([
                'Image' => 'jwilder/nginx-proxy',
                'HostConfig' => [
                    'PortBindings' => ['80/tcp' => [["HostPort" => "80", "HostIp" => ""]]],
//                    'NetworkMode' => 'docker_default'
                    'Binds' => [
                        '/var/run/docker.sock:/tmp/docker.sock:ro'
                    ]
                ],


            ]),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'http_errors' => false
        ];

        $result = $this->client->request('post', $this->endpoint . '/containers/create?name=nginxproxy', $params);
        $this->start('nginxproxy');
        return $result;
    }

    public function build($image, $tag)
    {
        $result = $this->client->request('post', $this->endpoint . '/images/create?fromImage=' . $image . '&tag=' . $tag);

        return $result->getBody()->getContents();
    }
}