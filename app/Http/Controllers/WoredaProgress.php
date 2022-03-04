<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use  App\Zobatat;
use  App\Woreda; 
use Auth;
use DB;

class WoredaProgress extends Controller
{
    public function index(Request $request)
    {
        $zoneCode = Auth::user()->area;
        $zobadatas = '';
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
            }
            else
                $zoneCode = $request->zone;
        }
        if($request->zone == '00'){
            $zoneName = 'ኩሎም';
            $zobadatas1 = Zobatat::select(["zoneName","zoneCode"])->get()->toArray();
            $progress = [];
            foreach($zobadatas1 as $zone){
                $row_progress = [$zone['zoneName'], 0];
                $row_progress[1] = DB::table('approved_hitsuys')
                ->where('zoneworedaCode', 'LIKE' , $zone['zoneCode'] . '%')
                ->count();
            $progress[] = $row_progress;
            }
            return view('report.woreda_progress', compact('progress','zobadatas', 'zoneCode'));
        }
        $zoneName = Zobatat::where('zoneCode', $zoneCode)->select(['zoneName'])->first()->toArray()['zoneName'];
        $woredas = Woreda::where('zoneCode', $zoneCode)->select(['woredaCode', 'isUrban', 'name'])->get()->toArray();
        $progress = [];
        foreach ($woredas as $woreda) {
            $row_progress = [$woreda['name'], 0];
            $row_progress[1] = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
            $progress[] = $row_progress;
        }
        return view('report.woreda_progress', compact('progress','zobadatas', 'zoneCode'));
    }
}
