<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

require_once substr(dirname(__FILE__), 0, -17).'\PHPExcel-1.8\Classes\PHPExcel.php';

use PHPExcel;
use PHPExcel_IOFactory;

use  App\Zobatat;
use  App\Woreda; 
use  App\Tabia;
use  App\Wahio;
use  App\meseretawiWdabe;
use  App\ApprovedHitsuy;
use  App\Hitsuy;
use DB;

class SixMonthReportExcelController extends Controller
{
    private function loadData($zoneCode, $zCode){
        if($zoneCode == 'all'){
            $zoneName = '(ኩሎም)';
            $woredas = Woreda::select(['woredaCode', 'isUrban', 'name'])->get()->toArray();
        }
        else{
            $zoneName = Zobatat::where('zoneCode', $zoneCode)->select(['zoneName'])->first()->toArray()['zoneName'];
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
        return [$zoneName, $ketemageter, $ketemageterwidabe, $geterwidabe, $ketemawidabe, $deant];
    }
    public function index(Request $request)
    {
        $zoneCode = $request->zoneCode;
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
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $zoneName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $data = $this->loadData($zoneCode, $zCode);
        $objPHPExcel = new PHPExcel();

        // ketema geter
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '2011 ዓ/ም ናይ ዞባታት ገጠርን ከተማን ኣባል ውድብ /ዞባ '.$data[0])
            ->setCellValue('B2', 'ገጠር')
            ->setCellValue('E2', 'ከተማ')
            ->setCellValue('H2', 'ጠ/ድምር')
            ->setCellValue('A2', 'ወረዳ')
            ->setCellValue('B3', 'ተባ')
            ->setCellValue('C3', 'ኣን')
            ->setCellValue('D3', 'ድምር')
            ->setCellValue('E3', 'ተባ')
            ->setCellValue('F3', 'ኣን')
            ->setCellValue('G3', 'ድምር')
            ->setCellValue('H3', 'ተባ')
            ->setCellValue('I3', 'ኣን')
            ->setCellValue('J3', 'ድምር')
            ->mergeCells('A1:J1')
            ->mergeCells('A2:A3')
            ->mergeCells('B2:D2')
            ->mergeCells('E2:G2')
            ->mergeCells('H2:J2');
        $i = 4;
        foreach ($data[1] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        //Ketema Geter widabe
        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ገጠርን ከተማ ውዳበ ዞባ '.$data[0])
            ->mergeCells('A'.$i.':V'.$i)
            ->setCellValue('B'.($i+1), 'ገባር')
            ->setCellValue('E'.($i+1), 'ደኣንት')
            ->setCellValue('H'.($i+1), 'ሲ/ሰርቫንት')
            ->setCellValue('K'.($i+1), 'መምህራን')
            ->setCellValue('N'.($i+1), 'ተምሃሮ')
            ->setCellValue('Q'.($i+1), 'ሸቃሎ')
            ->setCellValue('T'.($i+1), 'ድምር')
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+2), 'ተባ')
            ->setCellValue('C'.($i+2), 'ኣን')
            ->setCellValue('D'.($i+2), 'ድምር')
            ->setCellValue('E'.($i+2), 'ተባ')
            ->setCellValue('F'.($i+2), 'ኣን')
            ->setCellValue('G'.($i+2), 'ድምር')
            ->setCellValue('H'.($i+2), 'ተባ')
            ->setCellValue('I'.($i+2), 'ኣን')
            ->setCellValue('J'.($i+2), 'ድምር')
            ->setCellValue('H'.($i+2), 'ተባ')
            ->setCellValue('I'.($i+2), 'ኣን')
            ->setCellValue('J'.($i+2), 'ድምር')
            ->setCellValue('K'.($i+2), 'ተባ')
            ->setCellValue('L'.($i+2), 'ኣን')
            ->setCellValue('M'.($i+2), 'ድምር')
            ->setCellValue('N'.($i+2), 'ተባ')
            ->setCellValue('O'.($i+2), 'ኣን')
            ->setCellValue('P'.($i+2), 'ድምር')
            ->setCellValue('Q'.($i+2), 'ተባ')
            ->setCellValue('R'.($i+2), 'ኣን')
            ->setCellValue('S'.($i+2), 'ድምር')
            ->setCellValue('T'.($i+2), 'ተባ')
            ->setCellValue('U'.($i+2), 'ኣን')
            ->setCellValue('V'.($i+2), 'ድምር')
            ->mergeCells('A'.($i+1).':A'.($i+2))
            ->mergeCells('B'.($i+1).':D'.($i+1))
            ->mergeCells('E'.($i+1).':G'.($i+1))
            ->mergeCells('H'.($i+1).':J'.($i+1))
            ->mergeCells('K'.($i+1).':M'.($i+1))
            ->mergeCells('N'.($i+1).':P'.($i+1))
            ->mergeCells('K'.($i+1).':M'.($i+1))
            ->mergeCells('N'.($i+1).':P'.($i+1))
            ->mergeCells('Q'.($i+1).':S'.($i+1))
            ->mergeCells('T'.($i+1).':V'.($i+1));

