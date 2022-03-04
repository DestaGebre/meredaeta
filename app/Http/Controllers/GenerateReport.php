<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;

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
use App\GeneratedReport;
use DB;

use Carbon\Carbon;

class GenerateReport extends Controller
{
    public function index(Request $request)
    {
        $quarter_names = ['3 ወርሒ', '6 ወርሒ', '9 ወርሒ', 'ዓመት'];
        $year = null;
        $this_quarter = null;
        $st = null;
        $latest = GeneratedReport::orderBy('year', 'desc')->orderBy('quarter', 'desc')->select(['year', 'quarter'])->first();
        if($latest){
            $year = $latest->year;
            $qu = $latest->quarter;
        }
        else{
            $year = '2012';
            $qu = 3;
        }
        if($qu == 3){
            $year += 1;
            $qu = 0;
        }
        else{
            $qu += 1;
        }
        $this_quarter = $quarter_names[$qu];
        $st = $qu * 3 + 1;
        $quarter[] = DateConvert::toGregorian('1/11/' . ($year-1));
        $quarter[] = DateConvert::toGregorian('1/' . ($st+1) . '/' . $year);
        return view('report.generate', compact('year', 'this_quarter'));
    }
    public function generate(Request $request){
        $quarter_names = ['3 ወርሒ', '6 ወርሒ', '9 ወርሒ', 'ዓመት'];
        if(!$request->year || !$request->quarter || array_search($request->quarter, $quarter_names) === false){
            Toastr::error("ሕቶኦም ኣይተኣናገደን");
            return back();
        }
        else{
            $year = $request->year;
            $quarter = $request->quarter;
            $exists = GeneratedReport::where('year', $year)->where('quarter', array_search($quarter, $quarter_names))->first();
            if($exists){
                Toastr::error('ናይ ' . $year . ' ዓመተ ምህረት ናይ ' . $quarter . ' ሪፖርት ንኻልኣይ ግዘ ክስራሕ ኣይኽእልን');
                return back();
            }
            $latest = GeneratedReport::orderBy('year', 'desc')->orderBy('quarter', 'desc')->select(['year', 'quarter'])->first();
            if($latest){
                $expected_year = $latest->year;
                $expected_quarter = $latest->quarter;
                if($expected_quarter == 3){
                    $expected_year += 1;
                    $expected_quarter = 0;
                }
                $this_quarter = $quarter_names[$expected_quarter];
                if($year != $expected_year || array_search($quarter, $quarter_names) != $expected_quarter){
                    Toastr::error('ናይ ' . $expected_year . ' ዓመተ ምህረት ናይ ' . $quarter_names[$expected_quarter] . ' ሪፖርት ንቐደም ክስራሕ ኣለዎ');
                    return back();       
                }
            }
            $quarter_english = ['first', 'second', 'third', 'fourth'][array_search($quarter, $quarter_names)];
            $all_data = ['ketama' => [], 'geter' => []];
            $zones = Zobatat::select(['zoneCode', 'zoneName'])->get();
            foreach($zones as $zone){
                $all_data['ketema'][$zone->zoneName] = $this->loadDataKetema($zone->zoneCode, $year, $quarter);
                $all_data['geter'][$zone->zoneName] = $this->loadDataGeter($zone->zoneCode, $year, $quarter);
            }
            file_put_contents(base_path('reports/' . $year . '_' . $quarter_english . '_all_report.json'), json_encode($all_data));
            // Read
            // $arr1 = json_decode(file_get_contents(base_path('reports/' . '2012_first_all_report.json')), true);
            // var_dump($arr1['ketema']['ምብራቕ']);
            // var_dump($arr1['geter']['ምብራቕ']);
            $report = new GeneratedReport;
            $report->year = $year;
            $report->quarter = array_search($quarter, $quarter_names);
            $report->save();
            Toastr::success("ሪፖርትታት ተዳልዮም ኣለዉ!");
            return back();
        }
    }
    private function loadDataKetema($zoneCode, $year, $this_quarter){
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $today = DateConvert::toEthiopian(date('d/m/Y'));
        $quarter_names = ['3 ወርሒ', '6 ወርሒ', '9 ወርሒ', 'ዓመት'];
        $st = array_search($this_quarter, $quarter_names) * 3 + 1;
        $quarter = [];
        $quarter[] = DateConvert::toGregorian('1/11/' . ($year-1));
        $quarter[] = DateConvert::toGregorian('1/' . ($st+1) . '/' . $year);
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
            if($woreda['isUrban'] != 'ከተማ'){
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
                continue;
            }
            // Wesekin gudletin table
            {
                $row_weseking_gudletin[2] = DB::table('hitsuys')
                    ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT('tabias.parentcode', tabias.tabiaCode, '%')"))
                    // ->where('tabias.isUrban', '=', 'ከተማ')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('hitsuy_status', 'ሕፁይ')
                    ->whereBetween('hitsuys.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                $row_weseking_gudletin[3] = DB::table('transfers')
                    ->where('transfers.zone', $zoneCode)
                    ->where('transfers.woreda', $woreda['woredaCode'])
                    ->join('tabias', 'transfers.tabia', '=', 'tabias.tabiaCode')
                    // ->where('tabias.isUrban', '=', 'ከተማ')
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
                    // ->where('tabias.isUrban', '=', 'ከተማ')
                    ->whereBetween('dismisses.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();


                $row_weseking_gudletin[7] = DB::table('dismisses')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    // ->where('approved_hitsuys.zoneworedaCode', '=', '010080034')
                    ->where('dismissReason', 'ብቕፅዓት')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ከተማ')
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
                    // ->where('tabias.isUrban', '=', 'ከተማ')
                    ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                //TODO University
                $row_weseking_gudletin[9] = Transfer::where('oldzone', $zoneCode)
                    ->where('oldworeda', $woreda['woredaCode'])
                    ->where('zone', '10')
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
                ->whereIn('zone', ['11'])
                ->whereBetween('created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_weseking_gudletin[13] = DB::table('dismisses')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
                    ->whereIn('dismissReason', ['ናይ ውልቀ ሰብ ሕቶ', 'ብኽብሪ' , 'ካሊእ'])
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ከተማ')
                    ->whereBetween('dismisses.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                $row_weseking_gudletin[14] = $row_weseking_gudletin[6] + $row_weseking_gudletin[7] + $row_weseking_gudletin[8] + $row_weseking_gudletin[9] + $row_weseking_gudletin[10] + $row_weseking_gudletin[11] + $row_weseking_gudletin[12] + $row_weseking_gudletin[13];
                $row_weseking_gudletin[15] = $row_weseking_gudletin[5] - $row_weseking_gudletin[14];

                $row_weseking_gudletin[16] = DB::table('approved_hitsuys')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->where('hitsuys.hitsuy_status', 'ኣባል')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ከተማ')
                    ->count()
                + DB::table('hitsuys')
                    ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '/%')"))
                    ->where('hitsuy_status', 'ሕፁይ')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[4] = ($fm + $cd);

                // 36 - 60
                $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('hitsuys.dob', [Carbon::today()->subYears(60), Carbon::today()->subYears(35)])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(60), Carbon::today()->subYears(35)])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[5] = ($fm + $cd);

                // above 60
                $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('hitsuys.dob', [Carbon::today()->subYears(150), Carbon::today()->subYears(60)])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(150), Carbon::today()->subYears(60)])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[6] = ($fm + $cd);

                // illiterate [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዘይተምሃረ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዘይተምሃረ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[7] = ($fm + $cd);

                // 1-8 [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('hitsuys.educationlevel', [1, 8])
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.educationlevel', [1, 8])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[8] = ($fm + $cd);

                // 9-12 [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('hitsuys.educationlevel', [9, 12])
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.educationlevel', [9, 12])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[9] = ($fm + $cd);

                // certificate [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ሰርቲፊኬት')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ሰርቲፊኬት')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[10] = ($fm + $cd);

                // diploma [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዲፕሎማ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዲፕሎማ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[11] = ($fm + $cd);


                // degree [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዲግሪ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዲግሪ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[12] = ($fm + $cd);

                // master's [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ማስተርስ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ማስተርስ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[13] = ($fm + $cd);

                // PhD [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዶክተር')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዶክተር')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                ->count();
                $cd = Hitsuy::whereIn('hitsuys.occupation', ['ኮንስትራክሽን','ከተማ ሕርሻ', 'መፍረይቲ', 'ንግዲ', 'ግልጋሎት'])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')->count();
                $row_abalat_mahberawi_bota[1] = ($fm + $cd);

                // shekalo
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ሸቃላይ')
                ->count();
                $cd = Hitsuy::where('hitsuys.occupation', 'ሸቃላይ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')->count();
                $row_abalat_mahberawi_bota[2] = ($fm + $cd);

                // ካልኦት ሰብ ሞያ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->count();
                $cd = DB::table('hitsuys')->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[3] = ($fm + $cd);

                // መምህር
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'መምህር')
                ->count();
                $cd = Hitsuy::where('hitsuys.occupation', 'መምህር')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')->count();
                $row_abalat_mahberawi_bota[4] = ($fm + $cd);

