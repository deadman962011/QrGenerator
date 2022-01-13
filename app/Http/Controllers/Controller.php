<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use QrCode;

use App\Models\QrCollection;
use App\Models\QrItem;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function home()
    {
        
        //get collctions

        $getColls=QrCollection::all();
        $getColls->load('items');
        
        return view('home',['collections'=>$getColls]);

    }



    public function GenerateQr(Request $request)
    {
    
        //validate inputs
        $validate=$request->validate([
            'QrCountI'=>'required',
            'QrColorI'=>'required',
            'QrPrefixI'=>'required'
        ]);
        
        
        
        //check type of prefix
        switch ($request->input('QrPrefixI')) {
            case 'sms':
                $prefix ='smsto:';
                $value=1234567890;
               
                break;
            case 'http':
                $prefix = 'http://';
                $value='www.google.com';
            break;
            case 'https':
                $prefix ='https://';
                $value='www.google.com';
            break;
            case 'mail':
                $prefix ='mailto:';
                $value='blaxk@blaxk.cc';
            break;
        }
        
        //create new qr collection
        $SaveColl=new QrCollection;
        $SaveColl->count=$request->input('QrCountI');
        $SaveColl->color=$request->input('QrColorI');
        $SaveColl->save();
        $CollId=$SaveColl->id;

        
        //Save qr items 
        $QrArr=array();
        for ($x = 1; $x <= $request->input('QrCountI'); $x++) {


            $SaveItem=new QrItem;
            $SaveItem->prefix=$prefix;
            $SaveItem->value=$value;
            $SaveItem->collection_id=$CollId;
            $SaveItem->save();

        }

        //get Save Collection
        $getQrColl=QrCollection::find($CollId);
        $getQrColl->load('items');

        return redirect()->back();
   
    }

    public function pdf($coll)
    {
        $coll=QrCollection::find($coll);
        $coll->load('items');

        list($r, $g, $b) = sscanf($coll['color'], "#%02x%02x%02x");

        $imgArr=array();
        foreach ($coll['items'] as $item ) {
            
            $t=QrCode::size(100)->color($r,$g,$b)->generate($item );
            array_push($imgArr,base64_encode($t));
        }

        //return view('pdf',['items'=>$imgArr]);

        $pdf = PDF::loadView('pdf',['items'=>$imgArr]);
        return $pdf->download('file.pdf');

    }

    public function print($coll)
    {
        $getQrColl=QrCollection::find($coll);
        $getQrColl->load('items');

        return view('collection',['coll'=>$getQrColl]);
    }
}
