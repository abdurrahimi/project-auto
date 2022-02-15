<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Goutte\Client;


use App\Models\Models;
use App\Models\Generation;
use App\Models\GenerationImage;
use App\Models\GenerationDetail;
use App\Models\Type;

class CrawlQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $url = "https://www.auto-data.net/";
    protected $data = [];
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        //
        $client = new Client();
        $crawler = $client->request('GET', $this->url.$this->data->url);

        $crawler->filter('a.modeli')->each(function ($node) {
            $check = Models::where('model',$node->text())->first();
            if(empty($check)){
                $url = $node->extract(array('href'));
                $img = $node->filter('img')->extract(array('src'));
                $img_url = 'https://www.auto-data.net/'.$img[0];
                $img = 'public/assets/photos/model/'.str_replace("/","-",$node->text()).".jpg";
                if (!file_exists($img)) {
                    file_put_contents($img, file_get_contents($img_url));
                }
                $id = Models::insertGetId([
                    "brand_id" => $this->data->id,
                    "model" => $node->text(),
                    "image" => $img,
                    "url" => $url[0]
                ]);
                $this->get_generation($id,$url[0]);
                
            }else{
                $this->get_generation($check->id,$check->url);
            }
        });
        
    }

    public function get_generation($id,$url)
    {
        //'https://www.auto-data.net/en/abarth-124-spider-model-2152'
        $client = new Client();
        $crawler = $client->request('GET', $this->url.$url);

        $crawler->filter('table.generr > tr')->each(function ($node) use ($id) {
            $title = $node->filter('.tit')->text();
            $check = Generation::where('title',$title)->first();
            if(empty($check)){
                $url = $node->filter('a')->extract(array('href'));
                $img = $node->filter('img')->extract(array('src'));
                try{
                    $year = !empty($node->filter('.cur')->text()) ? $node->filter('.cur')->text() : $node->filter('.end')->text();
                } catch(Exception $e) { // I guess its InvalidArgumentException in this case
                    // Node list is empty
                    $year = $node->filter('.end')->text();
                }
                
                $type = $node->filter('.chas')->text();
                $detail = $node->filter('span')->each(function($n){
                    return $n->text();
                });
                $img_url = 'https://www.auto-data.net/'.$img[0];
                $img = 'public/assets/photos/generation/'.str_replace("/","-",$title).".jpg";
                if (!file_exists($img)) {
                    file_put_contents($img, file_get_contents($img_url));
                }
                $data = [
                    "model_id" => $id,
                    "url" => $url[0],
                    "image" => $img,
                    "title" => $title,
                    "year" => $year,
                    "type" => $type,
                    "power" => isset($detail[0]) ? $detail[0] : "",
                    "dimension" => isset($detail[1]) ? $detail[1] : ""
                ];
                $id = Generation::insertGetId($data);
                $this->get_series($id,$url[0]);
            }else{
                $this->get_series($check->id,$check->url);
            }
        });
    }

    public function get_series($id,$url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $this->url.$url);

        $crawler->filter('img.inCarList')->each(function ($node) use ($id) {
            $img = $node->extract(array('src'));
            $img_url = 'https://www.auto-data.net/'.$img[0];
            $img = 'public/assets/photos/series/'.str_replace("/","-",$node->extract(array('alt'))[0]).".jpg";
            if (!file_exists($img)) {
                file_put_contents($img, file_get_contents($img_url));
            }

            $check = GenerationImage::where('image',$node->text())->count();
            if($check==0){
                GenerationImage::insert([
                    "generation_id" => $id,
                    "image" => $img
                ]);
            }
            
        });

        $detail = $crawler->filter('table.carlist ')->each(function ($node) {
            return $node->filter('.h')->html();
        });
        $check = GenerationDetail::where('generation_id',$id)->count();
        if($check==0){
            GenerationDetail::insert([
                "generation_id" => $id,
                "detail" => isset($detail[0]) ? $detail[0] : ""
            ]);
        }

        $crawler->filter('.lgreen')->each(function ($node) use ($id) {
            $url = $node->filter('a')->extract(array('href'))[0];
            $title = $node->filter('.tit')->text();
            $year = ($node->filter('.cur')->text() !== false ) ? $node->filter('.cur')->text() : $node->filter('.end')->text();
            $details = $node->filter('td > a')->html();
            $list = [
                "generation_id" => $id,
                "url" => $url,
                "title" => $title,
                "year" => $year,
                "detail" => $details
            ];
            $check = Type::where('title',$title)->count();
            if($check==0){
                $series_id = Type::insertGetId($list);
            }

        });
    }

    /* public function get_car_detail(Type $var = null)
    {
        
    } */
}
