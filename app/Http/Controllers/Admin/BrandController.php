<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Goutte\Client;


class BrandController extends Controller
{
    //
    public function index(Request $req)
    {
        if($req->ajax()){
            $data = Brand::all();
            return response()->json([
                'status'=>"OK",
                "data"=>$data
            ]);
        }
        return view('admin.brand.index');
    }

    public function store(Request $req)
    {
        /* dd($req->logo->extension()); */
        if($req->ajax()){
            
            if(empty($req->id)){
                $brand = new Brand();
                
            }else{
                $brand = Brand::find($req->id);
            }
            $brand->brand = $req->brand;
            if($req->logo !== null){
                $imageName = $req['brand'].'.'.$req->logo->extension();
                $req->logo->move(public_path('assets/photos/logo'), $imageName);
                $brand->logo = 'public/assets/photos/logo/'.$imageName;
            }
            if($brand->save()){
                return response()->json([
                    "status" => "OK",
                    "msg"   =>"Data successfully saved"
                ]);
            }else{
                return response()->json([
                    "status" => "FAILED",
                    "msg"   => "Error, please contact the author for support!"
                ]);
            }
        }
    }

    public function delete($id)
    {
        if(Brand::find($id)->delete()){
            return response()->json([
                "status" => "OK",
                "msg"   =>"Data has been deleted"
            ]);
        }else{
            return response()->json([
                "status" => "FAILED",
                "msg"   => "Error, please contact the author for support!"
            ]);
        }
    }

    public function crawl()
    {
        ini_set('max_execution_time', 0);
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.auto-data.net/en/allbrands');
        $data = [];
        $data = $crawler->filter('a.marki_blok')->each(function ($node) {
            $href = $node->extract(array('href'));
            $img = $node->filter('img')->extract(array('src'));

            /* echo $node->text()." | ".$href[0]." | " .$img[0]."<br>"; */
            /* print $node->text()."<br>"; */
            $check = Brand::where('brand',$node->text())->count();
            if($check==0){
                $url = 'https://www.auto-data.net/'.$img[0];
                $img = 'public/assets/photos/logo/'.$node->text().".jpg";
                if (!file_exists($img)) {
                    file_put_contents($img, file_get_contents($url));
                }
                return $data = [
                    "brand" => $node->text(),
                    "logo"  => $img,
                    "url"   => $href[0]
                ];
            }
        });

        if(!empty($data[0])){
            if(Brand::insert($data)){
                return response()->json([
                    "status" => "OK",
                    "msg"   => count($data)." data saved successfully"
                ]);
            }else{
                return response()->json([
                    "status" => "FAILED",
                    "msg"   => "Error, please contact the author for support!"
                ]);
            }
        }

        return response()->json([
            "status" => "FAILED",
            "msg"   => "Data from server already exist"
        ]);
    }
}
