<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 4/15/2017
 * Time: 4:18 PM
 */

namespace App\Repositories;


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
        if (!Cache::has('port')){
            Cache::put('port',5000);
        }
        Cache::increment('port');
        $port=Cache::get('port');
        $params = [
            'body' => json_encode([
                'Image' => 'wordpress',
                'Env' => [
                    "VIRTUAL_HOST=" . $domain,
                    "WORDPRESS_DB_NAME=" . $domain,
                    "WORDPRESS_DB_PASSWORD=example"
                ],
                'HostConfig' => [
                    'PortBindings' => ['80/tcp' => [["HostPort" => $port . "", "HostIp" => ""]]],
                    'NetworkMode' => 'docker_default'
                ],
                'PublishAllPorts' => true,

            ]),
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ];
//        dd($params);
        $notvalid = true;


        $result = $this->client->request('post', $this->endpoint . '/containers/create?name=' . str_replace('.', '', $domain), $params);
        return $result;

    }

    public function start($id)
    {
        $this->client->request('post', $this->endpoint . '/containers/' . $id . '/start?detachKeys=ctrl-p ctrl-q');
    }

    public function delete($id)
    {
        $this->client->request('delete', $this->endpoint . '/containers/' . $id . '?force=true');
    }
}