        $i += 3;
        foreach ($data[2] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }

        //Geter widabe
        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ገጠር ውዳበ ዞባ '.$data[0])
            ->mergeCells('A'.$i.':P'.$i)
            ->setCellValue('B'.($i+1), 'ገባር')
            ->setCellValue('E'.($i+1), 'ሲ/ሰርቫንት')
            ->setCellValue('H'.($i+1), 'መምህራን')
            ->setCellValue('K'.($i+1), 'ተምሃሮ')
            ->setCellValue('N'.($i+1), 'ድምር')
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+2), 'ተባ')
            ->setCellValue('C'.($i+2), 'ኣን')
            ->setCellValue('D'.($i+2), 'ድምር')
            ->setCellValue('E'.($i+2), 'ተባ')
            ->setCellValue('F'.($i+2), 'ኣን')
            ->setCellValue('G'.($i+2), 'ድምር')
            ->setCellValue('H'.($i+2), 'ተባ')
            ->setCellValue('I'.($i+2), 'ኣን')
            ->setCellValue('J'.($i+2), 'ድምር')
            ->setCellValue('H'.($i+2), 'ተባ')
            ->setCellValue('I'.($i+2), 'ኣን')
            ->setCellValue('J'.($i+2), 'ድምር')
            ->setCellValue('K'.($i+2), 'ተባ')
            ->setCellValue('L'.($i+2), 'ኣን')
            ->setCellValue('M'.($i+2), 'ድምር')
            ->setCellValue('N'.($i+2), 'ተባ')
            ->setCellValue('O'.($i+2), 'ኣን')
            ->setCellValue('P'.($i+2), 'ድምር')
            ->mergeCells('A'.($i+1).':A'.($i+2))
            ->mergeCells('B'.($i+1).':D'.($i+1))
            ->mergeCells('E'.($i+1).':G'.($i+1))
            ->mergeCells('H'.($i+1).':J'.($i+1))
            ->mergeCells('K'.($i+1).':M'.($i+1))
            ->mergeCells('N'.($i+1).':P'.($i+1));

        $i += 3;
        foreach ($data[3] as $a) {
              for ($b=0;$b<count($a);$b++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
              }
              $i++;
        }


        //Ketema widabe
        $i += 2;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ከተማ ውድብ ዞባ '.$data[0])
            ->mergeCells('A'.$i.':N'.$i)
            ->setCellValue('B'.($i+1), 'ደኣንት')
            ->setCellValue('E'.($i+1), 'ሸቃሎ')
            ->setCellValue('H'.($i+1), 'ሰብ ሞያ')
            ->setCellValue('K'.($i+1), 'መምህራን')
            ->setCellValue('N'.($i+1), 'ተምሃሮ')
            ->setCellValue('Q'.($i+1), 'ድምር')
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+2), 'ተባ')
            ->setCellValue('C'.($i+2), 'ኣን')
            ->setCellValue('D'.($i+2), 'ድምር')
            ->setCellValue('E'.($i+2), 'ተባ')
            ->setCellValue('F'.($i+2), 'ኣን')
            ->setCellValue('G'.($i+2), 'ድምር')
            ->setCellValue('H'.($i+2), 'ተባ')
            ->setCellValue('I'.($i+2), 'ኣን')
            ->setCellValue('J'.($i+2), 'ድምር')
            ->setCellValue('H'.($i+2), 'ተባ')
            ->setCellValue('I'.($i+2), 'ኣን')
            ->setCellValue('J'.($i+2), 'ድምር')
            ->setCellValue('K'.($i+2), 'ተባ')
            ->setCellValue('L'.($i+2), 'ኣን')
            ->setCellValue('M'.($i+2), 'ድምር')
            ->setCellValue('N'.($i+2), 'ተባ')
            ->setCellValue('O'.($i+2), 'ኣን')
            ->setCellValue('P'.($i+2), 'ድምር')
            ->setCellValue('Q'.($i+2), 'ተባ')
            ->setCellValue('R'.($i+2), 'ኣን')
            ->setCellValue('S'.($i+2), 'ድምር')
            ->mergeCells('A'.($i+1).':A'.($i+2))
            ->mergeCells('B'.($i+1).':D'.($i+1))
            ->mergeCells('E'.($i+1).':G'.($i+1))
            ->mergeCells('H'.($i+1).':J'.($i+1))
            ->mergeCells('K'.($i+1).':M'.($i+1))
            ->mergeCells('N'.($i+1).':P'.($i+1))
            ->mergeCells('Q'.($i+1).':S'.($i+1));

            $i += 3;
            foreach ($data[4] as $a) {
                  for ($b=0;$b<count($a);$b++) {
                        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
                  }
                  $i++;
            }


            //Deant
            $i += 2;
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, 'ደኣንት ዞባ ' . $data[0] .' ብማሕበራዊ ቦታ')
            ->mergeCells('A'.$i.':N'.$i)
            ->setCellValue('B'.($i+1), 'መፍረይቲ')
            ->setCellValue('E'.($i+1), 'ከ/ሕርሻ')
            ->setCellValue('H'.($i+1), 'ኮንስትራክሽን')
            ->setCellValue('K'.($i+1), 'ንግዲ')
            ->setCellValue('N'.($i+1), 'ግልጋሎት')
            ->setCellValue('Q'.($i+1), 'ድምር')
            ->setCellValue('A'.($i+1), 'ወረዳ')
            ->setCellValue('B'.($i+2), 'ተባ')
            ->setCellValue('C'.($i+2), 'ኣን')
            ->setCellValue('D'.($i+2), 'ድምር')
            ->setCellValue('E'.($i+2), 'ተባ')
            ->setCellValue('F'.($i+2), 'ኣን')
            ->setCellValue('G'.($i+2), 'ድምር')
            ->setCellValue('H'.($i+2), 'ተባ')
            ->setCellValue('I'.($i+2), 'ኣን')
            ->setCellValue('J'.($i+2), 'ድምር')
            ->setCellValue('H'.($i+2), 'ተባ')
            ->setCellValue('I'.($i+2), 'ኣን')
            ->setCellValue('J'.($i+2), 'ድምር')
            ->setCellValue('K'.($i+2), 'ተባ')
            ->setCellValue('L'.($i+2), 'ኣን')
            ->setCellValue('M'.($i+2), 'ድምር')
            ->setCellValue('N'.($i+2), 'ተባ')
            ->setCellValue('O'.($i+2), 'ኣን')
            ->setCellValue('P'.($i+2), 'ድምር')
            ->setCellValue('Q'.($i+2), 'ተባ')
            ->setCellValue('R'.($i+2), 'ኣን')
            ->setCellValue('S'.($i+2), 'ድምር')
            ->mergeCells('A'.($i+1).':A'.($i+2))
            ->mergeCells('B'.($i+1).':D'.($i+1))
            ->mergeCells('E'.($i+1).':G'.($i+1))
            ->mergeCells('H'.($i+1).':J'.($i+1))
            ->mergeCells('K'.($i+1).':M'.($i+1))
            ->mergeCells('N'.($i+1).':P'.($i+1))
            ->mergeCells('Q'.($i+1).':S'.($i+1));

            $i += 3;
            foreach ($data[5] as $a) {
                  for ($b=0;$b<count($a);$b++) {
                        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue(chr(65+$b).(string)$i, $a[$b]);
                  }
                  $i++;
            }



        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        // $objWriter->save(public_path('Nigga.xlsx'));
    }
}
