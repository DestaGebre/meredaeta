<?php

namespace App\Http\Controllers;

require_once substr(dirname(__FILE__), 0, -17).'\PHPExcel-1.8\Classes\PHPExcel.php';

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
// use PHPExcel_Style_Borders;
use PHPExcel_Shared_Font;

use Auth;

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
use App\DateConvert;
use DB;

use Carbon\Carbon;

use Illuminate\Http\Request;

class KetemaReportExcelNew extends Controller
{
    private function loadData($zoneCode){
        $today = DateConvert::toEthiopian(date('d/m/Y'));
        $quarter = [];
        $st = (int)(((int)explode("/", $today)[1]-1)/3)*3+1;
        $quarter_names = ['3 ወርሒ', '6 ወርሒ', '9 ወርሒ', 'ዓመት'];
        $this_quarter = $quarter_names[(($st-1)/3)];
        $quarter[] = DateConvert::toGregorian('1/' . $st . '/' .explode("/", $today)[2]);
        $quarter[] = DateConvert::toGregorian('1/' . ($st+3) . '/' . explode("/", $today)[2]);
        $A_UPPER = 100;
        $A_LOWER = 80;
        $B_UPPER = 79;
        $B_LOWER = 66;
        $C_UPPER = 65;
        $C_LOWER = 0;
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
            // Wesekin gudletin table
            {
                $row_weseking_gudletin[2] = DB::table('hitsuys')
                    ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT('tabias.parentcode', tabias.tabiaCode, '%')"))
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('hitsuy_status', 'ሕፁይ')
                    ->whereBetween('hitsuys.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                $row_weseking_gudletin[3] = DB::table('transfers')
                    ->where('transfers.zone', $zoneCode)
                    ->where('transfers.woreda', $woreda['woredaCode'])
                    ->join('tabias', 'transfers.tabia', '=', 'tabias.tabiaCode')
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->whereBetween('transfers.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                // TODO ተኣጊዱ ዝነበረ
                $row_weseking_gudletin[4] = 0;

                $row_weseking_gudletin[5] = $row_weseking_gudletin[2] + $row_weseking_gudletin[3] + $row_weseking_gudletin[4];

                $row_weseking_gudletin[6] = DB::table('dismisses')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    // ->where('approved_hitsuys.zoneworedaCode', '=', '010080034')
                    ->where('dismissReason', 'ብሞት')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    ->whereBetween('dismisses.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();


                $row_weseking_gudletin[7] = DB::table('dismisses')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    // ->where('approved_hitsuys.zoneworedaCode', '=', '010080034')
                    ->where('dismissReason', 'ብቕፅዓት')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    ->whereBetween('dismisses.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                $row_weseking_gudletin[8] = DB::table('penalties')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('approved_hitsuys.zoneworedaCode', '=', '010080034')
                    ->where('penaltyGiven', 'ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ')
                    ->where('hitsuys.hitsuy_status', 'ዝተኣገደ')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                //TODO University
                $row_weseking_gudletin[9] = Transfer::where('oldzone', $zoneCode)
                    ->where('oldworeda', $woreda['woredaCode'])
                    ->whereBetween('created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                $row_weseking_gudletin[10] = Transfer::where('oldzone', $zoneCode)
                    ->where('oldworeda', $woreda['woredaCode'])
                    ->whereBetween('created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                $row_weseking_gudletin[11] = Transfer::where('oldzone', $zoneCode)
                    ->where('oldworeda', $woreda['woredaCode'])
                    ->where('zone','NOT', $zoneCode)
                    ->whereBetween('created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                //TODO out of region
                $row_weseking_gudletin[12] = Transfer::where('oldzone', $zoneCode)
                ->where('oldworeda', $woreda['woredaCode'])
                ->where('zone','NOT', $zoneCode)
                ->whereBetween('created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_weseking_gudletin[13] = DB::table('dismisses')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
                    ->whereIn('dismissReason', ['ናይ ውልቀ ሰብ ሕቶ', 'ብኽብሪ' , 'ካሊእ'])
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    ->whereBetween('dismisses.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                $row_weseking_gudletin[14] = $row_weseking_gudletin[6] + $row_weseking_gudletin[7] + $row_weseking_gudletin[8] + $row_weseking_gudletin[9] + $row_weseking_gudletin[10] + $row_weseking_gudletin[11] + $row_weseking_gudletin[12] + $row_weseking_gudletin[13];
                $row_weseking_gudletin[15] = $row_weseking_gudletin[5] - $row_weseking_gudletin[14];

                $row_weseking_gudletin[16] = DB::table('approved_hitsuys')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->where('hitsuys.hitsuy_status', 'ኣባል')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    ->count()
                + DB::table('hitsuys')
                    ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '/%')"))
                    ->where('hitsuy_status', 'ሕፁይ')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    ->count();
            }
            //abalat age, education
            {
                $fm = ApprovedHitsuy::where('zoneworedaCode', 'LIKE', $zoneCode.$woreda['woredaCode'].'%')->count();
                $cd = Hitsuy::where('hitsuyID','LIKE', $zoneCode.$woreda['woredaCode'].'%')->where('hitsuy_status', 'ሕፁይ')->count();
                $row_abalat_age_education[1] = $fm;
                $row_abalat_age_education[2] = $cd;
                $row_abalat_age_education[3] = ($fm + $cd);

                // 18 - 35
                $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('hitsuys.dob', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[4] = ($fm + $cd);

                // 36 - 60
                $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('hitsuys.dob', [Carbon::today()->subYears(60), Carbon::today()->subYears(35)])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(60), Carbon::today()->subYears(35)])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[5] = ($fm + $cd);

                // above 60
                $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('hitsuys.dob', [Carbon::today()->subYears(150), Carbon::today()->subYears(60)])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(150), Carbon::today()->subYears(60)])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[6] = ($fm + $cd);

                // illiterate [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዘይተምሃረ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዘይተምሃረ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[7] = ($fm + $cd);

                // 1-8 [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('hitsuys.educationlevel', [1, 8])
                ->count();
                $cd = Hitsuy::whereIn('hitsuys.educationlevel', [1, 8])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[8] = ($fm + $cd);

                // 9-12 [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('hitsuys.educationlevel', [9, 12])
                ->count();
                $cd = Hitsuy::whereIn('hitsuys.educationlevel', [9, 12])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[9] = ($fm + $cd);

                // certificate [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ሰርቲፊኬት')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ሰርቲፊኬት')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[10] = ($fm + $cd);

                // diploma [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዲፕሎማ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዲፕሎማ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[11] = ($fm + $cd);


                // degree [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዲግሪ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዲግሪ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[12] = ($fm + $cd);

                // master's [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ማስተርስ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ማስተርስ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[13] = ($fm + $cd);

                // PhD [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዶክተር')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዶክተር')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[14] = ($fm + $cd);

                // Sum
                $row_abalat_age_education[15] = $row_abalat_age_education[7] + $row_abalat_age_education[8] + $row_abalat_age_education[9] + $row_abalat_age_education[10] + $row_abalat_age_education[11] + $row_abalat_age_education[12] + $row_abalat_age_education[13] + $row_abalat_age_education[14];
            }
            //abalat mahberawi bota
            {
                // deant
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                ->count();
                $cd = Hitsuy::whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')->count();
                $row_abalat_mahberawi_bota[1] = ($fm + $cd);

                // shekalo
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ሸቃላይ')
                ->count();
                $cd = Hitsuy::where('hitsuys.occupation', 'ሸቃላይ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')->count();
                $row_abalat_mahberawi_bota[2] = ($fm + $cd);

                // ካልኦት ሰብ ሞያ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->count();
                $cd = DB::table('hitsuys')->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[3] = ($fm + $cd);

                // መምህር
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'መምህር')
                ->count();
                $cd = Hitsuy::where('hitsuys.occupation', 'መምህር')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')->count();
                $row_abalat_mahberawi_bota[4] = ($fm + $cd);

                // ተምሃራይ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ተምሃራይ')
                ->count();
                $cd = Hitsuy::where('hitsuys.occupation', 'ተምሃራይ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[5] = ($fm + $cd);

                // 67 - 83
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1967,1,1), Carbon::createFromDate(1983,1,1)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[6] = ($fm + $cd);

                // 84 - 93
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1983,1,1), Carbon::createFromDate(1993,1,1)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[7] = ($fm + $cd);

                // 94 - 2000
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1993,1,1), Carbon::createFromDate(2000,1,1)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[8] = ($fm + $cd);

                // after 2001
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(2000,1,1), Carbon::createFromDate(9000,1,1)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[9] = ($fm + $cd);

                // ደቂ ኣንስትዮ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.assignedAssoc','ደቂ ኣንስትዮ')
                ->count();
                $row_abalat_mahberawi_bota[10] = ($fm + $cd);

                // መናእሰይ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.assignedAssoc','መናእሰይ')
                ->count();
                $row_abalat_mahberawi_bota[11] = ($fm + $cd);

                // መምህራን
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.assignedAssoc','መምህራን')
                ->count();
                $row_abalat_mahberawi_bota[12] = ($fm + $cd);

                // መንግስቲ ሰራሕተኛ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->count();
                $cd = DB::table('hitsuys')->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[13] = ($fm + $cd);

                // ዘይመንግስታዊ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ዘይመንግስታዊ')
                ->count();
                $cd = DB::table('hitsuys')->where('hitsuys.occupation', 'ዘይመንግስታዊ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[14] = ($fm + $cd);

                // ውልቀ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ውልቀ')
                ->count();
                $cd = DB::table('hitsuys')
                ->where('hitsuys.occupation', 'ውልቀ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[15] = ($fm + $cd);

                // ደቂ ኣንስትዮ
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('gender', 'ኣን')
                ->count();
                $cd = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('gender', 'ኣን')
                ->count();
                $row_abalat_mahberawi_bota[16] = ($fm + $cd);

                //ድምር
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
                $cd = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[17] = ($fm + $cd);
            }
            //deant
            {
                // manufacturing
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('wudabeType', 'መፍረይቲ')
                ->count();
                $cd = 0;
                $row_abalat_deant[1] = ($fm + $cd);

                // ketema hrisha
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('wudabeType', 'ከተማ ሕርሻ')
                ->count();
                $cd = 0;
                $row_abalat_deant[2] = ($fm + $cd);

                // construction
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('wudabeType', 'ኮንስትራክሽን')
                ->count();
                $cd = 0;
                $row_abalat_deant[3] = ($fm + $cd);

                // trade
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('wudabeType', 'ንግዲ')
                ->count();
                $cd = 0;
                $row_abalat_deant[4] = ($fm + $cd);

                // service
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('wudabeType', 'ግልጋሎት')
                ->count();
                $cd = 0;
                $row_abalat_deant[5] = ($fm + $cd);

                // 67 - 83
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1967,1,1), Carbon::createFromDate(1983,1,1)])
                ->count();
                $cd = 0;
                $row_abalat_deant[6] = ($fm + $cd);

                // 84 - 93
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1983,1,1), Carbon::createFromDate(1993,1,1)])
                ->count();
                $cd = 0;
                $row_abalat_deant[7] = ($fm + $cd);

