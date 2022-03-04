<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use  App\Zobatat;
use  App\Woreda; 
use  App\Tabia;
use  App\Wahio;
use  App\meseretawiWdabe;
use  App\ApprovedHitsuy;
use  App\Hitsuy;
use DB;

class SixMonthReportController extends Controller
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
        if(Auth::user()->usertype == 'woredaadmin' || Auth::user()->usertype == 'woreda'){
            $zoneCode = Woreda::where('woredacode', Auth::user()->area)->pluck('zoneCode')->first();
        }
        $zCode = null;
        if($zoneCode == 'all'){
            $zoneName = '(ኩሎም)';
            $zCode = '__';
            $woredas = Woreda::select(['woredaCode', 'isUrban', 'name'])->get()->toArray();
        }
        else{
            $zoneName = Zobatat::where('zoneCode', $zoneCode)->select(['zoneName'])->first()->toArray()['zoneName'];
            $zCode = $zoneCode;
            $woredas = Woreda::where('zoneCode', $zoneCode)->select(['woredaCode', 'isUrban', 'name'])->get()->toArray();
        }
        $ketemageter = [];
        $ketemageterwidabe = [];
        $geterwidabe = [];
        $ketemawidabe = [];
        $deant = [];
        foreach ($woredas as $woreda) {
            $row_ketema_geter = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_ketema_geter_widabe = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_geter_widabe = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_ketema_widabe = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_deant = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $tabias = Tabia::where('woredacode', $woreda['woredaCode'])->select(['tabiaCode', 'isUrban'])->get()->toArray();
            foreach ($tabias as $tabia) {
                //Ketmea Geter farmer count
                $row_ketema_geter_widabe[1] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሓረስታይ')->where('gender', 'ተባ')->count();
                $row_ketema_geter_widabe[2] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሓረስታይ')->where('gender', 'ኣን')->count();
                $row_ketema_geter_widabe[3] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሓረስታይ')->count();

                //Ketema Geter deant count
                $row_ketema_widabe[4] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->whereIn('occupation',['መፍረዪ','ንግዲ','ግልጋሎት','ኮስንትራክሽን','ከተማ ሕርሻ'])->where('gender', 'ተባ')->count();
                $row_ketema_widabe[5] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->whereIn('occupation',['መፍረዪ','ንግዲ','ግልጋሎት','ኮስንትራክሽን','ከተማ ሕርሻ'])->where('gender', 'ኣን')->count();
                $row_ketema_widabe[6] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->whereIn('occupation',['መፍረዪ','ንግዲ','ግልጋሎት','ኮስንትራክሽን','ከተማ ሕርሻ'])->count();

                //Ketmea Geter civil servant count
                $row_ketema_geter_widabe[7] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሲቪል ሰርቫንት')->where('gender', 'ተባ')->count();
                $row_ketema_geter_widabe[8] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሲቪል ሰርቫንት')->where('gender', 'ኣን')->count();
                $row_ketema_geter_widabe[9] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሲቪል ሰርቫንት')->count();

                //Ketmea Geter teacher count
                $row_ketema_geter_widabe[10] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'መምህር')->where('gender', 'ተባ')->count();
                $row_ketema_geter_widabe[11] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'መምህር')->where('gender', 'ኣን')->count();
                $row_ketema_geter_widabe[12] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'መምህር')->count();

                //Ketmea Geter student count
                $row_ketema_geter_widabe[13] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ተምሃራይ')->where('gender', 'ተባ')->count();
                $row_ketema_geter_widabe[14] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ተምሃራይ')->where('gender', 'ኣን')->count();
                $row_ketema_geter_widabe[15] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ተምሃራይ')->count();

                //Ketema labour count
                $row_ketema_geter_widabe[16] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሸቃላይ')->where('gender', 'ተባ')->count();
                $row_ketema_geter_widabe[17] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሸቃላይ')->where('gender', 'ኣን')->count();
                $row_ketema_geter_widabe[18] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሸቃላይ')->count();

                if($woreda['isUrban'] == 'ገጠር'){
                    //Geter total count
                    $row_ketema_geter[1] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('gender', 'ተባ')->count();
                    $row_ketema_geter[2] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('gender', 'ኣን')->count();
                    $row_ketema_geter[3] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                    //Geter farmer count
                    $row_geter_widabe[1] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሓረስታይ')->where('gender', 'ተባ')->count();
                    $row_geter_widabe[2] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሓረስታይ')->where('gender', 'ኣን')->count();
                    $row_geter_widabe[3] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሓረስታይ')->count();

                    //Geter civil servant count
                    $row_geter_widabe[4] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሲቪል ሰርቫንት')->where('gender', 'ተባ')->count();
                    $row_geter_widabe[5] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሲቪል ሰርቫንት')->where('gender', 'ኣን')->count();
                    $row_geter_widabe[6] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሲቪል ሰርቫንት')->count();

                    //Geter teacher count
                    $row_geter_widabe[7] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'መምህር')->where('gender', 'ተባ')->count();
                    $row_geter_widabe[8] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'መምህር')->where('gender', 'ኣን')->count();
                    $row_geter_widabe[9] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'መምህር')->count();

                    //Geter student count
                    $row_geter_widabe[10] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ተምሃራይ')->where('gender', 'ተባ')->count();
                    $row_geter_widabe[11] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ተምሃራይ')->where('gender', 'ኣን')->count();
                    $row_geter_widabe[12] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ተምሃራይ')->count();
                }
                else{
                    //Ketema total count
                    $row_ketema_geter[4] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('gender', 'ተባ')->count();
                    $row_ketema_geter[5] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('gender', 'ኣን')->count();
                    $row_ketema_geter[6] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                    //Ketema deant count
                    $row_ketema_widabe[1] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->whereIn('occupation',['መፍረዪ','ንግዲ','ግልጋሎት','ኮስንትራክሽን','ከተማ ሕርሻ'])->where('gender', 'ተባ')->count();
                    $row_ketema_widabe[2] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->whereIn('occupation',['መፍረዪ','ንግዲ','ግልጋሎት','ኮስንትራክሽን','ከተማ ሕርሻ'])->where('gender', 'ኣን')->count();
                    $row_ketema_widabe[3] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->whereIn('occupation',['መፍረዪ','ንግዲ','ግልጋሎት','ኮስንትራክሽን','ከተማ ሕርሻ'])->count();

                    //Ketema labour count
                    $row_ketema_widabe[4] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሸቃላይ')->where('gender', 'ተባ')->count();
                    $row_ketema_widabe[5] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሸቃላይ')->where('gender', 'ኣን')->count();
                    $row_ketema_widabe[6] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሸቃላይ')->count();

                    //Ketema civil servant count
                    $row_ketema_widabe[7] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሲቪል ሰርቫንት')->where('gender', 'ተባ')->count();
                    $row_ketema_widabe[8] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሲቪል ሰርቫንት')->where('gender', 'ኣን')->count();
                    $row_ketema_widabe[9] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ሲቪል ሰርቫንት')->count();

                    //Ketema teacher count
                    $row_ketema_widabe[10] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'መምህር')->where('gender', 'ተባ')->count();
                    $row_ketema_widabe[11] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'መምህር')->where('gender', 'ኣን')->count();
                    $row_ketema_widabe[12] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'መምህር')->count();

                    //Ketema student count
                    $row_ketema_widabe[13] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ተምሃራይ')->where('gender', 'ተባ')->count();
                    $row_ketema_widabe[14] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ተምሃራይ')->where('gender', 'ኣን')->count();
                    $row_ketema_widabe[15] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ተምሃራይ')->count();

                    //deant manufacturing count
                    $row_deant[1] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation','መፍረዪ')->where('gender', 'ተባ')->count();
                    $row_deant[2] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation','መፍረዪ')->where('gender', 'ኣን')->count();
                    $row_deant[3] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation','መፍረዪ')->count();

                    //deant ketema hirsha count
                    $row_deant[4] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ከተማ ሕርሻ')->where('gender', 'ተባ')->count();
                    $row_deant[5] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ከተማ ሕርሻ')->where('gender', 'ኣን')->count();
                    $row_deant[6] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ከተማ ሕርሻ')->count();

                    //deant construction count
                    $row_deant[7] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ኮስንትራክሽን')->where('gender', 'ተባ')->count();
                    $row_deant[8] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ኮስንትራክሽን')->where('gender', 'ኣን')->count();
                    $row_deant[9] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ኮስንትራክሽን')->count();

                    //deant trade count
                    $row_deant[10] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ንግዲ')->where('gender', 'ተባ')->count();
                    $row_deant[11] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ንግዲ')->where('gender', 'ኣን')->count();
                    $row_deant[12] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ንግዲ')->count();

                    //deant service count
                    $row_deant[13] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ግልጋሎት')->where('gender', 'ተባ')->count();
                    $row_deant[14] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ግልጋሎት')->where('gender', 'ኣን')->count();
                    $row_deant[15] += ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('occupation', 'ግልጋሎት')->count();
                }
            }

            $row_ketema_geter[7] = $row_ketema_geter[4] + $row_ketema_geter[1];
            $row_ketema_geter[8] = $row_ketema_geter[5] + $row_ketema_geter[2];
            $row_ketema_geter[9] = $row_ketema_geter[6] + $row_ketema_geter[3];
            $ketemageter[] = array_values($row_ketema_geter);

            $row_ketema_geter_widabe[19] = $row_ketema_geter_widabe[1] + $row_ketema_geter_widabe[4] + $row_ketema_geter_widabe[7] + $row_ketema_geter_widabe[10] + $row_ketema_geter_widabe[13] + $row_ketema_geter_widabe[16];
            $row_ketema_geter_widabe[20] = $row_ketema_geter_widabe[2] + $row_ketema_geter_widabe[5] + $row_ketema_geter_widabe[8] + $row_ketema_geter_widabe[11] + $row_ketema_geter_widabe[14] + $row_ketema_geter_widabe[17];
            $row_ketema_geter_widabe[21] = $row_ketema_geter_widabe[3] + $row_ketema_geter_widabe[6] + $row_ketema_geter_widabe[9] + $row_ketema_geter_widabe[12] + $row_ketema_geter_widabe[15] + $row_ketema_geter_widabe[18];
            $ketemageterwidabe[] = array_values($row_ketema_geter_widabe);

            $row_geter_widabe[13] = $row_geter_widabe[1] + $row_geter_widabe[4] + $row_geter_widabe[7] + $row_geter_widabe[10];
            $row_geter_widabe[14] = $row_geter_widabe[2] + $row_geter_widabe[5] + $row_geter_widabe[8] + $row_geter_widabe[11];
            $row_geter_widabe[15] = $row_geter_widabe[3] + $row_geter_widabe[6] + $row_geter_widabe[9] + $row_geter_widabe[12];
            $geterwidabe[] = array_values($row_geter_widabe);

            $row_ketema_widabe[16] = $row_ketema_widabe[1] + $row_ketema_widabe[4] + $row_ketema_widabe[7] + $row_ketema_widabe[10]+ $row_ketema_widabe[13];
            $row_ketema_widabe[17] = $row_ketema_widabe[2] + $row_ketema_widabe[5] + $row_ketema_widabe[8] + $row_ketema_widabe[11]+ $row_ketema_widabe[14];
            $row_ketema_widabe[18] = $row_ketema_widabe[3] + $row_ketema_widabe[6] + $row_ketema_widabe[9] + $row_ketema_widabe[12]+ $row_ketema_widabe[15];
            $ketemawidabe[] = array_values($row_ketema_widabe);

            $row_deant[16] = $row_deant[1] + $row_deant[4] + $row_deant[7] + $row_deant[10]+ $row_deant[13];
            $row_deant[17] = $row_deant[2] + $row_deant[5] + $row_deant[8] + $row_deant[11]+ $row_deant[14];
            $row_deant[18] = $row_deant[3] + $row_deant[6] + $row_deant[9] + $row_deant[12]+ $row_deant[15];
            $deant[] = array_values($row_deant);
        }
        // $ketemageter = [['ወ/ይት', '6819', '2133', '8952', '1405', '675', '2080', '8224', '2808', '11032'],['ወ/ይት', '6819', '2133', '8952', '1405', '675', '2080', '8224', '2808', '11032']];
        return view('report.sixmonths', compact('zoneName', 'ketemageter', 'ketemageterwidabe', 'geterwidabe', 'ketemawidabe', 'deant', 'zobadatas', 'zoneCode'));
       
    } 
}
