<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 4/24/2017
 * Time: 3:11 PM
 */

namespace App\Repositories;


use GuzzleHttp\Client;

class SFLaravelRepository
{
    public $client;
    public $apikey='AIzaSyB49NzMIFNlIMmrNg1AnsB3gtBpwjgXOOk';
    /**
     * SFLaravelRepository constructor.
     */
    public function __construct(Client $client)
    {
        $this->client=$client;
    }

    public function change_sunfrog_id($domain,$id){
        $this->client->get('http://'.$domain.'/api/sunfrog/'.$id.'?key='.$this->apikey);
    }

    public function get_sunfrog_id($domain){
        $result=$this->client->get('http://'.$domain.'/api/sunfrog?key='.$this->apikey)->getBody()->getContents();
        return $result;
    }

    public function add_item(){


    }
}