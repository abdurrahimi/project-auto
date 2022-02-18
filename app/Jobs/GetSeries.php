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

class GetSeries implements ShouldQueue
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
        //$client = new Client();
        $crawler = $client->request('GET', $this->url.$this->urls);
        $id = $this->id;
        $crawler->filter('img.inCarList')->each(function ($node) use ($id) {
            $img = $node->extract(array('src'));
            $img_url = 'https://www.auto-data.net/'.$img[0];
            $img = 'public/assets/photos/series/'.str_replace("/","-",$node->extract(array('alt'))[0]).".jpg";
            /* if (!file_exists($img)) {
                file_put_contents($img, file_get_contents($img_url));
            } */

            $job = (new \App\Jobs\GetImage($img,$img_url))
                    ->delay(now()->addSeconds(2));

            dispatch($job);

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
}
