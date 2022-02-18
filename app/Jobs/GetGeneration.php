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

class GetGeneration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $url = "https://www.auto-data.net/";
    protected $id;
    protected $urls;

    public function __construct($id,$urls)
    {
        //
        $this->id = $id;
        $this->urls = $urls;
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
        $crawler = $client->request('GET', $this->url.$this->urls);
        $id = $this->id;
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
                /* if (!file_exists($img)) {
                    file_put_contents($img, file_get_contents($img_url));
                } */
                //Create download image jobs
                $job = (new \App\Jobs\GetImage($img,$img_url))
                    ->delay(now()->addSeconds(2));

                dispatch($job);

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
                $job = (new \App\Jobs\GetSeries($id,$url[0]))
                    ->delay(now()->addSeconds(2));
                /* $this->get_series($id,$url[0]); */
            }else{
                $job = (new \App\Jobs\GetSeries($check->id,$check->url))
                    ->delay(now()->addSeconds(2));
                /* $this->get_series($check->id,$check->url); */
            }
        });
    }
}
