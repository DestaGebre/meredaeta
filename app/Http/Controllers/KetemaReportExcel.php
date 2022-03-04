<?php

namespace App\Http\Controllers;

require_once substr(dirname(__FILE__), 0, -17).'\PHPExcel-1.8\Classes\PHPExcel.php';

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
// use PHPExcel_Style_Borders;
use PHPExcel_Shared_Font;

use  App\Zobatat;
use  App\Woreda; 
use  App\Tabia;
use  App\Wahio;
use  App\meseretawiWdabe;
use  App\ApprovedHitsuy;
use  App\Hitsuy;
use App\Penalty;
use App\Transfer;
use App\Dismiss;
use DB;

use Carbon\Carbon;

use Illuminate\Http\Request;

class KetemaReportExcel extends Controller
{
    private function loadData($zoneCode){
        $A_UPPER = 100;
        $A_LOWER = 80;
        $B_UPPER = 79;
        $B_LOWER = 50;
        $C_UPPER = 49;
        $C_LOWER = 0;
        $zoneCode = '09';
        $zoneName = Zobatat::where('zoneCode', $zoneCode)->select(['zoneName'])->first()->toArray()['zoneName'];
        $woredas = Woreda::where('zoneCode', $zoneCode)->select(['woredaCode', 'isUrban', 'name'])->get()->toArray();
        $now = Carbon::today();
        $then=$now->subMonths(3);
        $weseking_gudletin = [];
        $abalat_age_education = [];
        $abalat_mahberawi_bota = [];
        $abalat_deant = [];
        $wahio_count = [];
        $tabia_count = [];
        $plan_deant = [];
        $plan_non_deant = [];
        $plan_all = [];
        $model_members = [];
        $new_members_non_deant = [];
        $new_members_deant = [];
        $approved_new_members = [];
        $grades = [];
        $punishment = [];
        foreach ($woredas as $woreda) {
            $row_weseking_gudletin = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_abalat_age_education = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_abalat_mahberawi_bota = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_abalat_deant = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_wahio_count = [$woreda['name'], 0, 0, 0, 0, 0, 0];
            $row_tabia_count = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_plan_deant = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
            $row_plan_non_deant = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
            $row_plan_all = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, ''];
            $row_model_members = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ''];
            $row_new_members_non_deant = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_new_members_deant = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_approved_new_members = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_grades = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_punishment = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $tabias = Tabia::where('woredacode', $woreda['woredaCode'])->select(['tabiaCode', 'isUrban'])->get()->toArray();
            $row_tabia_count[1] = count($tabias);
            foreach ($tabias as $tabia) {
                //wesekin gudletin
                if($tabia['isUrban'] == 'ከተማ'){
                    $row_weseking_gudletin[2] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')
                    ->whereBetween('created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_weseking_gudletin[3] += Transfer::where('zone', $zoneCode)
                    ->where('woreda', $woreda['woredaCode'])
                    ->where('tabia', $tabia['tabiaCode'])
                    ->whereBetween('created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    // TODO ተኣጊዱ ዝነበረ
                    $row_weseking_gudletin[4] += 0;

                    $row_weseking_gudletin[6] += DB::table('dismisses')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
                    ->where('dismissReason', 'ብሞት')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->whereBetween('dismisses.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();   

                    $row_weseking_gudletin[7] += DB::table('dismisses')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
                    ->where('dismissReason', 'ብቕፅዓት')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->whereBetween('dismisses.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();   

                    $row_weseking_gudletin[8] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->where('penaltyGiven', 'ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ')
                    ->where('hitsuys.hitsuy_status', 'ዝተኣገደ')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();


                    //TODO University
                    $row_weseking_gudletin[9] += Transfer::where('oldzone', $zoneCode)
                    ->where('oldworeda', $woreda['woredaCode'])
                    ->where('oldtabia', $tabia['tabiaCode'])
                    ->whereBetween('created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_weseking_gudletin[10] += Transfer::where('oldzone', $zoneCode)
                    ->where('oldworeda', $woreda['woredaCode'])
                    ->where('oldtabia', $tabia['tabiaCode'])
                    ->where('zone', $zoneCode)
                    ->whereBetween('created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_weseking_gudletin[11] += Transfer::where('oldzone', $zoneCode)
                    ->where('oldworeda', $woreda['woredaCode'])
                    ->where('oldtabia', $tabia['tabiaCode'])
                    ->where('zone','NOT', $zoneCode)
                    ->whereBetween('created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    //TODO out of region
                    $row_weseking_gudletin[12] += Transfer::where('oldzone', $zoneCode)
                    ->where('oldworeda', $woreda['woredaCode'])
                    ->where('oldtabia', $tabia['tabiaCode'])
                    ->where('zone','NOT', $zoneCode)
                    ->whereBetween('created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_weseking_gudletin[13] += DB::table('dismisses')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
                    ->whereIn('dismissReason', ['ናይ ውልቀ ሰብ ሕቶ', 'ብኽብሪ' , 'ካሊእ'])
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->whereBetween('dismisses.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_weseking_gudletin[16] += (ApprovedHitsuy::where('zoneworedaCode',$zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count() + Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count());


                }
                //abalat age, education
                if($tabia['isUrban'] == 'ከተማ'){
                    $fm = ApprovedHitsuy::where('zoneworedaCode',$zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[1] += $fm;
                    $row_abalat_age_education[2] += $cd;
                    $row_abalat_age_education[3] += ($fm + $cd);

                    // 18 - 35
                    $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereBetween('hitsuys.dob', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)]) ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[4] += ($fm + $cd);

                    //36 - 60
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereBetween('hitsuys.dob', [Carbon::today()->subYears(60), Carbon::today()->subYears(35)])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(60), Carbon::today()->subYears(35)]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[5] += ($fm + $cd);

                    //above 60
                    $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereBetween('hitsuys.dob', [Carbon::today()->subYears(150), Carbon::today()->subYears(60)]) ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(150), Carbon::today()->subYears(60)]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[6] += ($fm + $cd);


                    // illiterate [education]
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereIn('hitsuys.educationlevel', ['', null])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::whereIn('hitsuys.educationlevel', ['', null]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[7] += ($fm + $cd);

                    //1 - 8 [education]
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereBetween('hitsuys.educationlevel', [1, 8])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::whereBetween('hitsuys.educationlevel', [1, 8]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[8] += ($fm + $cd);

                    //9 - 12 [education]
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereBetween('hitsuys.educationlevel', [9, 12])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::whereBetween('hitsuys.educationlevel', [9, 12]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[9] += ($fm + $cd);

                    //certificate [education]
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.educationlevel', 'ሰርቲፊኬት')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.educationlevel', 'ሰርቲፊኬት') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[10] += ($fm + $cd);

                    //diploma [education]
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.educationlevel', 'ዲፕሎማ')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.educationlevel', 'ዲፕሎማ') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[11] += ($fm + $cd);

                    //1st degree [education]
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.educationlevel', 'ዲግሪ')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.educationlevel', 'ዲግሪ') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[12] += ($fm + $cd);

                    //master's [education]
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.educationlevel', 'ማስተር')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.educationlevel', 'ማስተር') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[13] += ($fm + $cd);

                    //PhD [education]
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.educationlevel', 'ዶክተር')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.educationlevel', 'ዶክተር') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_age_education[14] += ($fm + $cd);

                }
                //abalat mahberawi bota
                if($tabia['isUrban'] == 'ከተማ'){
                    // deant
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት']) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[1] += ($fm + $cd);

                    // shekalo
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'ሸቃላይ')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.occupation', 'ሸቃላይ') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[2] += ($fm + $cd);

                    // ካልኦት ሰብ ሞያ
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.occupation', 'ሲቪል ሰርቫንት') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[3] += ($fm + $cd);

                    // teacher
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'መምህር')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.occupation', 'መምህር') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[4] += ($fm + $cd);

                    // student
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'ተምሃራይ')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.occupation', 'ተምሃራይ') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[5] += ($fm + $cd);


                    // 67 - 83
                    $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1967,1,1), Carbon::createFromDate(1983,1,1)]) ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = 0;
                    // $cd = Hitsuy::whereBetween('approved_hitsuys.membershipDate', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[6] += ($fm + $cd);

