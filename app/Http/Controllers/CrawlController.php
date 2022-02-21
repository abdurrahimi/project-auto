<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Generation;
use App\Models\TopBrand;
use Goutte\Client;

class CrawlController extends Controller
{
    //

    public function crawl()
    {
        $brand = Generation::all();
        foreach($brand as $item){

            $job = (new \App\Jobs\GetSeries($item->id,$item->url))
                    ->delay(now()->addSeconds(2));

            dispatch($job);
        }
        return response()->json([
            "result" => "OK",
            "msg" => "Proses Crawl berjalan di latarbelakang"
        ]);
    }

    public function getTopBrand()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.auto-data.net/en/');
        $crawler->filter('a.marki_blok')->each(function ($node) {
            $href = $node->extract(array('href'));
            $img = $node->filter('img')->extract(array('src'));
            $arr[] = $node->text();
            $id = Brand::where('brand',$node->text())->first();
            if(isset($id->id)){
                $check = TopBrand::where('brand_id',$id->id)->first();
                if(empty($check))
                TopBrand::insert(['brand_id'=>$id->id]);
            }
            //dd($id);
            
        });
    }

}
