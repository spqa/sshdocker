<?php
/**
 * Created by PhpStorm.
 * User: super
 * Date: 4/18/2017
 * Time: 4:18 PM
 */

namespace App\Repositories;


use App\Post;

class WPCliRepository

{
    public $dockerRepo;
    public $client;

    /**
     * WPCliRepository constructor.
     * @param $dockerRepo
     */
    public function __construct(DockerRepository $dockerRepo)
    {
        $this->dockerRepo = $dockerRepo;
        $this->client=$dockerRepo->client;
    }

    public function install($domain, $title)
    {
        $result = $this->dockerRepo->exec($this->dockerRepo->generateName($domain), ['wp', 'core', 'install --url=' . $domain . ' --title=' . $title . ' --admin_user=captainsunfrog --admin_password=123456789 --admin_email=admin@gmail.com --skip-email']);
        return $result;
    }

    public function insert_post($domain, $post)
    {
//        $result = $this->dockerRepo->exec($this->dockerRepo->generateName($domain), ['wp', 'post', 'create
//        --post=' . $post->title . '
//        --post-content=' . $post->description]);
        $endpoint='/wp-json/wp/v2/posts';
        $params=[
            'form_params'=>[
                'title'=>$post->title,
                'post_status'=>'publish',
                'post_content'=>$post->description
            ],
            'auth'=>[
                'captainsunfrog','123456789'
            ]
        ];
        $result=$this->client->post($domain.$endpoint,$params)->getBody()->getContents();
        return $result;
    }

    public function install_plugin($domain,$plugin){
        $result=$this->dockerRepo->exec($this->dockerRepo->generateName($domain),['wp','plugin','install '.$plugin.' --activate --force',]);
        return $result;
    }

    public function tranfer_data($domain,$keyword){
        Post::take(10000)->chunk(100,function ($posts){

        });
    }
}