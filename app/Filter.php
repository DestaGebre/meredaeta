<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\meseretawiWdabe;
use App\Wahio;
use App\Zobatat;
use App\Woreda;
use App\Tabia;
use DB;
use Auth;

class Filter
{
   public static function filter_values($request){
        $value = Auth::user()->area;
        $zoneCode = null;
        $year = $request->year ? $request->year : '';
        $month = $request->month ? $request->month : '';
        $paid = $request->paid !== '' ? $request->paid : '';
        $rank = $request->rank ? $request->rank : '';
        $general = $request->general ? $request->general : '';
        $specific = $request->specific ? $request->specific : '';
        $action = $general . '_' . $specific;
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $zoneCode = Woreda::where('woredacode', $value)->first()->zoneCode;
            $value = '__'.$value;
        }
        else{
            $zoneCode = Auth::user()->area;
        }

        $woreda = $tabia = $widabe = $wahio = null;
        $woreda_l = $tabia_l = $widabe_l = $wahio_l = [];
        if($request->wahio){
            $wahio = Wahio::where('id', $request->wahio)->where('parentcode', 'LIKE', $value . '%')->first();
            if(!$wahio)
                abort(404);
            $wahio_l = Wahio::where('widabeCode', $wahio->widabeCode)->pluck('wahioName', 'id');
            $widabe = meseretawiWdabe::where('widabeCode', $wahio->widabeCode)->first();
            $widabe_l = meseretawiWdabe::where('tabiaCode', $widabe->tabiaCode)->pluck('widabeName', 'widabeCode');
            $tabia = Tabia::where('tabiaCode', $widabe->tabiaCode)->first();
            $tabia_l = Tabia::where('woredacode', $tabia->woredacode)->pluck('tabiaName', 'tabiaCode');
            $woreda = Woreda::where('woredacode', $tabia->woredacode)->first();
            $woreda_l = Woreda::where('zoneCode', $woreda->zoneCode)->pluck('name', 'woredacode');
            $zoneCode = $woreda->zoneCode;
            // echo 'ዋህዮ: ' . $wahio->wahioName . '<br>';
            // echo 'መው: ' . $widabe->widabeName . '<br>';
            // echo 'ጣብያ: ' . $tabia->tabiaName . '<br>';
            // echo 'ወረዳ: ' . $woreda->name . '<br>';
        }
        else if($request->widabe){
            $widabe = meseretawiWdabe::where('widabeCode', $request->widabe)->where('parentcode', 'LIKE', $value . '%')->first();
            if(!$widabe)
                abort(404);
            $wahio_l = Wahio::where('widabeCode', $widabe->widabeCode)->pluck('wahioName', 'id');
            $widabe_l = meseretawiWdabe::where('tabiaCode', $widabe->tabiaCode)->pluck('widabeName', 'widabeCode');
            $tabia = Tabia::where('tabiaCode', $widabe->tabiaCode)->first();
            $tabia_l = Tabia::where('woredacode', $tabia->woredacode)->pluck('tabiaName', 'tabiaCode');
            $woreda = Woreda::where('woredacode', $tabia->woredacode)->first();
            $woreda_l = Woreda::where('zoneCode', $woreda->zoneCode)->pluck('name', 'woredacode');
            $zoneCode = $woreda->zoneCode;

            // echo 'መው: ' . $widabe->widabeName . '<br>';
            // echo 'ጣብያ: ' . $tabia->tabiaName . '<br>';
            // echo 'ወረዳ: ' . $woreda->name . '<br>';
        }
        else if($request->tabia){
            $tabia = Tabia::where('tabiaCode', $request->tabia)->where('parentcode', 'LIKE', $value . '%')->first();
            if(!$tabia)
                abort(404);
            $widabe_l = meseretawiWdabe::where('tabiaCode', $tabia->tabiaCode)->pluck('widabeName', 'widabeCode');
            $tabia_l = Tabia::where('woredacode', $tabia->woredacode)->pluck('tabiaName', 'tabiaCode');
            $woreda = Woreda::where('woredacode', $tabia->woredacode)->first();
            $woreda_l = Woreda::where('zoneCode', $woreda->zoneCode)->pluck('name', 'woredacode');
            $zoneCode = $woreda->zoneCode;

            // echo 'ጣብያ: ' . $tabia->tabiaName . '<br>';
            // echo 'ወረዳ: ' . $woreda->name . '<br>';
        }
        else if($request->woreda){
            $woreda = Woreda::where('woredacode', $request->woreda)->where('zoneCode', 'LIKE', $zoneCode . '%')->first();
            if(!$woreda)
                abort(404);

            $tabia_l = Tabia::where('woredacode', $woreda->woredacode)->pluck('tabiaName', 'tabiaCode');
            $woreda_l = Woreda::where('zoneCode', $woreda->zoneCode)->pluck('name', 'woredacode');
            $zoneCode = $woreda->zoneCode;

            // echo 'ወረዳ: ' . $woreda->name . '<br>';
        }
        if($request->zone){
            if(Auth::user()->usertype != 'admin' && $request->zone != $zoneCode){
                abort(404);
            }
            if($woreda && $woreda->zoneCode != $request->zone){
                abort(404);   
            }
        }
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone && !$zoneCode){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
                $value = $zoneCode;
            }
            else{
                $zoneCode = $request->zone;
                $value = $zoneCode;
            }
        }
        if(!$woreda_l){
            if(Auth::user()->usertype == 'woredaadmin' || Auth::user()->usertype == 'woreda'){
                $woreda_l = Auth::user()->area;
                $woreda = Woreda::where('woredacode', $woreda_l)->first();
            }
            $woreda_l = Woreda::where('zoneCode', $zoneCode)->pluck('name', 'woredacode');
        }
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $tabia_l = Tabia::where('woredacode', Auth::user()->area)->pluck('tabiaName', 'tabiaCode');
        }
        $new_value = (($zoneCode)? $zoneCode : '__') . ($woreda ? $woreda->woredacode : '___') . ($tabia ? $tabia->tabiaCode : '____');
        return compact('zoneCode', 'wahio', 'wahio_l', 'widabe', 'widabe_l', 'tabia', 'tabia_l', 'woreda', 'woreda_l', 'new_value', 'year', 'month', 'paid', 'rank', 'general', 'specific', 'action');
   }
    
}
