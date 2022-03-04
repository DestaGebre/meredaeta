<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;

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
use App\Yearly;
use App\Monthly;
use App\Gift;
use App\Mewacho;
use App\MewachoSetting;
use DB;

use Carbon\Carbon;

class PaymentReport extends Controller
{
    public function index(Request $request){
        $zoneCode = Auth::user()->area;
        if(Auth::user()->usertype == 'woredaadmin' || Auth::user()->usertype == 'woreda'){
            $zoneCode = Woreda::where('woredacode', Auth::user()->area)->pluck('zoneCode')->first();
        }
        $zobadatas = null;
        $zoneName = null;
        $year = null;
        $month = null;
        $quarter = null;
        $all_quarters = ['1' => '1 ወርሒ', '3' => '3 ወርሒ', '6' => '6 ወርሒ', '9' => '9 ወርሒ', '0' => 'ዓመት'];
        $all_months = ['መስከረም', 'ጥቅምቲ', 'ሕዳር', 'ታሕሳስ', 'ጥሪ', 'ለካቲት', 'መጋቢት', 'ሚያዝያ', 'ግንቦት', 'ሰነ', 'ሓምለ', 'ነሓሰ'];
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone && $request->zone !== '0'){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
            }
            else
                $zoneCode = $request->zone;
        }
        if(!$request->year || (!$request->quarter && $request->quarter !== '0')){
            $today = DateConvert::toEthiopian(date('d/m/Y'));
            $year = explode("/", $today)[2];
            $month = explode("/", $today)[1];
            $quarter = 1;
        }
        else{
            $year = $request->year;
            $quarter = $request->quarter;
            $month = $request->month ? $request->month : explode("/", DateConvert::toEthiopian(date('d/m/Y')))[1];
        }
        if($zoneCode === '0')
            $zoneName = 'ኩሎም';
        else
            $zoneName = DB::table('zobatats')->where('zoneCode', $zoneCode)->pluck('zoneName')->first();
        $start_end = [];
        if($quarter == 1){
            $start_end[] = DateConvert::toGregorian('1/' . $month . '/' .$year);
            if($month == 12)
                $start_end[] = DateConvert::toGregorian('1/1/' .($year+1));
            else
                $start_end[] = DateConvert::toGregorian('1/' . ($month+1) . '/' .$year);
        }
        else if($quarter != 0){
            $start_end[] = DateConvert::toGregorian('1/' . ($quarter-2) . '/' .$year);
            $start_end[] = DateConvert::toGregorian('1/' . ($quarter+1) . '/' .$year);
        }
        else{
            $start_end[] = DateConvert::toGregorian('1/1/' . $year);
            $start_end[] = DateConvert::toGregorian('1/1/' . ($year+1));
        }

        $selected_months = null;
        if($quarter != 0){
            if($quarter == 1)
                $selected_months = [$all_months[$month-1]];
            else{
                $selected_months = array_slice($all_months, 0, $quarter);
            }
        }
        else{
            $selected_months = $all_months;
        }

        $widabes = meseretawiWdabe::where('parentcode', 'LIKE', $zoneCode . '%')->select(['widabeName', 'widabeCode', 'type'])->get();
        $montly_table = [];
        $occupation_type = ["ሲቪል ሰርቫንት", "መምህር"];
        foreach($widabes as $widabe){
            $upto = $selected_months[0] != array_slice($selected_months, -1)[0];
            foreach ($occupation_type as $occupation) {
                 $row_montly = [$widabe->widabeName, $selected_months[0] . ($upto ? '-' . array_slice($selected_months, -1)[0] : ''), $occupation, 0, 0, 0, 0, 0, ''];
                $row_montly[3] = ApprovedHitsuy::where('assignedWudabe','=', $widabe->widabeCode)->where('occupation', $occupation)->count();


                $query = DB::table("monthlies")
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'monthlies.hitsuyID')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->where('approved_hitsuys.occupation', $occupation)
                ->where('monthlies.year', $year)
                ->whereIn('monthlies.month', $selected_months)
                ->groupBy('approved_hitsuys.hitsuyID')->select('approved_hitsuys.hitsuyID', DB::raw('sum(monthlies.amount) as amount'), DB::raw('count(*) as cnt'))
                ->havingRaw('count(*) >= ?', [count($selected_months)]);

                $row_montly[4] = $query ? count($query->get()->toArray()) : 0;

                $row_montly[5] = $row_montly[3] - $row_montly[4];

                $row_montly[6] = DB::table("monthlies")
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'monthlies.hitsuyID')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->where('approved_hitsuys.occupation', $occupation)
                ->where('monthlies.year', $year)
                ->whereIn('monthlies.month', $selected_months)
                ->groupBy('approved_hitsuys.hitsuyID')->select('approved_hitsuys.hitsuyID', DB::raw('sum(monthlies.amount) as amount'), DB::raw('count(*) as count'))
                ->pluck('amount')->sum();
                $to_be_paid = DB::table("approved_hitsuys")
                ->join('monthly_settings', function($join){
                    $join->on('approved_hitsuys.netSalary', '>', 'monthly_settings.from');
                    $join->on('approved_hitsuys.netSalary', '<=', 'monthly_settings.to');
                })
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->where('approved_hitsuys.occupation', $occupation)
                ->sum(DB::raw('approved_hitsuys.netSalary * monthly_settings.percent'));
                // $to_be_paid = 0;
                // $monthlydata = DB::table("monthly_settings")->select("percent","from","to")->get()->toArray();
                // foreach ($tempdata as $key => $value) {
                //     $myNet = $value;
                //     $mypercent=0.0;
                //     foreach ($monthlydata as $monthly) {
                //         if(($myNet > $monthly->from) && ($myNet <= $monthly->to)){
                //             $mypercent = $monthly->percent;
                //             break;
                //         }
                //     }   
                //     $to_be_paid += $myNet*$mypercent;
                // }
                $row_montly[7] = $to_be_paid*count($selected_months) - $row_montly[6];
                $montly_table[] = $row_montly;   
            }
        }
        return view('report.payment', compact('zoneCode', 'zobadatas', 'year', 'month', 'quarter', 'all_quarters', 'all_months', 'montly_table'));
    }
    public function monthlyExcel(Request $request){
        $zoneCode = Auth::user()->area;
        $zobadatas = null;
        $zoneName = null;
        $year = null;
        $month = null;
        $quarter = null;
        $all_quarters = ['1' => '1 ወርሒ', '3' => '3 ወርሒ', '6' => '6 ወርሒ', '9' => '9 ወርሒ', '0' => 'ዓመት'];
        $all_months = ['መስከረም', 'ጥቅምቲ', 'ሕዳር', 'ታሕሳስ', 'ጥሪ', 'ለካቲት', 'መጋቢት', 'ሚያዝያ', 'ግንቦት', 'ሰነ', 'ሓምለ', 'ነሓሰ'];
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone && $request->zone !== '0'){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
            }
            else
                $zoneCode = $request->zone;
            if(!$request->year || (!$request->quarter && $request->quarter !== '0')){
                $today = DateConvert::toEthiopian(date('d/m/Y'));
                $year = explode("/", $today)[2];
                $month = explode("/", $today)[1];
                $quarter = 1;
            }
            else{
                $year = $request->year;
                $quarter = $request->quarter;
                $month = $request->month ? $request->month : explode("/", DateConvert::toEthiopian(date('d/m/Y')))[1];
            }
        }
        if($zoneCode === '0')
            $zoneName = 'ኩሎም';
        else
            $zoneName = DB::table('zobatats')->where('zoneCode', $zoneCode)->pluck('zoneName')->first();
        $start_end = [];
        if($quarter == 1){
            $start_end[] = DateConvert::toGregorian('1/' . $month . '/' .$year);
            if($month == 12)
                $start_end[] = DateConvert::toGregorian('1/1/' .($year+1));
            else
                $start_end[] = DateConvert::toGregorian('1/' . ($month+1) . '/' .$year);
        }
        else if($quarter != 0){
            $start_end[] = DateConvert::toGregorian('1/' . ($quarter-2) . '/' .$year);
            $start_end[] = DateConvert::toGregorian('1/' . ($quarter+1) . '/' .$year);
        }
        else{
            $start_end[] = DateConvert::toGregorian('1/1/' . $year);
            $start_end[] = DateConvert::toGregorian('1/1/' . ($year+1));
        }

        $selected_months = null;
        if($quarter != 0){
            if($quarter == 1)
                $selected_months = [$all_months[$month-1]];
            else{
                $selected_months = array_slice($all_months, 0, $quarter);
            }
        }
        else{
            $selected_months = $all_months;
        }

        $widabes = meseretawiWdabe::where('parentcode', 'LIKE', $zoneCode . '%')->select(['widabeName', 'widabeCode', 'type'])->get();
        $montly_table = [];
        $occupation_type = ["ሲቪል ሰርቫንት", "መምህር"];
        foreach($widabes as $widabe){
            $upto = $selected_months[0] != array_slice($selected_months, -1)[0];
            foreach ($occupation_type as $occupation) {
                 $row_montly = [$widabe->widabeName, $selected_months[0] . ($upto ? '-' . array_slice($selected_months, -1)[0] : ''), $occupation, 0, 0, 0, 0, 0, ''];
                $row_montly[3] = ApprovedHitsuy::where('assignedWudabe','=', $widabe->widabeCode)->where('occupation', $occupation)->count();


                $query = DB::table("monthlies")
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'monthlies.hitsuyID')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->where('approved_hitsuys.occupation', $occupation)
                ->where('monthlies.year', $year)
                ->whereIn('monthlies.month', $selected_months)
                ->groupBy('approved_hitsuys.hitsuyID')->select('approved_hitsuys.hitsuyID', DB::raw('sum(monthlies.amount) as amount'), DB::raw('count(*) as cnt'))
                ->havingRaw('count(*) >= ?', [count($selected_months)]);

                $row_montly[4] = $query ? count($query->get()->toArray()) : 0;

                $row_montly[5] = $row_montly[3] - $row_montly[4];

                $row_montly[6] = DB::table("monthlies")
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'monthlies.hitsuyID')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->where('approved_hitsuys.occupation', $occupation)
                ->where('monthlies.year', $year)
                ->whereIn('monthlies.month', $selected_months)
                ->groupBy('approved_hitsuys.hitsuyID')->select('approved_hitsuys.hitsuyID', DB::raw('sum(monthlies.amount) as amount'), DB::raw('count(*) as count'))
                ->pluck('amount')->sum();
                $to_be_paid = DB::table("approved_hitsuys")
                ->join('monthly_settings', function($join){
                    $join->on('approved_hitsuys.netSalary', '>', 'monthly_settings.from');
                    $join->on('approved_hitsuys.netSalary', '<=', 'monthly_settings.to');
                })
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->where('approved_hitsuys.occupation', $occupation)
                ->sum(DB::raw('approved_hitsuys.netSalary * monthly_settings.percent'));
                // $to_be_paid = 0;
                // $monthlydata = DB::table("monthly_settings")->select("percent","from","to")->get()->toArray();
                // foreach ($tempdata as $key => $value) {
                //     $myNet = $value;
                //     $mypercent=0.0;
                //     foreach ($monthlydata as $monthly) {
                //         if(($myNet > $monthly->from) && ($myNet <= $monthly->to)){
                //             $mypercent = $monthly->percent;
                //             break;
                //         }
                //     }   
                //     $to_be_paid += $myNet*$mypercent;
                // }
                $row_montly[7] = $to_be_paid*count($selected_months) - $row_montly[6];
                $montly_table[] = $row_montly;   
            }
        }
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . ($quarter != 1 ? 'ናይ' : '') . ' ' . ( $quarter == 1 ? $all_months[$month-1] : $all_quarters[$quarter]) . ' ' . $year . ' [ወርሓዊ] ክፍሊት ሪፖርት ' .  $zobadatas[$zoneCode] . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'መሰረታዊ ውዳበ')
        ->setCellValue('B1', 'ወርሒ')
        ->setCellValue('C1', 'ዓይነት ኣባላት')
        ->setCellValue('D1', 'በዝሒ ኣባላት')
        ->setCellValue('E1', 'ዝኸፈሉ')
        ->setCellValue('F1', 'ዘይኸፈሉ')
        ->setCellValue('G1', 'ድምር ክፍሊት')
        ->setCellValue('H1', 'ዘይተኸፈለ መጠን')
        ->setCellValue('I1', 'ሪኢቶ');
        $i = 2;

        foreach ($montly_table as $row) {
              $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i , $row[0])
                ->setCellValue('B' . $i , $row[1])
                ->setCellValue('C' . $i , $row[2])
                ->setCellValue('D' . $i , $row[3])
                ->setCellValue('E' . $i , $row[4])
                ->setCellValue('F' . $i , $row[5])
                ->setCellValue('G' . $i , round($row[6], 2))
                ->setCellValue('H' . $i , round($row[7], 2))
                ->setCellValue('I' . $i , $row[8]);
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
    public function indexYearly(Request $request){
        $zoneCode = Auth::user()->area;
        $zoneCode = Auth::user()->area;
        if(Auth::user()->usertype == 'woredaadmin' || Auth::user()->usertype == 'woreda'){
            $zoneCode = Woreda::where('woredacode', Auth::user()->area)->pluck('zoneCode')->first();
        }
        $zobadatas = null;
        $zoneName = null;
        $year = null;
        $month = null;
        $quarter = null;
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone && $request->zone !== '0'){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
            }
            else
                $zoneCode = $request->zone;
        }
        if(!$request->year){
            $today = DateConvert::toEthiopian(date('d/m/Y'));
            $year = explode("/", $today)[2];
        }
        else{
            $year = $request->year;
        }
        if($zoneCode === '0')
            $zoneName = 'ኩሎም';
        else
            $zoneName = DB::table('zobatats')->where('zoneCode', $zoneCode)->pluck('zoneName')->first();

        $widabes = meseretawiWdabe::where('parentcode', 'LIKE', $zoneCode . '%')->select(['widabeName', 'widabeCode', 'type'])->get();
        $yearly = [];
        $occupation_type = ['ተምሃራይ' => ['ተምሃራይ'], 'ደኣንት' => ['መፍረዪ', 'ንግዲ', 'ግልጋሎት', 'ኮስንትራክሽን', 'ከተማ ሕርሻ'], 'ሸቃላይ' => ['ሸቃላይ'], 'ሓረስታይ' => ['ሓረስታይ']];
        foreach($widabes as $widabe){
            foreach ($occupation_type as $key => $occupation) {
                 $row_yearly = [$widabe->widabeName, $key, 0, 0, 0, 0, 0, ''];
                $row_yearly[2] = ApprovedHitsuy::where('assignedWudabe','=', $widabe->widabeCode)->whereIn('occupation', $occupation)->count();
                $query = DB::table("yearlies")
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'yearlies.hitsuyID')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->whereIn('approved_hitsuys.occupation', $occupation)
                ->where('yearlies.year', $year);
                $row_yearly[3] = $query->count();
                $row_yearly[4] = $row_yearly[2] - $row_yearly[3];
                $row_yearly[5] = $query->pluck('amount')->sum();
                $to_be_paid = DB::table("approved_hitsuys")
                ->join('yearly_settings', 'approved_hitsuys.occupation', '=', 'yearly_settings.type')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->whereIn('approved_hitsuys.occupation', $occupation)
                ->sum('yearly_settings.amount');
                $row_yearly[6] = $to_be_paid - $row_yearly[5];
                $yearly[] = $row_yearly;
            }
        }
        return view('report.payment_yearly', compact('zoneCode', 'zobadatas', 'year', 'yearly'));
    }
    public function yearlyExcel(Request $request){
        $zoneCode = Auth::user()->area;
        $zobadatas = null;
        $zoneName = null;
        $year = null;
        $month = null;
        $quarter = null;
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone && $request->zone !== '0'){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
            }
            else
                $zoneCode = $request->zone;
            if(!$request->year){
                $today = DateConvert::toEthiopian(date('d/m/Y'));
                $year = explode("/", $today)[2];
            }
            else{
                $year = $request->year;
            }
        }
        if($zoneCode === '0')
            $zoneName = 'ኩሎም';
        else
            $zoneName = DB::table('zobatats')->where('zoneCode', $zoneCode)->pluck('zoneName')->first();

        $widabes = meseretawiWdabe::where('parentcode', 'LIKE', $zoneCode . '%')->select(['widabeName', 'widabeCode', 'type'])->get();
        $yearly = [];
        $occupation_type = ['ተምሃራይ' => ['ተምሃራይ'], 'ደኣንት' => ['መፍረዪ', 'ንግዲ', 'ግልጋሎት', 'ኮስንትራክሽን', 'ከተማ ሕርሻ'], 'ሸቃላይ' => ['ሸቃላይ'], 'ሓረስታይ' => ['ሓረስታይ']];
        foreach($widabes as $widabe){
            foreach ($occupation_type as $key => $occupation) {
                 $row_yearly = [$widabe->widabeName, $key, 0, 0, 0, 0, 0, ''];
                $row_yearly[2] = ApprovedHitsuy::where('assignedWudabe','=', $widabe->widabeCode)->whereIn('occupation', $occupation)->count();
                $query = DB::table("yearlies")
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'yearlies.hitsuyID')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->whereIn('approved_hitsuys.occupation', $occupation)
                ->where('yearlies.year', $year);
                $row_yearly[3] = $query->count();
                $row_yearly[4] = $row_yearly[2] - $row_yearly[3];
                $row_yearly[5] = $query->pluck('amount')->sum();
                $to_be_paid = DB::table("approved_hitsuys")
                ->join('yearly_settings', 'approved_hitsuys.occupation', '=', 'yearly_settings.type')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->whereIn('approved_hitsuys.occupation', $occupation)
                ->sum('yearly_settings.amount');
                $row_yearly[6] = $to_be_paid - $row_yearly[5];
                $yearly[] = $row_yearly;
            }
        }
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . 'ናይ ' . $year . ' [ዓመታዊ] ክፍሊት ሪፖርት ' . $zobadatas[$zoneCode] . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'መሰረታዊ ውዳበ')
        ->setCellValue('B1', 'ዓይነት ኣባላት')
        ->setCellValue('C1', 'በዝሒ ኣባላት')
        ->setCellValue('D1', 'ዝኸፈሉ')
        ->setCellValue('E1', 'ዘይኸፈሉ')
        ->setCellValue('F1', 'ድምር ክፍሊት')
        ->setCellValue('G1', 'ዘይተኸፈለ መጠን')
        ->setCellValue('H1', 'ሪኢቶ');
        $i = 2;

        foreach ($yearly as $row) {
              $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i , $row[0])
                ->setCellValue('B' . $i , $row[1])
                ->setCellValue('C' . $i , $row[2])
                ->setCellValue('D' . $i , $row[3])
                ->setCellValue('E' . $i , $row[4])
                ->setCellValue('F' . $i , round($row[5], 2))
                ->setCellValue('G' . $i , round($row[6], 2))
                ->setCellValue('H' . $i , $row[7]);
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
    public function indexGift(Request $request){
        $year = null;
        if(!$request->year){
            $today = DateConvert::toEthiopian(date('d/m/Y'));
            $year = explode("/", $today)[2];
        }
        else{
            $year = $request->year;
        }
        $start = explode('/', DateConvert::toGregorian('1/1/'. $year));
        $end = explode('/', DateConvert::toGregorian('1/1/'. ($year+1)));
        $gifts = Gift::whereBetween('donationDate', [Carbon::createFromDate($start[2], $start[1], $start[0]), Carbon::createFromDate($end[2], $end[1], $end[0])])->orderBy('valuation','desc')->get();
        return view('report.payment_gift', compact('year', 'gifts'));
    }
    public function giftExcel(Request $request){
        $year = null;
        if(!$request->year){
            $today = DateConvert::toEthiopian(date('d/m/Y'));
            $year = explode("/", $today)[2];
        }
        else{
            $year = $request->year;
        }
        $start = explode('/', DateConvert::toGregorian('1/1/'. $year));
        $end = explode('/', DateConvert::toGregorian('1/1/'. ($year+1)));
        $gifts = Gift::whereBetween('donationDate', [Carbon::createFromDate($start[2], $start[1], $start[0]), Carbon::createFromDate($end[2], $end[1], $end[0])])->orderBy('valuation','desc')->get();
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . 'ናይ ' . $year . ' ውህብቶ ሪፖርት.xlsx"');
        header('Cache-Control: max-age=0');
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'ሽም ወሃቢ')
        ->setCellValue('B1', 'ኣድራሻ')
        ->setCellValue('C1', 'ዓይነት ውህብቶ')
        ->setCellValue('D1', 'ኩነታት')
        ->setCellValue('E1', 'ዝተኸፈለሉ ዕለት')
        ->setCellValue('F1', 'ግምት')
        ->setCellValue('G1', 'ርኢቶ');
        $i = 2;

        foreach ($gifts as $gift) {
              $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i , $gift->donor->donorName)
                ->setCellValue('B' . $i , $gift->donor->address)
                ->setCellValue('C' . $i , $gift->giftType)
                ->setCellValue('D' . $i , $gift->status)
                ->setCellValue('E' . $i , DateConvert::toEthiopian(date('d/m/Y',strtotime($gift->donationDate))))
                ->setCellValue('F' . $i , $gift->valuation)
                ->setCellValue('G' . $i , '');
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

    public function indexMewacho(Request $request){
        $zoneCode = Auth::user()->area;
        $zobadatas = null;
        $zoneName = null;
        $year = null;
        $month = null;
        $quarter = null;
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone && $request->zone !== '0'){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
            }
            else
                $zoneCode = $request->zone;
            if(!$request->year){
                $today = DateConvert::toEthiopian(date('d/m/Y'));
                $year = explode("/", $today)[2];
            }
            else{
                $year = $request->year;
            }
        }
        if($zoneCode === '0')
            $zoneName = 'ኩሎም';
        else
            $zoneName = DB::table('zobatats')->where('zoneCode', $zoneCode)->pluck('zoneName')->first();

        $mewacho_list = MewachoSetting::where('deadline', '>=', DateConvert::correctDate('1/11/'. ($year-1)))->where('deadline', '<', DateConvert::correctDate('1/11/'. $year))->get();

        $widabes = meseretawiWdabe::where('parentcode', 'LIKE', $zoneCode . '%')->select(['widabeName', 'widabeCode', 'type'])->get();
        $mewacho = [];
        foreach($widabes as $widabe){

            foreach ($mewacho_list as $m) {
                $row_mewacho = [$m->name, $widabe->widabeName, $m->purpose, $m->mtype, 0, 0, 0, 0, 0, ''];
                $occupation = null;
                // if($m->mtype == 'ደኣንት')
                //     $occupation = ['መፍረዪ', 'ንግዲ', 'ግልጋሎት', 'ኮስንትራክሽን', 'ከተማ ሕርሻ'];
                // else 
                    $occupation = [$m->mtype];
                $row_mewacho[4] = ApprovedHitsuy::where('assignedWudabe','=', $widabe->widabeCode)->whereIn('occupation', $occupation)->count();
                $query = DB::table("mewachos")
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'mewachos.hitsuyID')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->whereIn('approved_hitsuys.occupation', $occupation)
                ->where("mewachos.mewacho_id", $m->id);
                $row_mewacho[5] = $query->count();
                $row_mewacho[6] = $row_mewacho[4] - $row_mewacho[5];
                $row_mewacho[7] = $query->pluck('amount')->sum();
                $to_be_paid = DB::table('approved_hitsuys')
                ->join('mewacho_settings', 'approved_hitsuys.occupation', '=', 'mewacho_settings.mtype')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->whereIn('approved_hitsuys.occupation', $occupation)
                ->sum('mewacho_settings.amount');
                $row_mewacho[8] = $to_be_paid - $row_mewacho[7];
                $mewacho[] = $row_mewacho;
            }
        }
        return view('report.payment_mewacho', compact('zoneCode', 'zobadatas', 'year', 'mewacho'));
    }
    public function mewachoExcel(Request $request){
        $zoneCode = Auth::user()->area;
        $zobadatas = null;
        $zoneName = null;
        $year = null;
        $month = null;
        $quarter = null;
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone && $request->zone !== '0'){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
            }
            else
                $zoneCode = $request->zone;
            if(!$request->year){
                $today = DateConvert::toEthiopian(date('d/m/Y'));
                $year = explode("/", $today)[2];
            }
            else{
                $year = $request->year;
            }
        }
        if($zoneCode === '0')
            $zoneName = 'ኩሎም';
        else
            $zoneName = DB::table('zobatats')->where('zoneCode', $zoneCode)->pluck('zoneName')->first();

        $mewacho_list = MewachoSetting::where('deadline', '>=', DateConvert::correctDate('1/11/'. ($year-1)))->where('deadline', '<', DateConvert::correctDate('1/11/'. $year))->get();

        $widabes = meseretawiWdabe::where('parentcode', 'LIKE', $zoneCode . '%')->select(['widabeName', 'widabeCode', 'type'])->get();
        $mewacho = [];
        foreach($widabes as $widabe){

            foreach ($mewacho_list as $m) {
                $row_mewacho = [$m->name, $widabe->widabeName, $m->purpose, $m->mtype, 0, 0, 0, 0, 0, ''];
                $occupation = null;
                // if($m->mtype == 'ደኣንት')
                //     $occupation = ['መፍረዪ', 'ንግዲ', 'ግልጋሎት', 'ኮስንትራክሽን', 'ከተማ ሕርሻ'];
                // else 
                    $occupation = [$m->mtype];
                $row_mewacho[4] = ApprovedHitsuy::where('assignedWudabe','=', $widabe->widabeCode)->whereIn('occupation', $occupation)->count();
                $query = DB::table("mewachos")
                ->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'mewachos.hitsuyID')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->whereIn('approved_hitsuys.occupation', $occupation)
                ->where("mewachos.mewacho_id", $m->id);
                $row_mewacho[5] = $query->count();
                $row_mewacho[6] = $row_mewacho[4] - $row_mewacho[5];
                $row_mewacho[7] = $query->pluck('amount')->sum();
                $to_be_paid = DB::table('approved_hitsuys')
                ->join('mewacho_settings', 'approved_hitsuys.occupation', '=', 'mewacho_settings.mtype')
                ->where('approved_hitsuys.assignedWudabe','=', $widabe->widabeCode)
                ->whereIn('approved_hitsuys.occupation', $occupation)
                ->sum('mewacho_settings.amount');
                $row_mewacho[8] = $to_be_paid - $row_mewacho[7];
                $mewacho[] = $row_mewacho;
            }
        }
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . 'ናይ ' . $year . ' መዋጮ ሪፖርት ' . $zobadatas[$zoneCode] . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'ሽም መዋጮ')
        ->setCellValue('B1', 'መሰረታዊ ውዳበ')
        ->setCellValue('C1', 'ዕላማ')
        ->setCellValue('D1', 'ዓይነት ኣባላት')
        ->setCellValue('E1', 'በዝሒ ኣባላት')
        ->setCellValue('F1', 'ዝኸፈሉ')
        ->setCellValue('G1', 'ዘይኸፈሉ')
        ->setCellValue('H1', 'ድምር ክፍሊት')
        ->setCellValue('I1', 'ዘይተኸፈለ መጠን')
        ->setCellValue('J1', 'ሪኢቶ');
        $i = 2;

        foreach ($mewacho as $row) {
              $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i , $row[0])
                ->setCellValue('B' . $i , $row[1])
                ->setCellValue('C' . $i , $row[2])
                ->setCellValue('D' . $i , $row[3])
                ->setCellValue('E' . $i , $row[4])
                ->setCellValue('F' . $i , $row[5])
                ->setCellValue('G' . $i , $row[6])
                ->setCellValue('H' . $i , round($row[7], 2))
                ->setCellValue('I' . $i , round($row[8], 2))
                ->setCellValue('J' . $i , $row[9]);
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
