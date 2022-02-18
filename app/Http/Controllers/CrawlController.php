<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\TopBrand;
use Goutte\Client;

class CrawlController extends Controller
{
    //

    public function crawl()
    {
        $brand = Brand::all();
        foreach($brand as $item){

            $job = (new \App\Jobs\GetModel($item))
                    ->delay(now()->addSeconds(2));

            dispatch($job);
        }
        return response()->json([
            "result" => "OK",
            "msg" => "Proses Crawl berjalan di latarbelakang"
        ]);
    }

}