                // ተምሃራይ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ተምሃራይ')
                ->count();
                $cd = Hitsuy::where('hitsuys.occupation', 'ተምሃራይ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[5] = ($fm + $cd);

                // 67 - 83
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1974,9,11), Carbon::createFromDate(1990,9,11)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[6] = ($fm + $cd);

                // 84 - 93
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1990,9,11), Carbon::createFromDate(2000,9,11)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[7] = ($fm + $cd);

                // 94 - 2000
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(2000,9,11), Carbon::createFromDate(2007,9,12)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[8] = ($fm + $cd);

                // after 2001
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(2007,9,12), Carbon::createFromDate(9000,1,1)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[9] = ($fm + $cd);

                // ደቂ ኣንስትዮ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.assignedAssoc','ደቂ ኣንስትዮ')
                ->count();
                $row_abalat_mahberawi_bota[10] = ($fm + $cd);

                // መናእሰይ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.assignedAssoc','መናእሰይ')
                ->count();
                $row_abalat_mahberawi_bota[11] = ($fm + $cd);

                // መምህራን
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.assignedAssoc','መምህራን')
                ->count();
                $row_abalat_mahberawi_bota[12] = ($fm + $cd);

                // መንግስቲ ሰራሕተኛ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->count();
                $cd = DB::table('hitsuys')->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[13] = ($fm + $cd);

                // ዘይመንግስታዊ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ዘይመንግስታዊ')
                ->count();
                $cd = DB::table('hitsuys')->where('hitsuys.occupation', 'ዘይመንግስታዊ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[14] = ($fm + $cd);

                // ውልቀ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ውልቀ')
                ->count();
                $cd = DB::table('hitsuys')
                ->where('hitsuys.occupation', 'ውልቀ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[15] = ($fm + $cd);

                // ደቂ ኣንስትዮ
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('gender', 'ኣን')
                ->count();
                $cd = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('gender', 'ኣን')
                ->count();
                $row_abalat_mahberawi_bota[16] = ($fm + $cd);

                //ድምር
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
                $cd = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('wudabeType', 'መፍረይቲ')
                ->count();
                $cd = 0;
                $row_abalat_deant[1] = ($fm + $cd);

                // ketema hrisha
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('wudabeType', 'ከተማ ሕርሻ')
                ->count();
                $cd = 0;
                $row_abalat_deant[2] = ($fm + $cd);

                // construction
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('wudabeType', 'ኮንስትራክሽን')
                ->count();
                $cd = 0;
                $row_abalat_deant[3] = ($fm + $cd);

                // trade
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('wudabeType', 'ንግዲ')
                ->count();
                $cd = 0;
                $row_abalat_deant[4] = ($fm + $cd);

                // service
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1974,9,11), Carbon::createFromDate(1990,9,11)])
                ->count();
                $cd = 0;
                $row_abalat_deant[6] = ($fm + $cd);

                // 84 - 93
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1990,9,11), Carbon::createFromDate(2000,9,11)])
                ->count();
                $cd = 0;
                $row_abalat_deant[7] = ($fm + $cd);

                // 94 - 2000
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(2000,9,11), Carbon::createFromDate(2007,9,12)])
                ->count();
                $cd = 0;
                $row_abalat_deant[8] = ($fm + $cd);

                // after 2001
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'መፍረይቲ'])
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(2007,9,12), Carbon::createFromDate(9000,1,1)])
                ->count();
                $cd = 0;
                $row_abalat_deant[9] = ($fm + $cd);

                // ደቂ ኣንስትዮ
                $fm = DB::table('approved_hitsuys')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('approved_hitsuys.occupation', ['ግልጋሎት', 'ከተማ ሕርሻ', 'ኮንስትራክሽን', 'ንግዲ', 'ግልጋሎት'])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();

                // መምህራን
                $row_wahio_count[2] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->where('meseretawi_wdabes.type', 'መምህራን')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();

                // ሲ/ሰርቫንት
                $row_wahio_count[3] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->where('meseretawi_wdabes.type', 'ሲ/ሰርቫንት')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();

                // ሸቃሎ
                $row_wahio_count[4] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();

                // ድምር
                $row_wahio_count[5] = $row_wahio_count[1] + $row_wahio_count[2] + $row_wahio_count[3] + $row_wahio_count[4];

                // ጠቕላላ ድምር
                $row_wahio_count[6] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();
            }

            //tabia count
            {
                $row_tabia_count[1] = DB::table('tabias')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->count();

                $row_tabia_count[2] = DB::table('tabias')
                ->join('approved_hitsuys', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'መፍረይቲ')
                ->count();
                // ከተማ ሕርሻ
                $row_tabia_count[6] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ከተማ ሕርሻ')
                ->count();
                // ኮንስትራክሽን
                $row_tabia_count[7] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ኮንስትራክሽን')
                ->count();
                // ንግዲ
                $row_tabia_count[8] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ንግዲ')
                ->count();
                // ግልጋሎት
                $row_tabia_count[9] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ግልጋሎት')
                ->count();
                $row_tabia_count[10] = $row_tabia_count[5] + $row_tabia_count[6] + $row_tabia_count[7] + $row_tabia_count[8] + $row_tabia_count[9];
                // ሸቃሎ
                $row_tabia_count[11] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->count();
                // ተምሃሮ
                $row_tabia_count[12] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ተምሃሮ')
                ->count();
                // መምህራን
                $row_tabia_count[13] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'መምህራን')
                ->count();
                // ሲ/ሰርቫንት
                $row_tabia_count[14] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawi_wdabes.type', 'ሲ/ሰርቫንት')
                ->count();

                //ጠ/ድምር
                $row_tabia_count[16] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', $year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ከተማ ሕርሻ
                $row_plan_deant[4] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ከተማ ሕርሻ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', $year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ኮንስትራክሽን
                $row_plan_deant[6] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ኮንስትራክሽን')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', $year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ንግዲ
                $row_plan_deant[8] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ንግዲ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', $year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ግልጋሎት
                $row_plan_deant[10] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ግልጋሎት')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', $year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                $row_plan_deant[11] = $row_plan_deant[1] + $row_plan_deant[3] + $row_plan_deant[5] + $row_plan_deant[7] + $row_plan_deant[9];
                $row_plan_deant[12] = $row_plan_deant[2] + $row_plan_deant[4] + $row_plan_deant[6] + $row_plan_deant[8] + $row_plan_deant[10];
                $row_plan_deant[13] = ($row_plan_deant[11] != 0) ? ($row_plan_deant[12] / $row_plan_deant[11])*100 : 0;
            }

            //plan non deant
            {
                //ሸቃሎ
                $row_plan_non_deant[2] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', $year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ተምሃሮ
                $row_plan_non_deant[4] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ተምሃሮ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', $year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //መምህራን
                $row_plan_non_deant[6] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'መምህራን')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', $year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ሲ/ሰርቫንት
                $row_plan_non_deant[8] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ሲ/ሰርቫንት')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', $year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();
                $row_plan_non_deant[9] = $row_plan_non_deant[1] + $row_plan_non_deant[3] + $row_plan_non_deant[5] + $row_plan_non_deant[7];
                $row_plan_non_deant[10] = $row_plan_non_deant[2] + $row_plan_non_deant[4] + $row_plan_non_deant[6] + $row_plan_non_deant[8];
                $row_plan_non_deant[11] = ($row_plan_non_deant[9] != 0) ? ($row_plan_non_deant[10] / $row_plan_non_deant[9])*100 : 0;

            }

            //plan all
            {
                //ውልቀሰብ
                $row_plan_all[2] = DB::table('approved_hitsuys')
                ->join('individualplans', 'approved_hitsuys.hitsuyID', '=', 'individualplans.hitsuyID')
                // ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('individualplans.year', $year)
                ->count();
                $row_plan_all[3] = ($row_plan_all[1] != 0) ? ($row_plan_all[2] / $row_plan_all[1])*100 : 0;

                //መሰረታዊ ውዳበ
                $row_plan_all[5] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                // ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('meseretawiwidabeaplans.planyear', $year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();
                $row_plan_all[6] = ($row_plan_all[4] != 0) ? ($row_plan_all[5] / $row_plan_all[4])*100 : 0;

                //ዋህዮ
                $row_plan_all[8] = DB::table('wahioplans')
                ->join('wahios', 'wahios.id', '=', 'wahioplans.wahioid')
                // ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'wahios.parentcode', 'LIKE', DB::raw("CONCAT('_____', tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('wahioplans.planyear', $year)
                ->where('wahioplans.quarter', $this_quarter)
                ->count();
                $row_plan_all[9] = ($row_plan_all[7] != 0) ? ($row_plan_all[8] / $row_plan_all[7])*100 : 0;
            }

            //model members
            {
                $row_model_members[1] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [80, 100])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', $year)
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [80, 100])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [80, 100])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', $year)
                ->count();

                $row_model_members[3] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [0, 80])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', $year)
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [0, 80])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ዘይሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [0, 80])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ዘይሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', $year)
                ->count();

                $row_model_members[5] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [80, 100])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', $year)
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [80, 100])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [80, 100])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', $year)
                ->count();

                $row_model_members[7] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [0, 80])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', $year)
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [0, 80])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ዘይሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [0, 80])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ዘይሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', $year)
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
                // ->where('super_leaders.year', $year)
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
                // ->where('middle_leaders.year', $year)
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
                // ->where('lower_leaders.year', $year)
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
                // ->where('first_instant_leaders.year', $year)
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
                // ->where('tara_members.year', $year)
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
                // ->where('super_leaders.year', $year)
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
                // ->where('middle_leaders.year', $year)
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
                // ->where('lower_leaders.year', $year)
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
                // ->where('first_instant_leaders.year', $year)
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
                // ->where('tara_members.year', $year)
                // ->count();
            }

            //new candidates non deant
            {
                // ሲቪል ሰርቫንት
                $row_new_members_non_deant[2] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ሲቪል ሰርቫንት')
                ->count();

                // ሸቃላይ
                $row_new_members_non_deant[4] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ሸቃላይ')
                ->count();

                // ተምሃራይ
                $row_new_members_non_deant[6] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ተምሃራይ')
                ->count();

                // መምህር
                $row_new_members_non_deant[8] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'መፍረይቲ')
                ->count();

                // ከተማ ሕርሻ
                $row_new_members_deant[4] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ከተማ ሕርሻ')
                ->count();

                // ኮንስትራክሽን
                $row_new_members_deant[6] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ኮንስትራክሽን')
                ->count();

                // ንግዲ
                $row_new_members_deant[8] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ንግዲ')
                ->count();

                // ግልጋሎት
                $row_new_members_deant[10] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ተባ')
                ->count();
                $row_approved_new_members[2] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ኣን')
                ->count();
                $row_approved_new_members[3] = $row_approved_new_members[1] + $row_approved_new_members[2];

                // ፍፃመ
                $row_approved_new_members[4] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ተባ')
                ->where('hitsuy_status', 'ኣባል')
                ->count();
                $row_approved_new_members[5] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ኣን')
                ->where('hitsuy_status', 'ኣባል')
                ->count();
                $row_approved_new_members[6] = $row_approved_new_members[4] + $row_approved_new_members[5];

                // ዘይሰገሩ TODO check ዝተኣገደ part 
                $row_approved_new_members[8] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ተባ')
                ->whereIn('hitsuy_status', ['ሕፁይ', 'ዝተኣገደ'])
                ->count();
                $row_approved_new_members[9] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ኣን')
                ->whereIn('hitsuy_status', ['ሕፁይ', 'ዝተኣገደ'])
                ->count();
                $row_approved_new_members[10] = $row_approved_new_members[8] + $row_approved_new_members[9];

                // ግዚኦም ዘይኣኸለ
                $row_approved_new_members[11] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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
                    // ->where('tabias.isUrban', '=', 'ከተማ')
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
                    // ->where('tabias.isUrban', '=', 'ከተማ')
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
                    // ->where('tabias.isUrban', '=', 'ከተማ')
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
                    // ->where('tabias.isUrban', '=', 'ከተማ')
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
                    // ->where('tabias.isUrban', '=', 'ከተማ')
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
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[2] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ናይ ሕፀ እዋን ምንዋሕ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[3] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሕፁይነት ምብራር')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[4] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሙሉእ ናብ ሕፁይ ኣባልነት ምውራድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[5] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሓላፍነት ንውሱን ጊዜ ምእጋድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[6] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሓላፍነት ምውራድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[7] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[8] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ኣባልነት ምብራር')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();  

                //TODO chargeTypes not set!!
                $row_punishment[10] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();   

                $row_punishment[11] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[12] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [''])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();   

                $row_punishment[13] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [''])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();   

                $row_punishment[14] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [''])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[15] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.gender', 'ኣን')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[16] += DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.gender', 'ተባ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[17] += DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ከተማ')
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

        $row_weseking_gudletin = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_abalat_age_education = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_abalat_mahberawi_bota = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_abalat_deant = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_wahio_count = ['ድምር', 0, 0, 0, 0, 0, 0];
        $row_tabia_count = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_plan_deant = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
        $row_plan_non_deant = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
        $row_plan_all = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, ''];
        $row_model_members = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ''];
        $row_new_members_non_deant = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_new_members_deant = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_approved_new_members = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_grades = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_punishment = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        $table = [$weseking_gudletin, $abalat_age_education, $abalat_mahberawi_bota, $abalat_deant, $wahio_count, $tabia_count, $plan_deant, $plan_non_deant, $plan_all, $model_members, $new_members_non_deant, $new_members_deant, $approved_new_members, $grades, $punishment];
        $row = [$row_weseking_gudletin, $row_abalat_age_education, $row_abalat_mahberawi_bota, $row_abalat_deant, $row_wahio_count, $row_tabia_count, $row_plan_deant, $row_plan_non_deant, $row_plan_all, $row_model_members, $row_new_members_non_deant, $row_new_members_deant, $row_approved_new_members, $row_grades, $row_punishment];
        for($i=0; $i<count($table); $i++){
            foreach ($table[$i] as $value) {
                for($j=1; $j<count($value); $j++){
                    $row[$i][$j] = $row[$i][$j] == '' ? 0 : $row[$i][$j];
                    $value[$j] = $value[$j] == '' ? 0 : $row[$i][$j];
                    $row[$i][$j] += $value[$j];
                }
            }
        }

        $weseking_gudletin[] = $row[0];
        $abalat_age_education[] = $row[1];
        $abalat_mahberawi_bota[] = $row[2];
        $abalat_deant[] = $row[3];
        $wahio_count[] = $row[4];
        $tabia_count[] = $row[5];
        $plan_deant[] = $row[6];
        $plan_non_deant[] = $row[7];
        $plan_all[] = $row[8];
        $model_members[] = $row[9];
        $new_members_non_deant[] = $row[10];
        $new_members_deant[] = $row[11];
        $approved_new_members[] = $row[12];
        $grades[] = $row[13];
        $punishment[] = $row[14];
        return compact('zoneName', 'weseking_gudletin', 'abalat_age_education', 'abalat_mahberawi_bota', 'abalat_deant', 'wahio_count', 'tabia_count', 'plan_deant', 'plan_non_deant', 'plan_all', 'model_members', 'new_members_non_deant', 'new_members_deant', 'approved_new_members', 'grades', 'punishment', 'zobadatas', 'zoneCode', 'year', 'this_quarter', 'quarter_names');
    }
    private function loadDataGeter($zoneCode, $year, $this_quarter){
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $today = DateConvert::toEthiopian(date('d/m/Y'));
        $quarter_names = ['3 ወርሒ', '6 ወርሒ', '9 ወርሒ', 'ዓመት'];
        $st = array_search($this_quarter, $quarter_names) * 3 + 1;
        $quarter = [];
        $quarter[] = DateConvert::toGregorian('1/11/' . ($year-1));
        $quarter[] = DateConvert::toGregorian('1/' . ($st+1) . '/' . $year);
        $A_UPPER = 100;
        $A_LOWER = 80;
        $B_UPPER = 79;
        $B_LOWER = 50;
        $C_UPPER = 49;
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
        $plan_non_deant = [];
        $plan_all = [];
        $model_members = [];
        $new_members_non_deant = [];
        $approved_new_members = [];
        $grades = [];
        $punishment = [];

        $base_data = null;
        
        if(file_exists(base_path('reports/' . ($year-1) . '_fourth_all_report.json'))){
            $arr = json_decode(file_get_contents(base_path('reports/' . ($year-1) . '_fourth_all_report.json')), true);
            // var_dump($arr['ketema'][$zoneName]);
            if($zoneName == 'ኩሎም'){
                $new_arr = ['zoneName' => 'ኩሎም', 'weseking_gudletin' => [], 'abalat_age_education' => [], 'abalat_mahberawi_bota' => [], 'abalat_deant' => [], 'wahio_count' => [], 'tabia_count' => [], 'plan_non_deant' => [], 'plan_all' => [], 'model_members' => [], 'new_members_non_deant' => [], 'approved_new_members' => [], 'grades' => [], 'punishment' => [], 'zobadatas' => [], 'zoneCode' => '0', 'year' => '', 'this_quarter' => '', 'quarter_names' => []];
                foreach ($arr['geter'] as $key) {
                    $new_arr['weseking_gudletin'] = array_merge($new_arr['weseking_gudletin'], $key['weseking_gudletin']);
                    $new_arr['abalat_age_education'] = array_merge($new_arr['abalat_age_education'], $key['abalat_age_education']);
                    $new_arr['abalat_mahberawi_bota'] = array_merge($new_arr['abalat_mahberawi_bota'], $key['abalat_mahberawi_bota']);
                    $new_arr['abalat_deant'] = array_merge($new_arr['abalat_deant'], $key['abalat_deant']);
                    $new_arr['wahio_count'] = array_merge($new_arr['wahio_count'], $key['wahio_count']);
                    $new_arr['tabia_count'] = array_merge($new_arr['tabia_count'], $key['tabia_count']);
                    $new_arr['plan_non_deant'] = array_merge($new_arr['plan_non_deant'], $key['plan_non_deant']);
                    $new_arr['plan_all'] = array_merge($new_arr['plan_all'], $key['plan_all']);
                    $new_arr['model_members'] = array_merge($new_arr['model_members'], $key['model_members']);
                    $new_arr['new_members_non_deant'] = array_merge($new_arr['new_members_non_deant'], $key['new_members_non_deant']);
                    $new_arr['approved_new_members'] = array_merge($new_arr['approved_new_members'], $key['approved_new_members']);
                    $new_arr['grades'] = array_merge($new_arr['grades'], $key['grades']);
                    $new_arr['punishment'] = array_merge($new_arr['punishment'], $key['punishment']);

                    $new_arr['zobadatas'] = $key['zobadatas'];
                    $new_arr['year'] = $key['year'];
                    $new_arr['this_quarter'] = $key['this_quarter'];
                    $new_arr['quarter_names'] = $key['quarter_names'];   
                }
                $base_data = $new_arr;
            }
            else{
                $base_data = $arr['geter'][$zoneName];
            }

        }

        foreach ($woredas as $woreda) {
            $k = 0;
            if($base_data)
            {
                while($base_data['weseking_gudletin'][$k][0] != $woreda['name'])
                $k++;
            }
            $row_weseking_gudletin = [$woreda['name'], ($base_data ? $base_data['weseking_gudletin'][$k][16] : 0), 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_abalat_age_education = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_abalat_mahberawi_bota = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_abalat_deant = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_wahio_count = [$woreda['name'], 0, 0, 0, 0, 0, 0];
            $row_tabia_count = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
            $row_plan_non_deant = [$woreda['name'], ($base_data ? $base_data['plan_non_deant'][$k][2] : 0), 0, ($base_data ? $base_data['plan_non_deant'][$k][4] : 0), 0, ($base_data ? $base_data['plan_non_deant'][$k][6] : 0), 0, ($base_data ? $base_data['plan_non_deant'][$k][8] : 0), 0, ($base_data ? $base_data['plan_non_deant'][$k][10] : 0), 0, 0,];
            $row_plan_all = [$woreda['name'], ($base_data ? $base_data['plan_all'][$k][2] : 0), 0, 0, ($base_data ? $base_data['plan_all'][$k][4] : 0), 0, 0, ($base_data ? $base_data['plan_all'][$k][8] : 0), 0, 0, ''];
            $row_model_members = [$woreda['name'], ($base_data ? $base_data['model_members'][$k][2] : 0), 0, 0, 0, ($base_data ? $base_data['model_members'][$k][6] : 0), 0, 0, 0, ($base_data ? $base_data['model_members'][$k][10] : 0), 0, 0, 0, ''];
            $row_new_members_non_deant = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_approved_new_members = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $row_grades = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
            $row_punishment = [$woreda['name'], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $k++;
            if($woreda['isUrban'] != 'ገጠር'){
                $weseking_gudletin[] = $row_weseking_gudletin;
                $abalat_age_education[] = $row_abalat_age_education;
                $abalat_mahberawi_bota[] = $row_abalat_mahberawi_bota;
                $abalat_deant[] = $row_abalat_deant;
                $wahio_count[] = $row_wahio_count;
                $tabia_count[] = $row_tabia_count;
                $plan_non_deant[] = $row_plan_non_deant;
                $plan_all[] = $row_plan_all;
                $model_members[] = $row_model_members;
                $new_members_non_deant[] = $row_new_members_non_deant;
                $approved_new_members[] = $row_approved_new_members;
                $grades[] = $row_grades;
                $punishment[] = $row_punishment;
                continue;
            }
            // Wesekin gudletin table
            {
                $row_weseking_gudletin[2] = DB::table('hitsuys')
                    ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT('tabias.parentcode', tabias.tabiaCode, '%')"))
                    // ->where('tabias.isUrban', '=', 'ገጠር')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->where('hitsuy_status', 'ሕፁይ')
                    ->whereBetween('hitsuys.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                $row_weseking_gudletin[3] = DB::table('transfers')
                    ->where('transfers.zone', $zoneCode)
                    ->where('transfers.woreda', $woreda['woredaCode'])
                    ->join('tabias', 'transfers.tabia', '=', 'tabias.tabiaCode')
                    // ->where('tabias.isUrban', '=', 'ገጠር')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    ->whereBetween('transfers.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                // TODO ተኣጊዱ ዝነበረ
                $row_weseking_gudletin[4] = DB::table('unsuspend')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'unsuspend.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                ->whereBetween('unsuspend.unsuspendDate', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])->count();

                $row_weseking_gudletin[5] = $row_weseking_gudletin[2] + $row_weseking_gudletin[3] + $row_weseking_gudletin[4];

                $row_weseking_gudletin[6] = DB::table('dismisses')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    // ->where('approved_hitsuys.zoneworedaCode', '=', '010080034')
                    ->where('dismissReason', 'ብሞት')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ገጠር')
                    ->whereBetween('dismisses.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();


                $row_weseking_gudletin[7] = DB::table('dismisses')
                    ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'dismisses.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    // ->where('approved_hitsuys.zoneworedaCode', '=', '010080034')
                    ->where('dismissReason', 'ብቕፅዓት')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ገጠር')
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
                    // ->where('tabias.isUrban', '=', 'ገጠር')
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
                    // ->where('tabias.isUrban', '=', 'ገጠር')
                    ->whereBetween('dismisses.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                    ->count();

                $row_weseking_gudletin[14] = $row_weseking_gudletin[6] + $row_weseking_gudletin[7] + $row_weseking_gudletin[8] + $row_weseking_gudletin[9] + $row_weseking_gudletin[10] + $row_weseking_gudletin[11] + $row_weseking_gudletin[12] + $row_weseking_gudletin[13];
                $row_weseking_gudletin[15] = $row_weseking_gudletin[5] - $row_weseking_gudletin[14];

                $row_weseking_gudletin[16] = DB::table('approved_hitsuys')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->where('hitsuys.hitsuy_status', 'ኣባል')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ገጠር')
                    ->count()
                + DB::table('hitsuys')
                    ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '/%')"))
                    ->where('hitsuy_status', 'ሕፁይ')
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ገጠር')
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
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(35), Carbon::today()->subYears(18)])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[4] = ($fm + $cd);

                // 36 - 60
                $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('hitsuys.dob', [Carbon::today()->subYears(60), Carbon::today()->subYears(35)])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(60), Carbon::today()->subYears(35)])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[5] = ($fm + $cd);

                // above 60
                $fm = DB::table('approved_hitsuys')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('hitsuys.dob', [Carbon::today()->subYears(150), Carbon::today()->subYears(60)])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.dob', [Carbon::today()->subYears(150), Carbon::today()->subYears(60)])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[6] = ($fm + $cd);

                // illiterate [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዘይተምሃረ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዘይተምሃረ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[7] = ($fm + $cd);

                // 1-8 [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('hitsuys.educationlevel', [1, 8])
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.educationlevel', [1, 8])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[8] = ($fm + $cd);

                // 9-12 [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('hitsuys.educationlevel', [9, 12])
                ->count();
                $cd = Hitsuy::whereBetween('hitsuys.educationlevel', [9, 12])
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[9] = ($fm + $cd);

                // certificate [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ሰርቲፊኬት')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ሰርቲፊኬት')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[10] = ($fm + $cd);

                // diploma [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዲፕሎማ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዲፕሎማ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[11] = ($fm + $cd);


                // degree [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዲግሪ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዲግሪ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[12] = ($fm + $cd);

                // master's [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ማስተርስ')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ማስተርስ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[13] = ($fm + $cd);

                // PhD [education]
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.educationlevel', 'ዶክተር')
                ->count();
                $cd = Hitsuy::where('hitsuys.educationlevel', 'ዶክተር')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_age_education[14] = ($fm + $cd);

                // Sum
                $row_abalat_age_education[15] = $row_abalat_age_education[7] + $row_abalat_age_education[8] + $row_abalat_age_education[9] + $row_abalat_age_education[10] + $row_abalat_age_education[11] + $row_abalat_age_education[12] + $row_abalat_age_education[13] + $row_abalat_age_education[14];
            }
            //abalat mahberawi bota
            {
                // ሓረስታይ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ሓረስታይ')
                ->count();
                $cd = Hitsuy::where('hitsuys.occupation', 'ሓረስታይ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')->count();
                $row_abalat_mahberawi_bota[1] = ($fm + $cd);

                // ካልኦት ሰብ ሞያ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->count();
                $cd = Hitsuy::where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')->count();
                $row_abalat_mahberawi_bota[2] = ($fm + $cd);

                // መምህራን
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'መምህር')
                ->count();
                $cd = DB::table('hitsuys')->where('hitsuys.occupation', 'መምህር')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[3] = ($fm + $cd);

                // ተምሃሮ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ተምሃራይ')
                ->count();
                $cd = Hitsuy::where('hitsuys.occupation', 'ተምሃራይ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')->count();
                $row_abalat_mahberawi_bota[4] = ($fm + $cd);

                // 67 - 83
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1974,9,11), Carbon::createFromDate(1990,9,11)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[5] = ($fm + $cd);

                // 84 - 93
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(1990,9,11), Carbon::createFromDate(2000,9,11)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[6] = ($fm + $cd);

                // 94 - 2000
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(2000,9,11), Carbon::createFromDate(2007,9,12)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[7] = ($fm + $cd);

                // after 2001
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereBetween('approved_hitsuys.membershipDate', [Carbon::createFromDate(2007,9,12), Carbon::createFromDate(9000,1,1)])
                ->count();
                $cd = 0;
                $row_abalat_mahberawi_bota[8] = ($fm + $cd);

                // ደቂ ኣንስትዮ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.assignedAssoc','ደቂ ኣንስትዮ')
                ->count();
                $row_abalat_mahberawi_bota[9] = ($fm + $cd);

                // ሓረስታይ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.assignedAssoc','ሓረስታይ')
                ->count();
                $row_abalat_mahberawi_bota[10] = ($fm + $cd);

                // መናእሰይ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.assignedAssoc','መንእሰይ')
                ->count();
                $row_abalat_mahberawi_bota[11] = ($fm + $cd);

                // መምህራን
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.assignedAssoc','መምህራን')
                ->count();
                $row_abalat_mahberawi_bota[12] = ($fm + $cd);

                // መንግስቲ ሰራሕተኛ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->count();
                $cd = DB::table('hitsuys')->where('hitsuys.occupation', 'ሲቪል ሰርቫንት')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[13] = ($fm + $cd);

                // ዘይመንግስታዊ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ዘይመንግስታዊ')
                ->count();
                $cd = DB::table('hitsuys')->where('hitsuys.occupation', 'ዘይመንግስታዊ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[14] = ($fm + $cd);

                // ውልቀ
                $fm = DB::table('approved_hitsuys')
                ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('hitsuys.occupation', 'ውልቀ')
                ->count();
                $cd = DB::table('hitsuys')
                ->where('hitsuys.occupation', 'ውልቀ')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[15] = ($fm + $cd);

                // ደቂ ኣንስትዮ
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('gender', 'ኣን')
                ->count();
                $cd = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('gender', 'ኣን')
                ->count();
                $row_abalat_mahberawi_bota[16] = ($fm + $cd);

                //ድምር
                $fm = DB::table('approved_hitsuys')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->count();
                $cd = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode,'/%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->count();
                $row_abalat_mahberawi_bota[17] = ($fm + $cd);
            }
            //wahio count
            {
                // ተምሃሮ
                $row_wahio_count[1] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->where('meseretawi_wdabes.type', 'ተምሃሮ')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->count();

                // መምህራን
                $row_wahio_count[2] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->where('meseretawi_wdabes.type', 'መምህራን')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->count();

                // ሲ/ሰርቫንት
                $row_wahio_count[3] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->where('meseretawi_wdabes.type', 'ሲ/ሰርቫንት')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->count();

                // ሸቃሎ
                $row_wahio_count[4] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->count();

                // ድምር
                $row_wahio_count[5] = $row_wahio_count[1] + $row_wahio_count[2] + $row_wahio_count[3] + $row_wahio_count[4];

                // ጠቕላላ ድምር
                $row_wahio_count[6] = DB::table('wahios')
                ->join('meseretawi_wdabes', 'wahios.widabeCode', '=', 'meseretawi_wdabes.widabeCode')
                ->join('tabias', 'meseretawi_wdabes.tabiaCode', '=', 'tabias.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->count();
            }

            //tabia count
            {
                $row_tabia_count[1] = DB::table('tabias')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->count();

                $row_tabia_count[2] = DB::table('tabias')
                ->join('approved_hitsuys', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->groupBy('tabias.tabiaCode')
                ->havingRaw('COUNT(approved_hitsuys.hitsuyID)>500')
                ->pluck(DB::raw("COUNT(approved_hitsuys.hitsuyID)"))
                ->count();

                $row_tabia_count[3] = $row_tabia_count[1] - $row_tabia_count[2];

                $row_tabia_count[4] = $row_tabia_count[1];
                // ገባር
                $row_tabia_count[5] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('meseretawi_wdabes.type', 'ገባር')
                ->count();
                // ተምሃሮ
                $row_tabia_count[6] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('meseretawi_wdabes.type', 'ተምሃሮ')
                ->count();
                // መምህራን
                $row_tabia_count[7] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('meseretawi_wdabes.type', 'መምህራን')
                ->count();
                // ሲ/ሰርቫንት
                $row_tabia_count[8] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('meseretawi_wdabes.type', 'ሲ/ሰርቫንት')
                ->count();

                //ጠ/ድምር
                $row_tabia_count[9] = DB::table('meseretawi_wdabes')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->count();
            }

            // TODO for all plan tables set quarter and year 

            //plan non deant
            {
                //ሓረስታይ
                $row_plan_non_deant[2] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ሓረስታይ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('meseretawiwidabeaplans.planyear',$year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ተምሃሮ
                $row_plan_non_deant[4] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ተምሃሮ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('meseretawiwidabeaplans.planyear',$year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //መምህራን
                $row_plan_non_deant[6] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'መምህራን')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('meseretawiwidabeaplans.planyear',$year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ሲ/ሰርቫንት
                $row_plan_non_deant[8] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                ->where('meseretawi_wdabes.type', 'ሲ/ሰርቫንት')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('meseretawiwidabeaplans.planyear',$year)
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
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('individualplans.year',$year)
                ->count();

                //መሰረታዊ ውዳበ
                $row_plan_all[5] = DB::table('meseretawi_wdabes')
                ->join('meseretawiwidabeaplans', 'meseretawi_wdabes.widabeCode', '=', 'meseretawiwidabeaplans.widabecode')
                // ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'tabias.tabiaCode', '=', 'meseretawi_wdabes.tabiaCode')
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('meseretawiwidabeaplans.planyear',$year)
                ->where('meseretawiwidabeaplans.quarter', $this_quarter)
                ->count();

                //ዋህዮ
                $row_plan_all[8] = DB::table('wahioplans')
                ->join('wahios', 'wahios.id', '=', 'wahioplans.wahioid')
                // ->where('meseretawi_wdabes.type', 'ሸቃሎ')
                ->join('tabias', 'wahios.parentcode', 'LIKE', DB::raw("CONCAT('_____', tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('wahioplans.planyear',$year)
                ->where('wahioplans.quarter', $this_quarter)
                ->count();
            }

            //TODO complete table
            //model members
            {
                $row_model_members[1] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [80, 100])
                ->where('super_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('super_leaders.year', ($this_quarter == 'ዓመት' ? $year : $year - 1))
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [80, 100])
                ->where('middle_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('middle_leaders.year', ($this_quarter == 'ዓመት' ? $year : $year - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ሞዴል')
                ->where('lower_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('lower_leaders.year', ($this_quarter == 'ዓመት' ? $year : $year - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [80, 100])
                ->where('first_instant_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('first_instant_leaders.year', ($this_quarter == 'ዓመት' ? $year : $year - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ሞዴል')
                ->where('tara_members.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('tara_members.year', ($this_quarter == 'ዓመት' ? $year : $year - 1))
                ->count();

                $row_model_members[2] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [80, 100])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', $year)
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [80, 100])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [80, 100])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', $year)
                ->count();

                $row_model_members[3] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [0, 80])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', $year)
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [0, 80])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ዘይሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [0, 80])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'መ/ዉ/አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ዘይሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', $year)
                ->count();

                $row_model_members[5] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [80, 100])
                ->where('super_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('super_leaders.year', ($this_quarter == 'ዓመት' ? $year : $year - 1))
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [80, 100])
                ->where('middle_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('middle_leaders.year', ($this_quarter == 'ዓመት' ? $year : $year - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ሞዴል')
                ->where('lower_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('lower_leaders.year', ($this_quarter == 'ዓመት' ? $year : $year - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [80, 100])
                ->where('first_instant_leaders.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('first_instant_leaders.year', ($this_quarter == 'ዓመት' ? $year : $year - 1))
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ሞዴል')
                ->where('tara_members.half', ($this_quarter == 'ዓመት' ? '6 ወርሒ':'ዓመት'))
                ->where('tara_members.year', ($this_quarter == 'ዓመት' ? $year : $year - 1))
                ->count();

                $row_model_members[6] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [80, 100])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', $year)
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [80, 100])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [80, 100])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', $year)
                ->count();

                $row_model_members[7] = 
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                ->whereBetween('super_leaders.sum', [0, 80])
                ->where('super_leaders.half', $this_quarter)
                ->where('super_leaders.year', $year)
                ->count()
                 +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                ->whereBetween('middle_leaders.sum', [0, 80])
                ->where('middle_leaders.half', $this_quarter)
                ->where('middle_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                ->where('lower_leaders.model', 'ዘይሞዴል')
                ->where('lower_leaders.half', $this_quarter)
                ->where('lower_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                ->whereBetween('first_instant_leaders.sum', [0, 80])
                ->where('first_instant_leaders.half', $this_quarter)
                ->where('first_instant_leaders.year', $year)
                ->count()
                +
                DB::table('approved_hitsuys')
                ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                ->where('tara_members.model', 'ዘይሞዴል')
                ->where('tara_members.half', $this_quarter)
                ->where('tara_members.year', $year)
                ->count();

                // $row_model_members[10] = 
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                // ->whereBetween('super_leaders.sum', [80, 100])
                // ->where('super_leaders.half', $this_quarter)
                // ->where('super_leaders.year', $year)
                // ->count()
                //  +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                // ->whereBetween('middle_leaders.sum', [80, 100])
                // ->where('middle_leaders.half', $this_quarter)
                // ->where('middle_leaders.year', $year)
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                // ->where('lower_leaders.model', 'ሞዴል')
                // ->where('lower_leaders.half', $this_quarter)
                // ->where('lower_leaders.year', $year)
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                // ->whereBetween('first_instant_leaders.sum', [80, 100])
                // ->where('first_instant_leaders.half', $this_quarter)
                // ->where('first_instant_leaders.year', $year)
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                // ->where('tara_members.model', 'ሞዴል')
                // ->where('tara_members.half', $this_quarter)
                // ->where('tara_members.year', $year)
                // ->count();

                // $row_model_members[11] = 
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ላዕለዋይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->join('super_leaders', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                // ->whereBetween('super_leaders.sum', [0, 80])
                // ->where('super_leaders.half', $this_quarter)
                // ->where('super_leaders.year', $year)
                // ->count()
                //  +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ማእኸላይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->join('middle_leaders', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                // ->whereBetween('middle_leaders.sum', [0, 80])
                // ->where('middle_leaders.half', $this_quarter)
                // ->where('middle_leaders.year', $year)
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ታሕተዋይ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->join('lower_leaders', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                // ->where('lower_leaders.model', 'ዘይሞዴል')
                // ->where('lower_leaders.half', $this_quarter)
                // ->where('lower_leaders.year', $year)
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ጀማሪ አመራርሓ')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->join('first_instant_leaders', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                // ->whereBetween('first_instant_leaders.sum', [0, 80])
                // ->where('first_instant_leaders.half', $this_quarter)
                // ->where('first_instant_leaders.year', $year)
                // ->count()
                // +
                // DB::table('approved_hitsuys')
                // ->where('approved_hitsuys.memberType', 'ተራ ኣባል')
                // ->where('approved_hitsuys.meseratawiposition', 'ዋህዮ አመራርሓ')
                // ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                // ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->join('tara_members', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                // ->where('tara_members.model', 'ዘይሞዴል')
                // ->where('tara_members.half', $this_quarter)
                // ->where('tara_members.year', $year)
                // ->count();
            }

            //new candidates non deant
            {
                // ሲቪል ሰርቫንት
                $row_new_members_non_deant[2] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ሲቪል ሰርቫንት')
                ->count();

                // ሓረስታይ
                $row_new_members_non_deant[4] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ሓረስታይ')
                ->count();

                // ተምሃራይ
                $row_new_members_non_deant[6] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'ተምሃራይ')
                ->count();

                // መምህር
                $row_new_members_non_deant[8] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->where('hitsuy_status', 'ሕፁይ')
                ->where('occupation', 'መምህር')
                ->count();
            }

            //new approved members
            {
                // ክሰግሩ ዝግበኦም
                $row_approved_new_members[1] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ተባ')
                ->count();
                $row_approved_new_members[2] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ኣን')
                ->count();
                $row_approved_new_members[3] = $row_approved_new_members[1] + $row_approved_new_members[2];

                // ፍፃመ
                $row_approved_new_members[4] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ተባ')
                ->where('hitsuy_status', 'ኣባል')
                ->count();
                $row_approved_new_members[5] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ኣን')
                ->where('hitsuy_status', 'ኣባል')
                ->count();
                $row_approved_new_members[6] = $row_approved_new_members[4] + $row_approved_new_members[5];

                // ዘይሰገሩ TODO check ዝተኣገደ part 
                $row_approved_new_members[8] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ተባ')
                ->whereIn('hitsuy_status', ['ሕፁይ', 'ዝተኣገደ'])
                ->count();
                $row_approved_new_members[9] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,1,1)->subMonths(6), Carbon::createFromDate(2004,3,30)->subMonths(6)])
                ->where('gender', 'ኣን')
                ->whereIn('hitsuy_status', ['ሕፁይ', 'ዝተኣገደ'])
                ->count();
                $row_approved_new_members[10] = $row_approved_new_members[8] + $row_approved_new_members[9];

                // ግዚኦም ዘይኣኸለ
                $row_approved_new_members[11] = DB::table('hitsuys')
                ->join('tabias', 'hitsuys.hitsuyID', 'LIKE', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode, '%')"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                ->whereBetween('regDate',[Carbon::createFromDate(2004,3,30)->subMonths(6), Carbon::createFromDate(9000,1,1)->subMonths(6)])
                ->whereIn('hitsuy_status', ['ሕፁይ', 'ዝተኣገደ'])
                ->count();

            }

            //grades
            {
                // ሓረስታይ
                {
                    // total
                    $row_grades[1] += DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ገጠር')
                    // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                    ->where('hitsuys.occupation', 'ሓረስታይ')
                    ->count();
                    // ሓረስታይ A
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('super_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('middle_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->where('lower_leaders.evaluation', 'A')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('first_instant_leaders.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('experts.sum', [$A_LOWER, $A_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->where('tara_members.evaluation', 'A')
                        ->count();

                        $row_grades[2] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // ሓረስታይ B
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('super_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('middle_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->where('lower_leaders.evaluation', 'B')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('first_instant_leaders.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('experts.sum', [$B_LOWER, $B_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->where('tara_members.evaluation', 'B')
                        ->count();

                        $row_grades[3] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                    // ሓረስታይ C
                    {
                        $sl = DB::table('super_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'super_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('super_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ml = DB::table('middle_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'middle_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('middle_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ll = DB::table('lower_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'lower_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->where('lower_leaders.evaluation', 'C')
                        ->count();

                        $fil = DB::table('first_instant_leaders')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'first_instant_leaders.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('first_instant_leaders.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $ex = DB::table('experts')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'experts.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->whereBetween('experts.sum', [$C_LOWER, $C_UPPER])
                        ->count();

                        $tm = DB::table('tara_members')
                        ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'tara_members.hitsuyID')
                        ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                        ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                        ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                        // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                        ->where('hitsuys.occupation', 'ሓረስታይ')
                        ->where('tara_members.evaluation', 'C')
                        ->count();

                        $row_grades[4] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                }
                // ሰብ ሞያ
                {
                    // total
                    $row_grades[6] += DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ገጠር')
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

                        $row_grades[7] = $sl + $ml + $ll + $fil + $ex + $tm;
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

                        $row_grades[8] = $sl + $ml + $ll + $fil + $ex + $tm;
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

                        $row_grades[9] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                }
                // መምህራን
                {
                    // total
                    $row_grades[11] += DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ገጠር')
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

                        $row_grades[12] = $sl + $ml + $ll + $fil + $ex + $tm;
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

                        $row_grades[13] = $sl + $ml + $ll + $fil + $ex + $tm;
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

                        $row_grades[14] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                }
                // ተምሃሮ
                {
                    // total
                    $row_grades[16] += DB::table('approved_hitsuys')
                    ->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID')
                    ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                    ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                    // ->where('tabias.isUrban', '=', 'ገጠር')
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

                        $row_grades[17] = $sl + $ml + $ll + $fil + $ex + $tm;
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

                        $row_grades[18] = $sl + $ml + $ll + $fil + $ex + $tm;
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

                        $row_grades[19] = $sl + $ml + $ll + $fil + $ex + $tm;
                    }
                }
                $row_grades[5] =  $row_grades[1] - ($row_grades[2] + $row_grades[3] + $row_grades[4]);
                $row_grades[10] =  $row_grades[6] - ($row_grades[7] + $row_grades[8] + $row_grades[9]);
                $row_grades[15] =  $row_grades[11] - ($row_grades[12] + $row_grades[13] + $row_grades[14]);
                $row_grades[20] =  $row_grades[16] - ($row_grades[17] + $row_grades[18] + $row_grades[19]);
            }

            //punishments
            {
                $row_punishment[1] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'መጠንቀቕታ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[2] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ናይ ሕፀ እዋን ምንዋሕ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[3] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሕፁይነት ምብራር')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[4] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሙሉእ ናብ ሕፁይ ኣባልነት ምውራድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[5] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሓላፍነት ንውሱን ጊዜ ምእጋድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[6] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ሓላፍነት ምውራድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[7] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[8] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('penaltyGiven', 'ካብ ኣባልነት ምብራር')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();  

                //TODO chargeTypes not set!!
                $row_punishment[10] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();   

                $row_punishment[11] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[12] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [''])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();   

                $row_punishment[13] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [''])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();   

                $row_punishment[14] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->whereIn('chargeType', [''])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[15] = DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.gender', 'ኣን')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[16] += DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->where('approved_hitsuys.gender', 'ተባ')
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
                // ->whereBetween('penalties.created_at', [Carbon::createFromDate(explode("/", $quarter[0])[2], explode("/", $quarter[0])[1], explode("/", $quarter[0])[0]), Carbon::createFromDate(explode("/", $quarter[1])[2], explode("/", $quarter[1])[1], explode("/", $quarter[1])[0])])
                ->count();

                $row_punishment[17] += DB::table('penalties')
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'penalties.hitsuyID')
                // ->whereBetween('approved_hitsuys.updated_at', [$now,  $then])
                ->join('tabias', 'approved_hitsuys.zoneworedaCode', '=', DB::raw("CONCAT(tabias.parentcode, tabias.tabiaCode)"))
                ->where('tabias.woredaCode', '=', $woreda['woredaCode'])
                // ->where('tabias.isUrban', '=', 'ገጠር')
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
            $plan_non_deant[] = $row_plan_non_deant;
            $plan_all[] = $row_plan_all;
            $model_members[] = $row_model_members;
            $new_members_non_deant[] = $row_new_members_non_deant;
            $approved_new_members[] = $row_approved_new_members;
            $grades[] = $row_grades;
            $punishment[] = $row_punishment;
        }
        $row_weseking_gudletin = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_abalat_age_education = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_abalat_mahberawi_bota = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_abalat_deant = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_wahio_count = ['ድምር', 0, 0, 0, 0, 0, 0];
        $row_tabia_count = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
        $row_plan_non_deant = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
        $row_plan_all = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, ''];
        $row_model_members = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ''];
        $row_new_members_non_deant = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_approved_new_members = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $row_grades = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,];
        $row_punishment = ['ድምር', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        $table = [$weseking_gudletin, $abalat_age_education, $abalat_mahberawi_bota, $abalat_deant, $wahio_count, $tabia_count, $plan_non_deant, $plan_all, $model_members, $new_members_non_deant, $approved_new_members, $grades, $punishment];
        $row = [$row_weseking_gudletin, $row_abalat_age_education, $row_abalat_mahberawi_bota, $row_abalat_deant, $row_wahio_count, $row_tabia_count, $row_plan_non_deant, $row_plan_all, $row_model_members, $row_new_members_non_deant, $row_approved_new_members, $row_grades, $row_punishment];
        for($i=0; $i<count($table); $i++){
            foreach ($table[$i] as $value) {
                for($j=1; $j<count($value); $j++){
                    $row[$i][$j] += $value[$j];
                }
            }
        }

        $weseking_gudletin[] = $row[0];
        $abalat_age_education[] = $row[1];
        $abalat_mahberawi_bota[] = $row[2];
        $abalat_deant[] = $row[3];
        $wahio_count[] = $row[4];
        $tabia_count[] = $row[5];
        $plan_non_deant[] = $row[6];
        $plan_all[] = $row[7];
        $model_members[] = $row[8];
        $new_members_non_deant[] = $row[9];
        $approved_new_members[] = $row[10];
        $grades[] = $row[11];
        $punishment[] = $row[12];
        return compact('zoneName', 'weseking_gudletin', 'abalat_age_education', 'abalat_mahberawi_bota', 'abalat_deant', 'wahio_count', 'tabia_count', 'plan_non_deant', 'plan_all', 'model_members', 'new_members_non_deant', 'approved_new_members', 'grades', 'punishment', 'zobadatas', 'zoneCode', 'year', 'this_quarter', 'quarter_names');
    }
}