                    // 84 - 93
                    $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1983,1,1), Carbon::createFromDate(1993,1,1)]) ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    // $cd = Hitsuy::whereBetween('approved_hitsuys.membershipDate', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[7] += ($fm + $cd);

                    // 94 - 2000
                    $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1993,1,1), Carbon::createFromDate(2000,1,1)]) ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    // $cd = Hitsuy::whereBetween('approved_hitsuys.membershipDate', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[8] += ($fm + $cd);

                    // after 2001
                    $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(2000,1,1), Carbon::createFromDate(9000,1,1)]) ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    // $cd = Hitsuy::whereBetween('approved_hitsuys.membershipDate', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[9] += ($fm + $cd);


                    // ደቂ ኣንስትዮ
                    $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('approved_hitsuys.assignedAssoc','ደቂ ኣንስትዮ') ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    // $cd = Hitsuy::whereBetween('approved_hitsuys.membershipDate', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[10] += ($fm + $cd);

                    // መናእሰይ
                    $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('approved_hitsuys.assignedAssoc','መናእሰይ') ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    // $cd = Hitsuy::whereBetween('approved_hitsuys.membershipDate', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[11] += ($fm + $cd);

                    // መምህራን
                    $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('approved_hitsuys.assignedAssoc','መምህራን') ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    // $cd = Hitsuy::whereBetween('approved_hitsuys.membershipDate', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)]) ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[12] += ($fm + $cd);

                    // መንግስቲ ሰራሕተኛ
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.occupation', 'ሲቪል ሰርቫንት') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[13] += ($fm + $cd);

                    // ዘይመንግስታዊ
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'ዘይመንግስታዊ')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.occupation', 'ሲቪል ሰርቫንት') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[14] += ($fm + $cd);

                    // ውልቀ
                    $fm = DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'ውልቀ')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuys.occupation', 'ሲቪል ሰርቫንት') ->where('hitsuys.hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[15] += ($fm + $cd);

                    // ደቂ ኣንስትዮ
                    $fm = ApprovedHitsuy::where('zoneworedaCode',$zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->where('gender', 'ኣን')->count();
                    $cd = Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->where('gender', 'ኣን')->count();
                    $row_abalat_mahberawi_bota[16] += ($fm + $cd);

                    //ድምር
                    $fm = ApprovedHitsuy::where('zoneworedaCode',$zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->count();
                    $row_abalat_mahberawi_bota[17] += ($fm + $cd);

                }
                //deant
                if($tabia['isUrban'] == 'ከተማ'){
                    // manufacturing
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    where('wudabeType', 'መፍረይቲ')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = 0;
                    $row_abalat_deant[1] += ($fm + $cd);

                    // ketema hrisha
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    where('wudabeType', 'ከተማ ሕርሻ')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = 0;
                    $row_abalat_deant[2] += ($fm + $cd);

                    // construction
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    where('wudabeType', 'ኮንስትራክሽን')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = 0;
                    $row_abalat_deant[3] += ($fm + $cd);

                    // trade
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    where('wudabeType', 'ንግዲ')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = 0;
                    $row_abalat_deant[4] += ($fm + $cd);

                    // service
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    where('wudabeType', 'ግልጋሎት')
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();
                    $cd = 0;
                    $row_abalat_deant[5] += ($fm + $cd);

                    // 67 - 83
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->whereBetween('membershipDate', [Carbon::createFromDate(1967,1,1), Carbon::createFromDate(1983,1,1)])
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[6] += ($fm + $cd);

                    // 83 - 93
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->whereBetween('membershipDate', [Carbon::createFromDate(1983,1,1), Carbon::createFromDate(1993,1,1)])
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[7] += ($fm + $cd);

                    // 93 - 2000
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->whereBetween('membershipDate', [Carbon::createFromDate(1993,1,1), Carbon::createFromDate(2000,1,1)])
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[8] += ($fm + $cd);

                    // 2000 - 
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->whereBetween('membershipDate', [Carbon::createFromDate(2000,1,1), Carbon::createFromDate(9000,1,1)])
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[9] += ($fm + $cd);

                    // ደቂ ኣንስትዮ
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->where('assignedAssoc', 'ደቂ ኣንስትዮ')
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[10] += ($fm + $cd);

                    // ደኣንት
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->where('assignedAssoc', 'ደኣንት')
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[11] += ($fm + $cd);

                    // መናእሰይ
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->where('assignedAssoc', 'መናእሰይ')
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[12] += ($fm + $cd);

                    // መንግስቲ ሰራሕተኛ
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->where('occupation', 'ሲቪል ሰርቫንት')
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[13] += ($fm + $cd);

                    // ዘይመንግስታዊ
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->where('occupation', '')
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[14] += ($fm + $cd);

                    // ውልቀ
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->where('occupation', '')
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[15] += ($fm + $cd);

                    // girls
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->where('gender', 'ኣን')
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[16] += ($fm + $cd);

                    // ድምር
                    $fm = ApprovedHitsuy::
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    whereIn('wudabeType', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                    ->where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->count();
                    $cd = 0;
                    $row_abalat_deant[17] += ($fm + $cd);

                }
                //wahio count
                if($tabia['isUrban'] == 'ከተማ'){

                    // ተምሃሮ
                    foreach (meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'ተምሃሮ')->get()->toArray() as $widabe){
                        $row_wahio_count[1] += Wahio::where('widabeCode', $widabe['widabeCode'])->count();
                    }

                    // መምህራን
                    foreach (meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'መምህራን')->get()->toArray() as $widabe){
                        $row_wahio_count[1] += Wahio::where('widabeCode', $widabe['widabeCode'])->count();
                    }

                    // ሲ/ሰርቫንት
                    foreach (meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'ሲ/ሰርቫንት')->get()->toArray() as $widabe){
                        $row_wahio_count[1] += Wahio::where('widabeCode', $widabe['widabeCode'])->count();
                    }

                    // ሸቃሎ
                    foreach (meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'ሸቃሎ')->get()->toArray() as $widabe){
                        $row_wahio_count[1] += Wahio::where('widabeCode', $widabe['widabeCode'])->count();
                    }

                    // ድምር
                    foreach (meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->get()->toArray() as $widabe){
                        $row_wahio_count[6] += Wahio::where('widabeCode', $widabe['widabeCode'])->count();
                    }
                }
                //tabia count
                if($tabia['isUrban'] == 'ከተማ'){

                    if(ApprovedHitsuy::where('zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count()+
                        Hitsuy::where('hitsuy_status', 'ሕፁይ')->where('hitsuyID', 'LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'%')->count()>500){
                        $row_tabia_count[2] += 1;
                    }
                    else{
                        $row_tabia_count[3] += 1;
                    }

                    // መፍረይቲ
                    $row_tabia_count[5] += meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'መፍረይቲ')->count();
                    // ከተማ ሕርሻ
                    $row_tabia_count[6] += meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'ከተማ ሕርሻ')->count();
                    // ኮንስትራክሽን
                    $row_tabia_count[7] += meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'ኮንስትራክሽን')->count();
                    // ንግዲ
                    $row_tabia_count[8] += meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'ንግዲ')->count();
                    // ግልጋሎት
                    $row_tabia_count[9] += meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'ግልጋሎት')->count();
                    // ሸቃሎ
                    $row_tabia_count[11] += meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'ሸቃሎ')->count();
                    // ተምሃሮ
                    $row_tabia_count[12] += meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'ተምሃሮ')->count();
                    // መምህራን
                    $row_tabia_count[13] += meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'መምህራን')->count();
                    // ሲ/ሰርቫንት
                    $row_tabia_count[14] += meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->where('type', 'ሲ/ሰርቫንት')->count();

                    //ጠ/ድምር
                    $row_tabia_count[16] += meseretawiWdabe::where('tabiaCode', $tabia['tabiaCode'])->count();                    
                }
                //plan deant
                if($tabia['isUrban'] == 'ከተማ'){
                    //መፍረይቲ
                    $row_plan_deant[2] += DB::table('meseretawi_wdabes')
                    ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                    ->where('meseretawi_wdabes.type', 'መፍረይቲ')
                    ->where('meseretawi_wdabes.tabiaCode', $tabia['tabiaCode'])
                    ->where('meseretawiwidabeaplans.planyear',2011)->count();

                    //ከተማ ሕርሻ
                    $row_plan_deant[4] += DB::table('meseretawi_wdabes')
                    ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                    ->where('meseretawi_wdabes.type', 'ከተማ ሕርሻ')
                    ->where('meseretawi_wdabes.tabiaCode', $tabia['tabiaCode'])
                    ->where('meseretawiwidabeaplans.planyear',2011)->count();

                    //ኮንስትራክሽን
                    $row_plan_deant[6] += DB::table('meseretawi_wdabes')
                    ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                    ->where('meseretawi_wdabes.type', 'ኮንስትራክሽን')
                    ->where('meseretawi_wdabes.tabiaCode', $tabia['tabiaCode'])
                    ->where('meseretawiwidabeaplans.planyear',2011)->count();

                    //ንግዲ
                    $row_plan_deant[8] += DB::table('meseretawi_wdabes')
                    ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                    ->where('meseretawi_wdabes.type', 'ንግዲ')
                    ->where('meseretawi_wdabes.tabiaCode', $tabia['tabiaCode'])
                    ->where('meseretawiwidabeaplans.planyear',2011)->count();

                    //ግልጋሎት
                    $row_plan_deant[10] += DB::table('meseretawi_wdabes')
                    ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                    ->where('meseretawi_wdabes.type', 'ግልጋሎት')
                    ->where('meseretawi_wdabes.tabiaCode', $tabia['tabiaCode'])
                    ->where('meseretawiwidabeaplans.planyear',2011)->count();

                }
                //plan non deant
                if($tabia['isUrban'] == 'ከተማ'){
                    //ሸቃሎ
                    $row_plan_deant[2] += DB::table('meseretawi_wdabes')
                    ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                    ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                    ->where('meseretawi_wdabes.tabiaCode', $tabia['tabiaCode'])
                    ->where('meseretawiwidabeaplans.planyear',2011)->count();

                    //ተምሃሮ
                    $row_plan_deant[4] += DB::table('meseretawi_wdabes')
                    ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                    ->where('meseretawi_wdabes.type', 'ተምሃሮ')
                    ->where('meseretawi_wdabes.tabiaCode', $tabia['tabiaCode'])
                    ->where('meseretawiwidabeaplans.planyear',2011)->count();

                    //መምህራን
                    $row_plan_deant[6] += DB::table('meseretawi_wdabes')
                    ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                    ->where('meseretawi_wdabes.type', 'መምህራን')
                    ->where('meseretawi_wdabes.tabiaCode', $tabia['tabiaCode'])
                    ->where('meseretawiwidabeaplans.planyear',2011)->count();

                    //ሲ/ሰርቫንት
                    $row_plan_deant[8] += DB::table('meseretawi_wdabes')
                    ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                    ->where('meseretawi_wdabes.type', 'ሲ/ሰርቫንት')
                    ->where('meseretawi_wdabes.tabiaCode', $tabia['tabiaCode'])
                    ->where('meseretawiwidabeaplans.planyear',2011)->count();

                }
                //plan all
                if($tabia['isUrban'] == 'ከተማ'){
                    //መሰረታዊ ውዳበ
                    $row_plan_all[2] += DB::table('approved_hitsuys')
                    ->join('individualplans', 'approved_hitsuys.hitsuyID', '=', 'individualplans.hitsuyID')
                    // ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    ->where('individualplans.year',2011)->count();


                    //መሰረታዊ ውዳበ
                    $row_plan_all[5] += DB::table('meseretawi_wdabes')
                    ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                    // ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                    ->where('meseretawi_wdabes.tabiaCode', $tabia['tabiaCode'])
                    ->where('meseretawiwidabeaplans.planyear',2011)->count();

                }
                //model members
                if($tabia['isUrban'] == 'ከተማ'){
                }
                //new candidates non deant
                if($tabia['isUrban'] == 'ከተማ'){
                    // ሲቪል ሰርቫንት
                    $row_new_members_non_deant[2] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->where('occupation', 'ሲቪል ሰርቫንት')->count();

                    // ሸቃላይ
                    $row_new_members_non_deant[4] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->where('occupation', 'ሸቃላይ')->count();

                    // ተምሃራይ
                    $row_new_members_non_deant[6] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->where('occupation', 'ተምሃራይ')->count();

                    // መምህር
                    $row_new_members_non_deant[8] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->where('occupation', 'መምህር')->count();
                }
                //new candidates deant
                if($tabia['isUrban'] == 'ከተማ'){
                    // መፍረይቲ
                    $row_new_members_deant[2] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->where('occupation', 'መፍረይቲ')->count();

                    // ከተማ ሕርሻ
                    $row_new_members_deant[4] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->where('occupation', 'ከተማ ሕርሻ')->count();

                    // ኮንስትራክሽን
                    $row_new_members_deant[6] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->where('occupation', 'ኮንስትራክሽን')->count();

                    // ንግዲ
                    $row_new_members_deant[8] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->where('occupation', 'ንግዲ')->count();

                    // ግልጋሎት
                    $row_new_members_deant[8] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->where('hitsuy_status', 'ሕፁይ')->where('occupation', 'ግልጋሎት')->count();
                }
                //new approved members
                if($tabia['isUrban'] == 'ከተማ'){
                    // ክሰግሩ ዝግበኦም
                    $row_approved_new_members[1] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])->where('gender', 'ተባ')->count();
                    $row_approved_new_members[2] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])->where('gender', 'ኣን')->count();
                    $row_approved_new_members[3] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])->count();

                    // ፍፃመ
                    $row_approved_new_members[4] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])->where('hitsuy_status', 'ኣባል')->where('gender', 'ተባ')->count();
                    $row_approved_new_members[5] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])->where('hitsuy_status', 'ኣባል')->where('gender', 'ኣን')->count();
                    $row_approved_new_members[6] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])->where('hitsuy_status', 'ኣባል')->count();

                    // ዘይሰገሩ TODO
                    $row_approved_new_members[8] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])->where('hitsuy_status', 'ኣባል')->where('gender', 'ተባ')->count();
                    $row_approved_new_members[9] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])->where('hitsuy_status', 'ኣባል')->where('gender', 'ኣን')->count();
                    $row_approved_new_members[10] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])->where('hitsuy_status', 'ኣባል')->count();

                    // ግዚኦም ዘይኣኸለ
                    $row_approved_new_members[11] += Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'].'/%')->whereBetween('regDate',[Carbon::createFromDate(2004,3,30)->subMonths(6), Carbon::createFromDate(9000,1,1)->subMonths(6)])->where('hitsuy_status', 'ሕፁይ')->count();
                }
                //grades
                if($tabia['isUrban'] == 'ከተማ'){

                    // deant
                    {
                        // total
                        $row_grades[1] += DB::table('approved_hitsuys')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                        ->count();
                        // deant A
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('super_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('middle_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->where('lower_leaders.evaluation', 'A')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('first_instant_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('experts.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->where('tara_members.evaluation', 'A')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[2] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                        // deant B
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('super_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('middle_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->where('lower_leaders.evaluation', 'B')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('first_instant_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('experts.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->where('tara_members.evaluation', 'B')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[3] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                        // deant C
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('super_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('middle_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->where('lower_leaders.evaluation', 'C')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('first_instant_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->whereBetween('experts.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                            ->where('tara_members.evaluation', 'C')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[4] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                    }
                    // ሸቃሎ
                    {
                        // total
                        $row_grades[6] += DB::table('approved_hitsuys')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                        ->count();
                        // ሸቃሎ A
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('super_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('middle_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->where('lower_leaders.evaluation', 'A')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('first_instant_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('experts.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->where('tara_members.evaluation', 'A')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[7] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                        // ሸቃሎ B
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('super_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('middle_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->where('lower_leaders.evaluation', 'B')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('first_instant_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('experts.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->where('tara_members.evaluation', 'B')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[8] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                        // ሸቃሎ C
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('super_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('middle_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->where('lower_leaders.evaluation', 'C')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('first_instant_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->whereBetween('experts.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሸቃላይ')
                            ->where('tara_members.evaluation', 'C')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[9] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                    }
                    // ሰብ ሞያ
                    {
                        // total
                        $row_grades[11] += DB::table('approved_hitsuys')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                        ->count();
                        // ሰብ ሞያ A
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('super_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('middle_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->where('lower_leaders.evaluation', 'A')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('first_instant_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('experts.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->where('tara_members.evaluation', 'A')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[12] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                        // ሰብ ሞያ B
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('super_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('middle_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->where('lower_leaders.evaluation', 'B')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('first_instant_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('experts.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->where('tara_members.evaluation', 'B')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[13] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                        // ሰብ ሞያ C
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('super_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('middle_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->where('lower_leaders.evaluation', 'C')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('first_instant_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->whereBetween('experts.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                            ->where('tara_members.evaluation', 'C')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[14] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                    }
                    // መምህራን
                    {
                        // total
                        $row_grades[16] += DB::table('approved_hitsuys')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                        ->count();
                        // መምህራን A
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('super_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('middle_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->where('lower_leaders.evaluation', 'A')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('first_instant_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('experts.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->where('tara_members.evaluation', 'A')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[17] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                        // መምህራን B
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('super_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('middle_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->where('lower_leaders.evaluation', 'B')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('first_instant_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('experts.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->where('tara_members.evaluation', 'B')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[18] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                        // መምህራን C
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('super_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('middle_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->where('lower_leaders.evaluation', 'C')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('first_instant_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->whereBetween('experts.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'መምህር')
                            ->where('tara_members.evaluation', 'C')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[19] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                    }
                    // ተምሃሮ
                    {
                        // total
                        $row_grades[21] += DB::table('approved_hitsuys')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                        ->count();
                        // ተምሃሮ A
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('super_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('middle_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->where('lower_leaders.evaluation', 'A')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('first_instant_leaders.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('experts.sum', [$A_LOWER, $A_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->where('tara_members.evaluation', 'A')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[22] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                        // ተምሃሮ B
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('super_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('middle_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->where('lower_leaders.evaluation', 'B')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('first_instant_leaders.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('experts.sum', [$B_LOWER, $B_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->where('tara_members.evaluation', 'B')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[23] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                        // ተምሃሮ C
                        {
                            $sl = DB::table('super_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('super_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ml = DB::table('middle_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('middle_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ll = DB::table('lower_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->where('lower_leaders.evaluation', 'C')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $fil = DB::table('first_instant_leaders')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('first_instant_leaders.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $ex = DB::table('experts')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->whereBetween('experts.sum', [$C_LOWER, $C_UPPER])
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $tm = DB::table('tara_members')
                            ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                            ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                            // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                            ->where('hitsuys.occupation', 'ተምሃራይ')
                            ->where('tara_members.evaluation', 'C')
                            ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])->count();

                            $row_grades[24] += $sl + $ml + $ll + $fil + $ex + $tm;
                        }
                    }
                }
                //punishments
                if($tabia['isUrban'] == 'ከተማ'){
                    $row_punishment[1] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('penaltyGiven', 'መጠንቀቕታ')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_punishment[2] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('penaltyGiven', 'ናይ ሕፀ እዋን ምንዋሕ')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_punishment[3] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('penaltyGiven', 'ካብ ሕፁይነት ምብራር')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_punishment[4] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('penaltyGiven', 'ካብ ሙሉእ ናብ ሕፁይ ኣባልነት ምውራድ')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_punishment[5] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('penaltyGiven', 'ካብ ሓላፍነት ንውሱን ጊዜ ምእጋድ')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_punishment[6] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('penaltyGiven', 'ካብ ሓላፍነት ምውራድ')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();   

                    $row_punishment[7] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('penaltyGiven', 'ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_punishment[8] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('penaltyGiven', 'ካብ ኣባልነት ምብራር')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();   

                    //TODO chargeTypes not set!!
                    $row_punishment[10] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereIn('chargeType', [])
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();   

                    $row_punishment[11] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereIn('chargeType', [])
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();   

                    $row_punishment[12] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereIn('chargeType', [''])
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();   

                    $row_punishment[13] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereIn('chargeType', [''])
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();   

                    $row_punishment[14] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereIn('chargeType', [''])
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_punishment[15] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('approved_hitsuys.gender', 'ኣን')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_punishment[16] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('approved_hitsuys.gender', 'ተባ')
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();

                    $row_punishment[17] += DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('approved_hitsuys.zoneworedaCode', $zoneCode.$woreda['woredaCode'].$tabia['tabiaCode'])
                    // ->whereBetween('penalties.created_at', [Carbon::createFromDate(2019,1,1), Carbon::createFromDate(2019,4,1)])
                    ->count();
                }
            }
            $row_weseking_gudletin[5] = $row_weseking_gudletin[2] + $row_weseking_gudletin[3] + $row_weseking_gudletin[4];
            $row_weseking_gudletin[14] = $row_weseking_gudletin[6] + $row_weseking_gudletin[7] + $row_weseking_gudletin[8] + $row_weseking_gudletin[9] + $row_weseking_gudletin[10] + $row_weseking_gudletin[11] + $row_weseking_gudletin[12] + $row_weseking_gudletin[13];
            $row_weseking_gudletin[15] = $row_weseking_gudletin[5] - $row_weseking_gudletin[14];
            $row_weseking_gudletin[1] = $row_weseking_gudletin[16] - $row_weseking_gudletin[15];

            $row_abalat_age_education[15] = $row_abalat_age_education[7] + $row_abalat_age_education[8] + $row_abalat_age_education[9] + $row_abalat_age_education[10] + $row_abalat_age_education[11] + $row_abalat_age_education[12] + $row_abalat_age_education[13] + $row_abalat_age_education[14];
            $row_wahio_count[5] = $row_wahio_count[1] + $row_wahio_count[2] + $row_wahio_count[3] + $row_wahio_count[4];
            $row_tabia_count[4] = $row_tabia_count[2] + $row_tabia_count[3];
            $row_tabia_count[10] = $row_tabia_count[5] + $row_tabia_count[6] + $row_tabia_count[7] + $row_tabia_count[8] + $row_tabia_count[9];
            $row_grades[5] =  $row_grades[1] - ($row_grades[2] + $row_grades[3] + $row_grades[4]);
            $row_grades[10] =  $row_grades[6] - ($row_grades[7] + $row_grades[8] + $row_grades[9]);
            $row_grades[15] =  $row_grades[11] - ($row_grades[12] + $row_grades[13] + $row_grades[14]);
            $row_grades[20] =  $row_grades[16] - ($row_grades[17] + $row_grades[18] + $row_grades[19]);
            $row_grades[25] =  $row_grades[21] - ($row_grades[22] + $row_grades[23] + $row_grades[24]);
            $row_punishment[9] =  $row_punishment[1] + $row_punishment[2] + $row_punishment[3] + $row_punishment[4] + $row_punishment[5] + $row_punishment[6] + $row_punishment[7] + $row_punishment[8];
            $row_punishment[15] =  $row_punishment[10] + $row_punishment[11] + $row_punishment[12] + $row_punishment[13] + $row_punishment[14];

            $weseking_gudletin[] = $row_weseking_gudletin;
            $abalat_age_education[] = $row_abalat_age_education;
            $abalat_mahberawi_bota[] = $row_abalat_mahberawi_bota;
            $abalat_deant[] = $row_abalat_deant;
            $wahio_count[] = $row_wahio_count;
            $tabia_count[] = $row_tabia_count;
            $plan_deant[] = $row_plan_deant;
            $plan_non_deant[] = $row_plan_non_deant;
            $plan_all[] = $row_plan_all;
            $model_members[] = $row_model_members;
            $new_members_non_deant[] = $row_new_members_non_deant;
            $new_members_deant[] = $row_new_members_deant;
            $approved_new_members[] = $row_approved_new_members;
            $grades[] = $row_grades;
            $punishment[] = $row_punishment;
            
        }
        return [$zoneName, $weseking_gudletin, $abalat_age_education, $abalat_mahberawi_bota, $abalat_deant, $wahio_count, $tabia_count, $plan_deant, $plan_non_deant, $plan_all, $model_members, $new_members_non_deant, $new_members_deant, $approved_new_members, $grades, $punishment];
    }
    public function index(Request $request)
    {
        $zoneCode = "01";
        $zoneName = Zobatat::where('zoneCode', $zoneCode)->select(['zoneName'])->first()->toArray()['zoneName'];
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $zoneName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $data = $this->loadData($zoneCode);
        $objPHPExcel = new PHPExcel();


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ወሰኽን ጉድለትን ኣሃዛዊ መረዳእታ '.$data[0])
            ->setCellValue('A2', 'ወረዳ')
            ->setCellValue('B2', 'መበገሲ ኣባል')
            ->setCellValue('C2', 'ምኽንያት ወሰኽ')
            ->setCellValue('G2', 'ምኽንያት ጉድለት')
            ->setCellValue('P2', 'ሚዛን')
            ->setCellValue('Q2', 'ሕዚ ዘሎ በዝሒ ኣባል')
            ->setCellValue('C3', 'ብምልመላ')
            ->setCellValue('D3', 'ካብ ካሊእ ዞባ ብዝውውር ዝመፁ')
            ->setCellValue('E3', 'ተኣጊዱ ዝነበረ')
            ->setCellValue('F3', 'ድምር ወሰኽ')
            ->setCellValue('G3', 'ብሞት')
            ->setCellValue('H3', 'ብምብራር')
            ->setCellValue('I3', 'ብምእጋድ')
            ->setCellValue('J3', 'ብዝውውር ናብ')
            ->setCellValue('N3', 'ብስንብት')
            ->setCellValue('O3', 'ድምር ጉድለት')
            ->setCellValue('J4', 'ዩኒቨርሲቲ')
            ->setCellValue('K4', 'ኣብ ዞባ ውሽጢ')
            ->setCellValue('L4', 'ናብ ካሊእ ዞባ')
            ->setCellValue('M4', 'ካብ ክልል ወፃኢ')
            ->mergeCells('A1:R1')
            ->mergeCells('A2:A4')
            ->mergeCells('B2:B4')
            ->mergeCells('C2:F2')
            ->mergeCells('G2:O2')
            ->mergeCells('P2:P4')
            ->mergeCells('Q2:Q4')
            ->mergeCells('C3:C4')
            ->mergeCells('D3:D4')
            ->mergeCells('E3:E4')
            ->mergeCells('F3:F4')
            ->mergeCells('G3:G4')
            ->mergeCells('H3:H4')
            ->mergeCells('I3:I4')
            ->mergeCells('J3:M3')
            ->mergeCells('N3:N4')
            ->mergeCells('O3:O4');
        $i = 5;

        foreach ($data[1] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ናይ 3ተ ወርሒ ከተማ ኣባል '. $data[0])
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+1), 'ደረጃ ኣባልነት')
            ->setCellValue('E'.($i+1), 'ደረጃ ዕድመ')
            ->setCellValue('H'.($i+1), 'ደረጃ ትምህርቲ')
            ->setCellValue('B'.($i+2), 'ሙሉእ')
            ->setCellValue('C'.($i+2), 'ሕፁይ')
            ->setCellValue('D'.($i+2), 'ድምር')
            ->setCellValue('E'.($i+2), '18-35')
            ->setCellValue('F'.($i+2), '36-60')
            ->setCellValue('G'.($i+2), 'ካብ 61 ንላዕሊ')
            ->setCellValue('H'.($i+2), 'ዘይተምሃረ')
            ->setCellValue('I'.($i+2), '1-8')
            ->setCellValue('J'.($i+2), '9-12')
            ->setCellValue('K'.($i+2), 'ሰርቲፍኬት')
            ->setCellValue('L'.($i+2), 'ዲፕሎማ')
            ->setCellValue('M'.($i+2), 'ዲግሪ')
            ->setCellValue('N'.($i+2), 'MS')
            ->setCellValue('O'.($i+2), 'ዶክተር')
            ->setCellValue('P'.($i+2), 'ድምር')
            ->mergeCells('A'.$i.':P'.$i)
            ->mergeCells('A'.($i+1).':A'.($i+2))
            ->mergeCells('B'.($i+1).':D'.($i+1))
            ->mergeCells('E'.($i+1).':G'.($i+1))
            ->mergeCells('H'.($i+1).':P'.($i+1));

        $i += 3;
        foreach ($data[2] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }


        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ናይ 3ተ ወርሒ ከተማ ኣባል '. $data[0])
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+1), 'ማሕበራዊ ቦታ')
            ->setCellValue('G'.($i+1), 'ዕድመ ኣባልነት')
            ->setCellValue('K'.($i+1), 'ኣብ ማሕበራት ዘሎ ኣባል')
            ->setCellValue('N'.($i+1), 'ብዘለዎ ስራሕ')
            ->setCellValue('Q'.($i+1), 'ብፆታ')
            ->setCellValue('B'.($i+2), 'ደኣንት')
            ->setCellValue('C'.($i+2), 'ሸቃሎ')
            ->setCellValue('D'.($i+2), 'ካልኦት ሰብ ሞያ')
            ->setCellValue('E'.($i+2), 'መምህራን')
            ->setCellValue('F'.($i+2), 'ተምሃሮ')
            ->setCellValue('G'.($i+2), '67-83')
            ->setCellValue('H'.($i+2), '84-93')
            ->setCellValue('I'.($i+2), '94-2000')
            ->setCellValue('J'.($i+2), 'ድሕሪ 2001')
            ->setCellValue('K'.($i+2), 'ደ/ኣንስትዮ')
            ->setCellValue('L'.($i+2), 'መናእሰይ')
            ->setCellValue('M'.($i+2), 'መምህራን')
            ->setCellValue('N'.($i+2), 'መ/ሰራሕተኛ')
            ->setCellValue('O'.($i+2), 'ዘይመንግስታዊ')
            ->setCellValue('P'.($i+2), 'ብውልቀ')
            ->setCellValue('Q'.($i+2), 'ደ/ኣንስትዮ')
            ->setCellValue('R'.($i+2), 'ድምር')
            ->mergeCells('A'.$i.':R'.$i)
            ->mergeCells('A'.($i+1).':A'.($i+2))
            ->mergeCells('B'.($i+1).':F'.($i+1).'')
            ->mergeCells('G'.($i+1).':J'.($i+1).'')
            ->mergeCells('K'.($i+1).':M'.($i+1).'')
            ->mergeCells('N'.($i+1).':P'.($i+1).'')
            ->mergeCells('Q'.($i+1).':R'.($i+1).'');

        $i += 3;
        foreach ($data[3] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }



        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ኣብ ደኣንት ዘሎ ኣባል '. $data[0])
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+1), 'ማሕበራዊ ቦታ')
            ->setCellValue('G'.($i+1), 'ዕድመ ኣባልነት')
            ->setCellValue('K'.($i+1), 'ኣብ ማሕበራዊ ቦታ ደኣንት')
            ->setCellValue('N'.($i+1), 'ብዘለዎ ስራሕ')
            ->setCellValue('Q'.($i+1), 'ብፆታ')
            ->setCellValue('B'.($i+2), 'መፍረይቲ')
            ->setCellValue('C'.($i+2), 'ከ/ሕርሻ')
            ->setCellValue('D'.($i+2), 'ኮንስትራክሽን')
            ->setCellValue('E'.($i+2), 'ንግዲ')
            ->setCellValue('F'.($i+2), 'ግልጋሎት')
            ->setCellValue('G'.($i+2), '67-83')
            ->setCellValue('H'.($i+2), '84-93')
            ->setCellValue('I'.($i+2), '94-2000')
            ->setCellValue('J'.($i+2), 'ድሕሪ 2001')
            ->setCellValue('K'.($i+2), 'ደ/ኣንስትዮ')
            ->setCellValue('L'.($i+2), 'መናእሰይ')
            ->setCellValue('M'.($i+2), 'መምህራን')
            ->setCellValue('N'.($i+2), 'መ/ሰራሕተኛ')
            ->setCellValue('O'.($i+2), 'ዘይመንግስታዊ')
            ->setCellValue('P'.($i+2), 'ብውልቀ')
            ->setCellValue('Q'.($i+2), 'ደ/ኣንስትዮ')
            ->setCellValue('R'.($i+2), 'ድምር')
            ->mergeCells('A'.$i.':R'.$i)
            ->mergeCells('A'.($i+1).':A'.($i+2))
            ->mergeCells('B'.($i+1).':F'.($i+1).'')
            ->mergeCells('G'.($i+1).':J'.($i+1).'')
            ->mergeCells('K'.($i+1).':M'.($i+1).'')
            ->mergeCells('N'.($i+1).':P'.($i+1).'')
            ->mergeCells('Q'.($i+1).':R'.($i+1).'');

        $i += 3;
        foreach ($data[4] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'በዝሒ ዋህዮታት ከተማ ካብ ደኣንት ወፃኢ '. $data[0])
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+1), 'ተምሃሮ')
            ->setCellValue('C'.($i+1), 'መምህራን')
            ->setCellValue('D'.($i+1), 'ካልኦት ሰብ ሞያ')
            ->setCellValue('E'.($i+1), 'ሸቃሎ')
            ->setCellValue('F'.($i+1), 'ድምር')
            ->setCellValue('G'.($i+1), 'ጠቕላላ ድምር ዋህዮ ኣብ ከተማ')
            ->mergeCells('A'.$i.':G'.$i);


        $i += 2;
        foreach ($data[5] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }


        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data[0].': በዝሒ ወረዳ፣ ቀበሌታትን ውዳበ ከተማ ')
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+1), 'በዝሒ ቀበሌታት')
            ->setCellValue('C'.($i+1), 'ቀበሌታት ብበዝሒ ኣባላተን')
            ->setCellValue('F'.($i+1), 'በዝሒ መ/ውዳበታት')
            ->setCellValue('M'.($i+1), 'በዝሒ መ/ውዳበታት ካብ ከተማ ወፃኢ')
            ->setCellValue('Q'.($i+1), 'ጠ/ድምር መ/ውዳበታት')
            ->setCellValue('C'.($i+2), 'ልዕሊ 500')
            ->setCellValue('D'.($i+2), '500ን ትሕቲኡ')
            ->setCellValue('E'.($i+2), 'ድምር')
            ->setCellValue('F'.($i+2), 'መፍረይቲ')
            ->setCellValue('G'.($i+2), 'ከተማ ሕርሻ')
            ->setCellValue('H'.($i+2), 'ኮንስትራክሽን')
            ->setCellValue('I'.($i+2), 'ንግዲ')
             ->setCellValue('J'.($i+2), 'ግልጋሎት')
            ->setCellValue('K'.($i+2), 'ድምር')
            ->setCellValue('L'.($i+2), 'ሸቃሎ')
            ->setCellValue('M'.($i+2), 'ተምሃሮ')
            ->setCellValue('N'.($i+2), 'መምህራን')
            ->setCellValue('O'.($i+2), 'ካልኦት ሰብ ሞያ')
            ->setCellValue('P'.($i+2), 'ድምር')
            ->mergeCells('A'.$i.':P'.$i)
            ->mergeCells('A'.($i+1).':A'.($i+2))
            ->mergeCells('B'.($i+1).':B'.($i+2))
            ->mergeCells('C'.($i+1).':E'.($i+1))
            ->mergeCells('F'.($i+1).':L'.($i+1))
            ->mergeCells('M'.($i+1).':P'.($i+1))
            ->mergeCells('Q'.($i+1).':Q'.($i+2));

        $i += 3;
        foreach ($data[6] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data[0].': ደኣንት ትልሚ')
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+1), 'ትልሚ ምድላው መ/ውዳበ ደኣንት')
            ->setCellValue('L'.($i+1), 'ድምር መ/ውዳበታት')
            ->setCellValue('B'.($i+2), 'መፍረይቲ')
            ->setCellValue('D'.($i+2), 'ከተማ ሕርሻ')
            ->setCellValue('F'.($i+2), 'ኮንስትራክሽን')
            ->setCellValue('H'.($i+2), 'ንግዲ')
            ->setCellValue('J'.($i+2), 'ግልጋሎት')
            ->setCellValue('B'.($i+3), 'መበገሲ')
            ->setCellValue('C'.($i+3), 'ዘውፅአ')
            ->setCellValue('D'.($i+3), 'መበገሲ')
            ->setCellValue('E'.($i+3), 'ዘውፅአ')
            ->setCellValue('F'.($i+3), 'መበገሲ')
            ->setCellValue('G'.($i+3), 'ዘውፅአ')
            ->setCellValue('H'.($i+3), 'መበገሲ')
            ->setCellValue('I'.($i+3), 'ዘውፅአ')
            ->setCellValue('J'.($i+3), 'መበገሲ')
            ->setCellValue('K'.($i+3), 'ዘውፅአ')
            ->setCellValue('L'.($i+3), 'መበገሲ')
            ->setCellValue('M'.($i+3), 'ዘውፅአ')
            ->setCellValue('N'.($i+3), '%')
            ->mergeCells('A'.$i.':O'.$i)
            ->mergeCells('A'.($i+1).':A'.($i+3))
            ->mergeCells('B'.($i+1).':K'.($i+1))
            ->mergeCells('L'.($i+1).':N'.($i+2))
            ->mergeCells('B'.($i+2).':C'.($i+2))
            ->mergeCells('D'.($i+2).':E'.($i+2))
            ->mergeCells('F'.($i+2).':G'.($i+2))
            ->mergeCells('H'.($i+2).':I'.($i+2))
            ->mergeCells('J'.($i+2).':K'.($i+2));

        $i += 4;
        foreach ($data[7] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }


        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data[0].': ካብ ደኣንት ወፃኢ ትልሚ')
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+1), 'ትልሚ ምድላው መ/ውዳበ ደኣንት')
            ->setCellValue('J'.($i+1), 'ድምር መ/ውዳበታት')
            ->setCellValue('B'.($i+2), 'ሸቃሎ')
            ->setCellValue('D'.($i+2), 'ተምሃሮ')
            ->setCellValue('F'.($i+2), 'መምህራን')
            ->setCellValue('H'.($i+2), 'ካልኦት ሰብ ሞያ')
            ->setCellValue('B'.($i+3), 'መበገሲ')
            ->setCellValue('C'.($i+3), 'ዘውፅአ')
            ->setCellValue('D'.($i+3), 'መበገሲ')
            ->setCellValue('E'.($i+3), 'ዘውፅአ')
            ->setCellValue('F'.($i+3), 'መበገሲ')
            ->setCellValue('G'.($i+3), 'ዘውፅአ')
            ->setCellValue('H'.($i+3), 'መበገሲ')
            ->setCellValue('I'.($i+3), 'ዘውፅአ')
            ->setCellValue('J'.($i+3), 'መበገሲ')
            ->setCellValue('K'.($i+3), 'ዘውፅአ')
            ->setCellValue('L'.($i+3), '%')
            ->mergeCells('A'.$i.':L'.$i)
            ->mergeCells('A'.($i+1).':A'.($i+3))
            ->mergeCells('B'.($i+1).':I'.($i+1))
            ->mergeCells('J'.($i+1).':L'.($i+2))
            ->mergeCells('B'.($i+2).':C'.($i+2))
            ->mergeCells('D'.($i+2).':E'.($i+2))
            ->mergeCells('F'.($i+2).':G'.($i+2))
            ->mergeCells('H'.($i+2).':I'.($i+2));

        $i += 4;
        foreach ($data[8] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, 'ዞባ '.$data[0].': በቢደረጅኡ ትልሚ ምድላው ዝምልከት')
          ->setCellValue('A'.($i+1), 'ወረዳ')
          ->setCellValue('B'.($i+1), 'ውልቀ ኣባል')
          ->setCellValue('E'.($i+1), 'መ/ውዳበ')
          ->setCellValue('H'.($i+1), 'ዋህዮታት')
          ->setCellValue('K'.($i+1), 'መብርሂ')
          ->setCellValue('B'.($i+2), 'መበገሲ')
          ->setCellValue('C'.($i+2), 'ዘውፅአ')
          ->setCellValue('D'.($i+2), '%')
          ->setCellValue('E'.($i+2), 'መበገሲ')
          ->setCellValue('F'.($i+2), 'ዘውፅአ')
          ->setCellValue('G'.($i+2), '%')
          ->setCellValue('H'.($i+2), 'መበገሲ')
          ->setCellValue('I'.($i+2), 'ዘውፅአ')
          ->setCellValue('J'.($i+2), '%')
          ->mergeCells('A'.$i.':K'.$i)
          ->mergeCells('A'.($i+1).':A'.($i+2))
          ->mergeCells('B'.($i+1).':D'.($i+1))
          ->mergeCells('E'.($i+1).':G'.($i+1))
          ->mergeCells('H'.($i+1).':J'.($i+1))
          ->mergeCells('K'.($i+1).':K'.($i+2))
          ;

        $i += 3;
        foreach ($data[9] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }


        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, 'ዞባ '.$data[0].': ሞዴል ኣመራርሓ መ/ውዳበን ዋህዮታትን')
          ->setCellValue('A'.($i+1), 'ወረዳ')
          ->setCellValue('B'.($i+1), 'መ/ውዳበ ኣመራርሓ')
          ->setCellValue('F'.($i+1), 'ዋህዮታት ኣመራርሓ')
          ->setCellValue('J'.($i+1), 'ዋህዮታት ደ/ኣንስትዮ ኣመራርሓ')
          ->setCellValue('N'.($i+1), 'መብርሂ')
          ->setCellValue('B'.($i+2), 'መበገሲ')
          ->setCellValue('C'.($i+2), 'ሞዴል')
          ->setCellValue('D'.($i+2), 'ዘይኮኑ')
          ->setCellValue('E'.($i+2), '%')
          ->setCellValue('F'.($i+2), 'መበገሲ')
          ->setCellValue('G'.($i+2), 'ሞዴል')
          ->setCellValue('H'.($i+2), 'ዘይኮኑ')
          ->setCellValue('I'.($i+2), '%')
          ->setCellValue('J'.($i+2), 'መበገሲ')
          ->setCellValue('K'.($i+2), 'ሞዴል')
          ->setCellValue('L'.($i+2), 'ዘይኮኑ')
          ->setCellValue('M'.($i+2), '%')
          ->mergeCells('A'.$i.':N'.$i)
          ->mergeCells('A'.($i+1).':A'.($i+2))
          ->mergeCells('B'.($i+1).':E'.($i+1))
          ->mergeCells('F'.($i+1).':I'.($i+1))
          ->mergeCells('J'.($i+1).':M'.($i+1))
          ->mergeCells('N'.($i+1).':N'.($i+2));

        $i += 3;
        foreach ($data[10] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue('A'.$i, 'ዞባ '.$data[0].': ኣፈፃፅማ ምልመላ ሓደሽቲ ኣባላት ውድብ ካብ ደኣንት ወፃኢ')
             ->setCellValue('A'.($i+1), 'ወረዳ')
             ->setCellValue('B'.($i+1), 'ካልኦት ሰብ ሞያ')
             ->setCellValue('D'.($i+1), 'ሸቃሎ')
             ->setCellValue('F'.($i+1), 'ተምሃሮ')
             ->setCellValue('H'.($i+1), 'መምህራን')
             ->setCellValue('J'.($i+1), 'ድምር ፍፃመ ምልመላ')
             ->setCellValue('B'.($i+2), 'ትልሚ')
             ->setCellValue('C'.($i+2), 'ፍፃመ')
             ->setCellValue('D'.($i+2), 'ትልሚ')
             ->setCellValue('E'.($i+2), 'ፍፃመ')
             ->setCellValue('F'.($i+2), 'ትልሚ')
             ->setCellValue('G'.($i+2), 'ፍፃመ')
             ->setCellValue('H'.($i+2), 'ትልሚ')
             ->setCellValue('I'.($i+2), 'ፍፃመ')
             ->mergeCells('A'.$i.':J'.$i)
             ->mergeCells('A'.($i+1).':A'.($i+2))
             ->mergeCells('B'.($i+1).':C'.($i+1))
             ->mergeCells('D'.($i+1).':E'.($i+1))
             ->mergeCells('F'.($i+1).':G'.($i+1))
             ->mergeCells('H'.($i+1).':I'.($i+1))
             ->mergeCells('J'.($i+1).':J'.($i+2));

        $i += 3;
        foreach ($data[11] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, 'ዞባ '.$data[0].': ኣፈፃፅማ ምልመላ ሓደሽቲ ኣባላት ውድብ ደኣንት')
          ->setCellValue('A'.($i+1), 'ወረዳ')
          ->setCellValue('B'.($i+1), 'መፍረይቲ')
          ->setCellValue('D'.($i+1), 'ከተማ ሕርሻ')
          ->setCellValue('F'.($i+1), 'ኮንስትራክሽን')
          ->setCellValue('H'.($i+1), 'ንግዲ')
          ->setCellValue('J'.($i+1), 'ግልጋሎት')
          ->setCellValue('L'.($i+1), 'ድምር ፍፃመ ምልመላ')
          ->setCellValue('B'.($i+2), 'ትልሚ')
          ->setCellValue('C'.($i+2), 'ፍፃመ')
          ->setCellValue('D'.($i+2), 'ትልሚ')
          ->setCellValue('E'.($i+2), 'ፍፃመ')
          ->setCellValue('F'.($i+2), 'ትልሚ')
          ->setCellValue('G'.($i+2), 'ፍፃመ')
          ->setCellValue('H'.($i+2), 'ትልሚ')
          ->setCellValue('I'.($i+2), 'ፍፃመ')
          ->setCellValue('J'.($i+2), 'ትልሚ')
          ->setCellValue('K'.($i+2), 'ፍፃመ')
          ->mergeCells('A'.$i.':L'.$i)
          ->mergeCells('A'.($i+1).':A'.($i+2))
          ->mergeCells('B'.($i+1).':C'.($i+1))
          ->mergeCells('D'.($i+1).':E'.($i+1))
          ->mergeCells('F'.($i+1).':G'.($i+1))
          ->mergeCells('H'.($i+1).':I'.($i+1))
          ->mergeCells('J'.($i+1).':K'.($i+1))
          ->mergeCells('L'.($i+1).':L'.($i+2));

        $i += 3;
        foreach ($data[12] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data[0].': ካብ ብርኪ ሕፁይነት ናብ ሙሉእ ዝሰገሩ ፀብፃብ')
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+1), 'ክስግሩ ዝግበኦም ወይ ሽቶ')
            ->setCellValue('E'.($i+1), 'ፍፃመ')
            ->setCellValue('I'.($i+1), 'ምኽንያት ዘይምስጋር')
            ->setCellValue('L'.($i+1), 'ግዚኦም ዘይኣኸለ')
            ->setCellValue('B'.($i+2), 'ተባ')
            ->setCellValue('C'.($i+2), 'ኣን')
            ->setCellValue('D'.($i+2), 'ድምር')
            ->setCellValue('E'.($i+2), 'ተባ')
            ->setCellValue('F'.($i+2), 'ኣን')
            ->setCellValue('G'.($i+2), 'ድምር')
            ->setCellValue('H'.($i+2), '%')
            ->setCellValue('I'.($i+2), 'ብቕፅዓት')
            ->setCellValue('J'.($i+2), 'ተሰናቢቱ')
            ->setCellValue('K'.($i+2), 'ብድኽመት')
            ->mergeCells('A'.$i.':L'.$i)
            ->mergeCells('A'.($i+1).':A'.($i+2))
            ->mergeCells('B'.($i+1).':D'.($i+1))
            ->mergeCells('E'.($i+1).':H'.($i+1))
            ->mergeCells('I'.($i+1).':K'.($i+1))
            ->mergeCells('L'.($i+1).':L'.($i+2));

        $i += 3;
        foreach ($data[13] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }


        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data[0].': ስርርዕ ኣባልን ኣመራርሓን ከተማ')
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+1), 'ደኣንት')
            ->setCellValue('G'.($i+1), 'ሸቃሎ')
            ->setCellValue('L'.($i+1), 'ካልኦት ሰብ ሞያ')
            ->setCellValue('Q'.($i+1), 'መምህራን')
            ->setCellValue('V'.($i+1), 'ተምሃሮ')
            ->setCellValue('B'.($i+2), 'በዝሒ')
            ->setCellValue('C'.($i+2), 'A')
            ->setCellValue('D'.($i+2), 'B')
            ->setCellValue('E'.($i+2), 'C')
            ->setCellValue('F'.($i+2), 'ዘይተሰርዑ')
            ->setCellValue('G'.($i+2), 'በዝሒ')
            ->setCellValue('H'.($i+2), 'A')
            ->setCellValue('I'.($i+2), 'B')
            ->setCellValue('J'.($i+2), 'C')
            ->setCellValue('K'.($i+2), 'ዘይተሰርዑ')
            ->setCellValue('L'.($i+2), 'በዝሒ')
            ->setCellValue('M'.($i+2), 'A')
            ->setCellValue('N'.($i+2), 'B')
            ->setCellValue('O'.($i+2), 'C')
            ->setCellValue('P'.($i+2), 'ዘይተሰርዑ')
            ->setCellValue('Q'.($i+2), 'በዝሒ')
            ->setCellValue('R'.($i+2), 'A')
            ->setCellValue('S'.($i+2), 'B')
            ->setCellValue('T'.($i+2), 'C')
            ->setCellValue('U'.($i+2), 'ዘይተሰርዑ')
            ->setCellValue('V'.($i+2), 'በዝሒ')
            ->setCellValue('W'.($i+2), 'ቶፕ 20')
            ->setCellValue('X'.($i+2), 'ማእኸላይ')
            ->setCellValue('Y'.($i+2), 'ትሑት')
            ->setCellValue('Z'.($i+2), 'ዘይተሰርዑ')
            ->mergeCells('A'.$i.':Z'.$i)
            ->mergeCells('A'.($i+1).':A'.($i+2))
            ->mergeCells('B'.($i+1).':F'.($i+1))
            ->mergeCells('G'.($i+1).':K'.($i+1))
            ->mergeCells('L'.($i+1).':P'.($i+1))
            ->mergeCells('Q'.($i+1).':U'.($i+1))
            ->mergeCells('V'.($i+1).':Z'.($i+1));

        $i += 3;
        foreach ($data[14] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data[0].': ቅፅዓት ዝምልከት')
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+1), 'ዓይነት ቅፅዓት')
            ->setCellValue('K'.($i+1), 'ምኽንያት ቅፅዓት')
            ->setCellValue('P'.($i+1), 'ዝተቐፅዑ ብፃታ')
            ->setCellValue('B'.($i+2), 'መጠንቐቕታ')
            ->setCellValue('C'.($i+2), 'ሕፀ ዝተናውሐ')
            ->setCellValue('D'.($i+2), 'ካብ ሕፀ ዝተባረሩ')
            ->setCellValue('E'.($i+2), 'ናብ ሕፀ ዝወረዱ')
            ->setCellValue('F'.($i+2), 'ካብ ሓላፍነት ዝተኣገዱ')
            ->setCellValue('G'.($i+2), 'ካብ ሓላፍነት ዝወረዱ')
            ->setCellValue('H'.($i+2), 'ካብ ኣባልነት ዝተኣገዱ')
            ->setCellValue('I'.($i+2), 'ካብ ኣባልነት ዝተባረሩ')
            ->setCellValue('J'.($i+2), 'ድምር')
            ->setCellValue('K'.($i+2), 'ናይ ኣረኣእያ ፀገም')
            ->setCellValue('L'.($i+2), 'ስነ-ምግበር')
            ->setCellValue('M'.($i+2), 'ግቡእ ዘይምፍፃም')
            ->setCellValue('N'.($i+2), 'ዓቕሚ ምንኣስ')
            ->setCellValue('O'.($i+2), 'ፀረ ዲሞክራሲ')
            ->setCellValue('P'.($i+2), 'ኣነ')
            ->setCellValue('Q'.($i+2), 'ተባ')
            ->setCellValue('R'.($i+2), 'ድምር')
            ->mergeCells('A'.$i.':R'.$i)
            ->mergeCells('A'.($i+1).':A'.($i+2))
            ->mergeCells('B'.($i+1).':J'.($i+1))
            ->mergeCells('K'.($i+1).':O'.($i+1))
            ->mergeCells('P'.($i+1).':R'.($i+1))
            ->mergeCells('B'.($i+1).':J'.($i+1));

        $i += 3;
        foreach ($data[15] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $style = array(
            'alignment' => array('horizontal' =>PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        //     'borders' => array(
        //         'allborders' => array(
        //             'style' => PHPExcel_Style_Borders::BORDER_THICK,
        //             'color' => array('rgb' => '000000')
        //         )
        // )
        );

        // PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
        foreach (range('A', 'Z') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getDefaultStyle()->applyFromArray($style);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}