                // 94 - 2000
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1993,1,1), Carbon::createFromDate(2000,1,1)])
                ->count();
                $cd = 0;
                $row_abalat_deant[8] = ($fm + $cd);

                // after 2001
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(2000,1,1), Carbon::createFromDate(9000,1,1)])
                ->count();
                $cd = 0;
                $row_abalat_deant[9] = ($fm + $cd);

                // ደቂ ኣንስትዮ
                $fm = DB::table('approved_hitsuys')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('assignedAssoc', 'ደቂ ኣንስትዮ')
                ->count();
                $cd = 0;
                $row_abalat_deant[10] = ($fm + $cd);

                // ደኣንት
                $fm = DB::table('approved_hitsuys')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('assignedAssoc', 'ደኣንት')
                ->count();
                $cd = 0;
                $row_abalat_deant[11] = ($fm + $cd);

                // መናእሰይ
                $fm = DB::table('approved_hitsuys')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('assignedAssoc', 'መናእሰይ')
                ->count();
                $cd = 0;
                $row_abalat_deant[12] = ($fm + $cd);

                // መንግስቲ ሰራሕተኛ
                $fm = DB::table('approved_hitsuys')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('occupation', 'ሲቪል ሰርቫንት')
                ->count();
                $cd = 0;
                $row_abalat_deant[13] = ($fm + $cd);

                // ዘይመንግስታዊ
                $fm = DB::table('approved_hitsuys')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('occupation', '')
                ->count();
                $cd = 0;
                $row_abalat_deant[14] = ($fm + $cd);

                // ውልቀ
                $fm = DB::table('approved_hitsuys')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('occupation', '')
                ->count();
                $cd = 0;
                $row_abalat_deant[15] = ($fm + $cd);

                // girls
                $fm = DB::table('approved_hitsuys')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('gender', 'ኣን')
                ->count();
                $cd = 0;
                $row_abalat_deant[16] = ($fm + $cd);

                // ድምር
                $fm = DB::table('approved_hitsuys')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
                $cd = 0;
                $row_abalat_deant[17] = ($fm + $cd);

            }
            //wahio count
            {
                // ተምሃሮ
                $row_wahio_count[1] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->where('meseretawi_wdabes.type', 'ተምሃሮ')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();

                // መምህራን
                $row_wahio_count[2] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->where('meseretawi_wdabes.type', 'መምህራን')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();

                // ሲ/ሰርቫንት
                $row_wahio_count[3] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->whereIn('meseretawi_wdabes.type', ['ሲ/ሰርቫንት', 'ሰብ ሞያ'])
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();

                // ሸቃሎ
                $row_wahio_count[4] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();

                // ድምር
                $row_wahio_count[5] = $row_wahio_count[1] + $row_wahio_count[2] + $row_wahio_count[3] + $row_wahio_count[4];

                // ጠቕላላ ድምር
                $row_wahio_count[6] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
            }

            //tabia count
            {
                $row_tabia_count[1] = DB::table('tabias')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();

                $row_tabia_count[2] = DB::table('tabias')
                ->join('approved_hitsuys', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->groupBy('tabias.tabiaCode')
                ->havingRaw('COUNT(approved_hitsuys.hitsuyID)>500')
                ->pluck(DB::raw("COUNT(approved_hitsuys.hitsuyID)"))
                ->count();

                $row_tabia_count[3] = $row_tabia_count[1] - $row_tabia_count[2];

                $row_tabia_count[4] = $row_tabia_count[1];

                // መፍረይቲ
                $row_tabia_count[5] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'መፍረይቲ')
                ->count();
                // ከተማ ሕርሻ
                $row_tabia_count[6] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ከተማ ሕርሻ')
                ->count();
                // ኮንስትራክሽን
                $row_tabia_count[7] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ኮንስትራክሽን')
                ->count();
                // ንግዲ
                $row_tabia_count[8] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ንግዲ')
                ->count();
                // ግልጋሎት
                $row_tabia_count[9] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ግልጋሎት')
                ->count();
                $row_tabia_count[10] = $row_tabia_count[5] + $row_tabia_count[6] + $row_tabia_count[7] + $row_tabia_count[8] + $row_tabia_count[9];
                // ሸቃሎ
                $row_tabia_count[11] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->count();
                // ተምሃሮ
                $row_tabia_count[12] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ተምሃሮ')
                ->count();
                // መምህራን
                $row_tabia_count[13] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'መምህራን')
                ->count();
                // ሲ/ሰርቫንት
                $row_tabia_count[14] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereIn('meseretawi_wdabes.type', ['ሲ/ሰርቫንት', 'ሰብ ሞያ'])
                ->count();

                //ጠ/ድምር
                $row_tabia_count[16] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
            }

            // TODO for all plan tables set quarter and year 
            //plan deant
            {
                //መፍረይቲ
                $row_plan_deant[2] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'መፍረይቲ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', explode("/", $today)[2])
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ከተማ ሕርሻ
                $row_plan_deant[4] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ከተማ ሕርሻ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', explode("/", $today)[2])
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ኮንስትራክሽን
                $row_plan_deant[6] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ኮንስትራክሽን')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', explode("/", $today)[2])
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ንግዲ
                $row_plan_deant[8] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ንግዲ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', explode("/", $today)[2])
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ግልጋሎት
                $row_plan_deant[10] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ግልጋሎት')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', explode("/", $today)[2])
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();
            }

            //plan non deant
            {
                //ሸቃሎ
                $row_plan_non_deant[2] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', explode("/", $today)[2])
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ተምሃሮ
                $row_plan_non_deant[4] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ተምሃሮ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', explode("/", $today)[2])
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //መምህራን
                $row_plan_non_deant[6] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'መምህራን')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', explode("/", $today)[2])
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ሲ/ሰርቫንት
                $row_plan_non_deant[8] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->whereIn('meseretawi_wdabes.type', ['ሲ/ሰርቫንት', 'ሰብ ሞያ'])
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', explode("/", $today)[2])
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

            }

            //plan all
            {
                //ውልቀሰብ
                $row_plan_all[2] = DB::table('approved_hitsuys')
                ->join('individualplans', 'approved_hitsuys.hitsuyID', '=', 'individualplans.hitsuyID')
                // ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('individualplans.year', explode("/", $today)[2])
                ->count();

                //መሰረታዊ ውዳበ
                $row_plan_all[5] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                // ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', explode("/", $today)[2])
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ዋህዮ
                $row_plan_all[8] = DB::table('wahioplans')
                ->join('wahios', 'wahios.id', '=', 'wahioplans.wahioid')
                // ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'wahios.parentcode', 'LIKE', DB::raw("CONCAT('_____', tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('wahioplans.planyear', explode("/", $today)[2])
                ->where('wahioplans.quarter', $this_quarter)
                ->count();
            }

            //model members
            {
                $row_model_members[1] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [80, 100])
                ->where('super_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('super_leaders.year', ($this_quarter == 'ዓመት' ? explode("/", $today)[2] : explode("/", $today)[2] - 1))
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [80, 100])
                ->where('middle_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('middle_leaders.year', ($this_quarter == 'ዓመት' ? explode("/", $today)[2] : explode("/", $today)[2] - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ሞዴል')
                ->where('lower_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('lower_leaders.year', ($this_quarter == 'ዓመት' ? explode("/", $today)[2] : explode("/", $today)[2] - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [80, 100])
                ->where('first_instant_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('first_instant_leaders.year', ($this_quarter == 'ዓመት' ? explode("/", $today)[2] : explode("/", $today)[2] - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ሞዴል')
                ->where('tara_members.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('tara_members.year', ($this_quarter == 'ዓመት' ? explode("/", $today)[2] : explode("/", $today)[2] - 1))
                ->count();

                $row_model_members[2] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [80, 100])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', explode("/", $today)[2])
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [80, 100])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [80, 100])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', explode("/", $today)[2])
                ->count();

                $row_model_members[3] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [0, 80])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', explode("/", $today)[2])
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [0, 80])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ዘይሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [0, 80])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ዘይሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', explode("/", $today)[2])
                ->count();

                $row_model_members[5] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [80, 100])
                ->where('super_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('super_leaders.year', ($this_quarter == 'ዓመት' ? explode("/", $today)[2] : explode("/", $today)[2] - 1))
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [80, 100])
                ->where('middle_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('middle_leaders.year', ($this_quarter == 'ዓመት' ? explode("/", $today)[2] : explode("/", $today)[2] - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ሞዴል')
                ->where('lower_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('lower_leaders.year', ($this_quarter == 'ዓመት' ? explode("/", $today)[2] : explode("/", $today)[2] - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [80, 100])
                ->where('first_instant_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('first_instant_leaders.year', ($this_quarter == 'ዓመት' ? explode("/", $today)[2] : explode("/", $today)[2] - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ሞዴል')
                ->where('tara_members.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('tara_members.year', ($this_quarter == 'ዓመት' ? explode("/", $today)[2] : explode("/", $today)[2] - 1))
                ->count();

                $row_model_members[6] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [80, 100])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', explode("/", $today)[2])
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [80, 100])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [80, 100])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', explode("/", $today)[2])
                ->count();

                $row_model_members[7] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [0, 80])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', explode("/", $today)[2])
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [0, 80])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ዘይሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [0, 80])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', explode("/", $today)[2])
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ዘይሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', explode("/", $today)[2])
                ->count();

                // $row_model_members[10] = 
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                // ->whereBetween('super_leaders.sum', [80, 100])
                // ->where('super_leaders.half', $this_quarter)
                // ->where('super_leaders.year', explode("/", $today)[2])
                // ->count()
                //  +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                // ->whereBetween('middle_leaders.sum', [80, 100])
                // ->where('middle_leaders.half', $this_quarter)
                // ->where('middle_leaders.year', explode("/", $today)[2])
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                // ->where('lower_leaders.model', 'ሞዴል')
                // ->where('lower_leaders.half', $this_quarter)
                // ->where('lower_leaders.year', explode("/", $today)[2])
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                // ->whereBetween('first_instant_leaders.sum', [80, 100])
                // ->where('first_instant_leaders.half', $this_quarter)
                // ->where('first_instant_leaders.year', explode("/", $today)[2])
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                // ->where('tara_members.model', 'ሞዴል')
                // ->where('tara_members.half', $this_quarter)
                // ->where('tara_members.year', explode("/", $today)[2])
                // ->count();

                // $row_model_members[11] = 
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                // ->whereBetween('super_leaders.sum', [0, 80])
                // ->where('super_leaders.half', $this_quarter)
                // ->where('super_leaders.year', explode("/", $today)[2])
                // ->count()
                //  +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                // ->whereBetween('middle_leaders.sum', [0, 80])
                // ->where('middle_leaders.half', $this_quarter)
                // ->where('middle_leaders.year', explode("/", $today)[2])
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                // ->where('lower_leaders.model', 'ዘይሞዴል')
                // ->where('lower_leaders.half', $this_quarter)
                // ->where('lower_leaders.year', explode("/", $today)[2])
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                // ->whereBetween('first_instant_leaders.sum', [0, 80])
                // ->where('first_instant_leaders.half', $this_quarter)
                // ->where('first_instant_leaders.year', explode("/", $today)[2])
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                // ->where('tara_members.model', 'ዘይሞዴል')
                // ->where('tara_members.half', $this_quarter)
                // ->where('tara_members.year', explode("/", $today)[2])
                // ->count();
            }

            //new candidates non deant
            {
                // ሲቪል ሰርቫንት
                $row_new_members_non_deant[2] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ሲቪል ሰርቫንት')
                ->count();

                // ሸቃላይ
                $row_new_members_non_deant[4] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ሸቃላይ')
                ->count();

                // ተምሃራይ
                $row_new_members_non_deant[6] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ተምሃራይ')
                ->count();

                // መምህር
                $row_new_members_non_deant[8] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'መምህር')
                ->count();
            }

            //new candidates deant
            {
                // መፍረይቲ
                $row_new_members_deant[2] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'መፍረይቲ')
                ->count();

                // ከተማ ሕርሻ
                $row_new_members_deant[4] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ከተማ ሕርሻ')
                ->count();

                // ኮንስትራክሽን
                $row_new_members_deant[6] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ኮንስትራክሽን')
                ->count();

                // ንግዲ
                $row_new_members_deant[8] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ንግዲ')
                ->count();

                // ግልጋሎት
                $row_new_members_deant[10] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ግልጋሎት')
                ->count();
            }

            //new approved members
            {
                // ክሰግሩ ዝግበኦም
                $row_approved_new_members[1] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ተባ')
                ->count();
                $row_approved_new_members[2] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ኣን')
                ->count();
                $row_approved_new_members[3] = $row_approved_new_members[1] + $row_approved_new_members[2];

                // ፍፃመ
                $row_approved_new_members[4] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ተባ')
                ->where('hitsuy_status', 'ኣባል')
                ->count();
                $row_approved_new_members[5] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ኣን')
                ->where('hitsuy_status', 'ኣባል')
                ->count();
                $row_approved_new_members[6] = $row_approved_new_members[4] + $row_approved_new_members[5];

                // ዘይሰገሩ TODO check ዝተኣገደ part 
                $row_approved_new_members[8] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ተባ')
                ->whereIn('hitsuy_status', ['ሕፁይ', 'ዝተኣገደ'])
                ->count();
                $row_approved_new_members[9] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ኣን')
                ->whereIn('hitsuy_status', ['ሕፁይ', 'ዝተኣገደ'])
                ->count();
                $row_approved_new_members[10] = $row_approved_new_members[8] + $row_approved_new_members[9];

                // ግዚኦም ዘይኣኸለ
                $row_approved_new_members[11] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,3,30)->subMonths(6), Carbon::createFromDate(9000,1,1)->subMonths(6)])
                ->whereIn('hitsuy_status', ['ሕፁይ', 'ዝተኣገደ'])
                ->count();

            }

            //grades
            {
                // deant
                {
                    // total
                    $row_grades[1] += DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                    ->count();
                    // deant A
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('super_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('middle_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->where('lower_leaders.evaluation', 'A')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('first_instant_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('experts.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->where('tara_members.evaluation', 'A')
                        ->count();

                        $row_grades[2] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // deant B
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('super_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('middle_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->where('lower_leaders.evaluation', 'B')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('first_instant_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('experts.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->where('tara_members.evaluation', 'B')
                        ->count();

                        $row_grades[3] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // deant C
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('super_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('middle_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->where('lower_leaders.evaluation', 'C')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('first_instant_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->whereBetween('experts.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                        ->where('tara_members.evaluation', 'C')
                        ->count();

                        $row_grades[4] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                }
                // ሸቃሎ
                {
                    // total
                    $row_grades[6] += DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'ሸቃላይ')
                    ->count();
                    // ሸቃሎ A
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('super_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('middle_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->where('lower_leaders.evaluation', 'A')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('first_instant_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('experts.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->where('tara_members.evaluation', 'A')
                        ->count();

                        $row_grades[7] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // ሸቃሎ B
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('super_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('middle_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->where('lower_leaders.evaluation', 'B')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('first_instant_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('experts.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->where('tara_members.evaluation', 'B')
                        ->count();

                        $row_grades[8] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // ሸቃሎ C
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('super_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('middle_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->where('lower_leaders.evaluation', 'C')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('first_instant_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->whereBetween('experts.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሸቃላይ')
                        ->where('tara_members.evaluation', 'C')
                        ->count();

                        $row_grades[9] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                }
                // ሰብ ሞያ
                {
                    // total
                    $row_grades[11] += DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                    ->count();
                    // ሰብ ሞያ A
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('super_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('middle_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->where('lower_leaders.evaluation', 'A')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('first_instant_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('experts.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->where('tara_members.evaluation', 'A')
                        ->count();

                        $row_grades[12] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // ሰብ ሞያ B
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('super_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('middle_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->where('lower_leaders.evaluation', 'B')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('first_instant_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('experts.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->where('tara_members.evaluation', 'B')
                        ->count();

                        $row_grades[13] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // ሰብ ሞያ C
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('super_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('middle_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->where('lower_leaders.evaluation', 'C')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('first_instant_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->whereBetween('experts.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                        ->where('tara_members.evaluation', 'C')
                        ->count();

                        $row_grades[14] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                }
                // መምህራን
                {
                    // total
                    $row_grades[16] += DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'መምህር')
                    ->count();
                    // መምህራን A
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('super_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('middle_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->where('lower_leaders.evaluation', 'A')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('first_instant_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('experts.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->where('tara_members.evaluation', 'A')
                        ->count();

                        $row_grades[17] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // መምህራን B
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('super_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('middle_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->where('lower_leaders.evaluation', 'B')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('first_instant_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('experts.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->where('tara_members.evaluation', 'B')
                        ->count();

                        $row_grades[18] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // መምህራን C
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('super_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('middle_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->where('lower_leaders.evaluation', 'C')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('first_instant_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->whereBetween('experts.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'መምህር')
                        ->where('tara_members.evaluation', 'C')
                        ->count();

                        $row_grades[19] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                }
                // ተምሃሮ
                {
                    // total
                    $row_grades[21] += DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('tabias.isUrban', '=', 'ከተማ')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'ተምሃራይ')
                    ->count();
                    // ተምሃሮ A
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('super_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('middle_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->where('lower_leaders.evaluation', 'A')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('first_instant_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('experts.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->where('tara_members.evaluation', 'A')
                        ->count();

                        $row_grades[22] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // ተምሃሮ B
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('super_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('middle_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->where('lower_leaders.evaluation', 'B')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('first_instant_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('experts.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->where('tara_members.evaluation', 'B')
                        ->count();

                        $row_grades[23] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // ተምሃሮ C
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('super_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('middle_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->where('lower_leaders.evaluation', 'C')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('first_instant_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->whereBetween('experts.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ተምሃራይ')
                        ->where('tara_members.evaluation', 'C')
                        ->count();

                        $row_grades[24] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                }
                $row_grades[5] =  $row_grades[1] - ($row_grades[2] + $row_grades[3] + $row_grades[4]);
                $row_grades[10] =  $row_grades[6] - ($row_grades[7] + $row_grades[8] + $row_grades[9]);
                $row_grades[15] =  $row_grades[11] - ($row_grades[12] + $row_grades[13] + $row_grades[14]);
                $row_grades[20] =  $row_grades[16] - ($row_grades[17] + $row_grades[18] + $row_grades[19]);
                $row_grades[25] =  $row_grades[21] - ($row_grades[22] + $row_grades[23] + $row_grades[24]);
            }

            //punishments
            {
                $row_punishment[1] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'መጠንቀቕታ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[2] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ናይ ሕፀ እዋን ምንዋሕ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[3] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሕፁይነት ምብራር')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[4] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሙሉእ ናብ ሕፁይ ኣባልነት ምውራድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[5] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሓላፍነት ንውሱን ጊዜ ምእጋድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[6] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሓላፍነት ምውራድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[7] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[8] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ኣባልነት ምብራር')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();  

                //TODO chargeTypes not set!!
                $row_punishment[10] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();   

                $row_punishment[11] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[12] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [''])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();   

                $row_punishment[13] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [''])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();   

                $row_punishment[14] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [''])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[15] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.gender', 'ኣን')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[16] += DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.gender', 'ተባ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[17] += DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();
                $row_punishment[9] =  $row_punishment[1] + $row_punishment[2] + $row_punishment[3] + $row_punishment[4] + $row_punishment[5] + $row_punishment[6] + $row_punishment[7] + $row_punishment[8];

            }

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
        $zoneCode = Auth::user()->area;
        $zobadatas = null;
        $zoneName = null;
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone && $request->zone !== '0'){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
            }
            else
                $zoneCode = $request->zone;
        }
        if(Auth::user()->usertype == 'woredaadmin' || Auth::user()->usertype == 'woreda'){
            $zoneCode = Woreda::where('woredacode', Auth::user()->area)->pluck('zoneCode')->first();
        }
        if($zoneCode === '0')
            $zoneName = 'ኩሎም';
        else
            $zoneName = DB::table('zobatats')->where('zoneCode', $zoneCode)->pluck('zoneName')->first();
        $today = DateConvert::toEthiopian(date('d/m/Y'));
        $quarter = [];
        $quarter_names = ['3 ወርሒ', '6 ወርሒ', '9 ወርሒ', 'ዓመት'];
        $year = null;
        $this_quarter = null;
        $st = null;
        if($request->year && $request->quarter && (array_search($request->quarter, $quarter_names) !== false)){
            $year = $request->year;
            $this_quarter = $request->quarter;
            $st = array_search($this_quarter, $quarter_names) * 3 + 1;
        }
        else{
            $year = explode("/", $today)[2];
            $st = (int)(((int)explode("/", $today)[1] - 1) / 3) * 3 + 1;
            $this_quarter = $quarter_names[(($st-1)/3)];
        }
        $quarter_english = ['first', 'second', 'third', 'fourth'][array_search($this_quarter, $quarter_names)];
        if(!file_exists(base_path('reports/' . $year . '_' . $quarter_english . '_all_report.json'))){
            Toastr::error('ናይ ' . $year . ' ዓመተ ምህረት ናይ ' . $this_quarter . ' ሪፖርት ኣይተረኸበን');
            return back();
        }
        $data = null;
        $arr = json_decode(file_get_contents(base_path('reports/' . $year . '_' . $quarter_english . '_all_report.json')), true);
        // var_dump($arr['ketema'][$zoneName]);
        if($zoneName == 'ኩሎም'){
            $new_arr = ['zoneName' => 'ኩሎም', 'weseking_gudletin' => [], 'abalat_age_education' => [], 'abalat_mahberawi_bota' => [], 'abalat_deant' => [], 'wahio_count' => [], 'tabia_count' => [], 'plan_deant' => [], 'plan_non_deant' => [], 'plan_all' => [], 'model_members' => [], 'new_members_non_deant' => [], 'new_members_deant' => [], 'approved_new_members' => [], 'grades' => [], 'punishment' => [], 'zobadatas' => [], 'zoneCode' => '0', 'year' => '', 'this_quarter' => '', 'quarter_names' => []];
            foreach ($arr['ketema'] as $key) {
                $new_arr['weseking_gudletin'] = array_merge($new_arr['weseking_gudletin'], $key['weseking_gudletin']);
                $new_arr['abalat_age_education'] = array_merge($new_arr['abalat_age_education'], $key['abalat_age_education']);
                $new_arr['abalat_mahberawi_bota'] = array_merge($new_arr['abalat_mahberawi_bota'], $key['abalat_mahberawi_bota']);
                $new_arr['abalat_deant'] = array_merge($new_arr['abalat_deant'], $key['abalat_deant']);
                $new_arr['wahio_count'] = array_merge($new_arr['wahio_count'], $key['wahio_count']);
                $new_arr['tabia_count'] = array_merge($new_arr['tabia_count'], $key['tabia_count']);
                $new_arr['plan_deant'] = array_merge($new_arr['plan_deant'], $key['plan_deant']);
                $new_arr['plan_non_deant'] = array_merge($new_arr['plan_non_deant'], $key['plan_non_deant']);
                $new_arr['plan_all'] = array_merge($new_arr['plan_all'], $key['plan_all']);
                $new_arr['model_members'] = array_merge($new_arr['model_members'], $key['model_members']);
                $new_arr['new_members_non_deant'] = array_merge($new_arr['new_members_non_deant'], $key['new_members_non_deant']);
                $new_arr['new_members_deant'] = array_merge($new_arr['new_members_deant'], $key['new_members_deant']);
                $new_arr['approved_new_members'] = array_merge($new_arr['approved_new_members'], $key['approved_new_members']);
                $new_arr['grades'] = array_merge($new_arr['grades'], $key['grades']);
                $new_arr['punishment'] = array_merge($new_arr['punishment'], $key['punishment']);
                $new_arr['zobadatas'] = $key['zobadatas'];
                $new_arr['year'] = $key['year'];
                $new_arr['this_quarter'] = $key['this_quarter'];
                $new_arr['quarter_names'] = $key['quarter_names'];   
            }
            $data = $new_arr;
        }
        else{
            $data = $arr['ketema'][$zoneName];
        }
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $zoneName . '_' . explode("/", $today)[2] . '_' . $this_quarter . '_ናይ_ከተማ_ሪፖርት.xlsx"');
        header('Cache-Control: max-age=0');
        // $data = $this->loadData($zoneCode);
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ወሰኽን ጉድለትን ኣሃዛዊ መረዳእታ '.$data['zoneName'])
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

        foreach ($data['weseking_gudletin'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ናይ 3ተ ወርሒ ከተማ ኣባል '. $data['zoneName'])
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
        foreach ($data['abalat_age_education'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }


        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ናይ 3ተ ወርሒ ከተማ ኣባል '. $data['zoneName'])
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
        foreach ($data['abalat_mahberawi_bota'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }



        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ኣብ ደኣንት ዘሎ ኣባል '. $data['zoneName'])
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
        foreach ($data['abalat_deant'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'በዝሒ ዋህዮታት ከተማ ካብ ደኣንት ወፃኢ '. $data['zoneName'])
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+1), 'ተምሃሮ')
            ->setCellValue('C'.($i+1), 'መምህራን')
            ->setCellValue('D'.($i+1), 'ካልኦት ሰብ ሞያ')
            ->setCellValue('E'.($i+1), 'ሸቃሎ')
            ->setCellValue('F'.($i+1), 'ድምር')
            ->setCellValue('G'.($i+1), 'ጠቕላላ ድምር ዋህዮ ኣብ ከተማ')
            ->mergeCells('A'.$i.':G'.$i);


        $i += 2;
        foreach ($data['wahio_count'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }


        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data['zoneName'].': በዝሒ ወረዳ፣ ቀበሌታትን ውዳበ ከተማ ')
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
        foreach ($data['tabia_count'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data['zoneName'].': ደኣንት ትልሚ')
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
        foreach ($data['plan_deant'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }


        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data['zoneName'].': ካብ ደኣንት ወፃኢ ትልሚ')
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
        foreach ($data['plan_non_deant'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, 'ዞባ '.$data['zoneName'].': በቢደረጅኡ ትልሚ ምድላው ዝምልከት')
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
        foreach ($data['plan_all'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }


        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, 'ዞባ '.$data['zoneName'].': ሞዴል ኣመራርሓ መ/ውዳበን ዋህዮታትን')
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
        foreach ($data['model_members'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue('A'.$i, 'ዞባ '.$data['zoneName'].': ኣፈፃፅማ ምልመላ ሓደሽቲ ኣባላት ውድብ ካብ ደኣንት ወፃኢ')
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
        foreach ($data['new_members_non_deant'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, 'ዞባ '.$data['zoneName'].': ኣፈፃፅማ ምልመላ ሓደሽቲ ኣባላት ውድብ ደኣንት')
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
        foreach ($data['new_members_deant'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data['zoneName'].': ካብ ብርኪ ሕፁይነት ናብ ሙሉእ ዝሰገሩ ፀብፃብ')
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
        foreach ($data['approved_new_members'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }


        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data['zoneName'].': ስርርዕ ኣባልን ኣመራርሓን ከተማ')
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
        foreach ($data['grades'] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ዞባ '.$data['zoneName'].': ቅፅዓት ዝምልከት')
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
        foreach ($data['punishment'] as $a) {
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
