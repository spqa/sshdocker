<?php

namespace App\Console\Commands;

use Automattic\WooCommerce\Client;
use DB;
use Illuminate\Console\Command;

class ConvertData extends Command
{
    const consumer_key = 'ck_570a4cb254954c6aa48731a9d37bc3d3b95b8306';
    const consumer_secret = 'cs_7c05eeea1179c31e30e36dc94f2b17f11d58c4ce';
    const url = 'http://wpshop.com';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert database';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $client;

    public function __construct()
    {
        $this->client = new Client(self::url, self::consumer_key, self::consumer_secret, []);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->config();
        $this->convertCategories();
        $this->createProductAttribute();
        $this->convertProduct();
    }

    private function config()
    {
        //TODO set api key, change url wordpress
    }

    private function convertCategories()
    {
        $meta = [
            'order' => 0,
            'display_type' => null,
            'thumbnail_id' => 0,
            'cat-header-image' => null,
            'cat-header-link' => null,
        ];

        DB::connection('laravel_mysql')->table('styles')->orderBy('id')->chunk(20, function ($items) use ($meta) {
            foreach ($items as $item) {
                $category = DB::connection('wp_mysql')->table('wp_terms')
                    ->where('slug', str_slug($item->styleName))->first();
                if ($category) {
                    continue;
                }

                $categoryId = DB::connection('wp_mysql')->table('wp_terms')->insertGetId([
                    'name' => $item->styleName,
                    'slug' => str_slug($item->styleName)
                ]);


                foreach ($meta as $key => $value) {
                    DB::connection('wp_mysql')->table('wp_termmeta')->insert([
                        'term_id' => $categoryId,
                        'meta_key' => $key,
                        'meta_value' => $value
                    ]);
                }
            }
        });
    }

    private function convertProduct()
    {
//        DB::connection('laravel_mysql')->table('items')->orderBy('id')->chunk(20, function ($items) {
//            foreach ($items as $item) {
//
//            }
//        });


        $data = [
            'product' => [
                'title' => 'test product',
                'type' => 'variable',
                'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
                'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
                'categories' => [
                    9,
                    14
                ],
                'images' => [
                    [
                        'src' => 'images.sunfrogshirts.com/2015/07/27/b2.jpg',
                        'position' => 0
                    ]
                ],
                'attributes' => [
                    [
                        'name' => 'Color',
                        'slug' => 'color',
                        'position' => '0',
                        'visible' => true,
                        'variation' => true,
                        'options' => [
                            'Black',
                            'Green'
                        ]
                    ],
                    [
                        'name' => 'link',
                        'slug' => 'link',
                        'position' => '0',
                        'visible' => false,
                        'variation' => false,
                        'options' => [
                            'http://www.24h.com.vn/'
                        ]
                    ]
                ],
                'default_attributes' => [
                    [
                        'name' => 'Color',
                        'slug' => 'color',
                        'option' => 'Black'
                    ]
                ],
                'variations' => [
                    [
                        'regular_price' => '19.99',
                        'image' => [
                            [
                                'src' => 'images.sunfrogshirts.com/2015/07/27/b2.jpg',
                                'position' => 0
                            ]
                        ],
                        'attributes' => [
                            [
                                'name' => 'Color',
                                'slug' => 'color',
                                'option' => 'black'
                            ]
                        ]
                    ],
                    [
                        'regular_price' => '19.99',
                        'image' => [
                            [
                                'src' => 'images.sunfrogshirts.com/2015/07/27/b2.jpg',
                                'position' => 0
                            ]
                        ],
                        'attributes' => [
                            [
                                'name' => 'Color',
                                'slug' => 'color',
                                'option' => 'green'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $products = $this->client->post('products', $data);
    }

    private function createProductAttribute()
    {
        try {
            $arr = [];
            $data = [
                'color' => 'Color',
                'size' => 'Size',
            ];

            foreach ($data as $key => $value) {
                $attributies = $this->client->post('products/attributes', [
                    'product_attribute' => [
                        'name' => $value,
                        'slug' => $key,
                        'type' => 'select',
                        'order_by' => 'menu_order',
                        'has_archives' => true
                    ]
                ]);

                if (isset($attributies['product_attribute'])) {
                    $arr[$key] = $attributies['product_attribute']['id'];
                }
            }

            return $arr;
        } catch (\Exception $e) {

        }

    }
}
