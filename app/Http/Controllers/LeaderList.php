<?php

namespace App\Http\Controllers;

require_once substr(dirname(__FILE__), 0, -17).'\PHPExcel-1.8\Classes\PHPExcel.php';

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
// use PHPExcel_Style_Borders;
use PHPExcel_Shared_Font;

use App\DateConvert;

use  App\Hitsuy;
use  App\ApprovedHitsuy;
use  App\NotyetHitsuy;
use  App\RejectedHitsuy;
use  App\CareerInformation;
use App\meseretawiWdabe;
use App\Wahio;
use App\Zobatat;
use App\Woreda;
use App\Tabia;
use App\Constant;
use App\Filter;
use DB;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;


use Carbon\Carbon;

class LeaderList extends Controller
{
    public function index(Request $request){

        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];

        $leader_types = ['ኩሎም', 'ጀማሪ ኣመራርሓ', 'ማእኸላይ ኣመራርሓ', 'ላዕለዋይ ኣመራርሓ', 'ታሕተዋይ ኣመራርሓ'];
        $show = $request->show ? ($request->show == 'ኩሎም'? $leader_types: [$request->show]) : $leader_types;
        $show_name = $request->show ? $request->show : 'ኩሎም';
        if($request->show == 'ታሕተዋይ ኣመራርሓ'){
            $show[] = 'መ/ዉ/አመራርሓ';
            $show[] = 'ዋህዮ ኣመራርሓ';
        }
        
        $query = ApprovedHitsuy::where('zoneworedaCode','LIKE', $filter['new_value'] . '%')->where('approved_status','1')->whereIn('memberType', $show);
        if($filter['widabe']){
            $query = $query->where('assignedWudabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('assignedWahio', $filter['wahio']->id);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view('membership.leaderlist', compact('data','zobadatas', 'leader_types', 'show', 'show_name', 'zoneCode', 'filter'));
    }
    public function leaderListExcel(Request $request)
    {
        $leader_types = ['ኩሎም', 'ጀማሪ ኣመራርሓ', 'ማእኸላይ ኣመራርሓ', 'ላዕለዋይ ኣመራርሓ', 'ታሕተዋይ ኣመራርሓ'];
        $show = $request->show ? ($request->show == 'ኩሎም'? $leader_types: [$request->show]) : $leader_types;
        $show_name = $request->show ? $request->show : 'ኩሎም';
        if($request->show == 'ታሕተዋይ ኣመራርሓ'){
            $show[] = 'መ/ዉ/አመራርሓ';
            $show[] = 'ዋህዮ ኣመራርሓ';
        }
        $value = Auth::user()->area;
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $value = '__'.$value;
        }
        $zoneCode = Auth::user()->area;
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone && $request->zone !== '0'){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
                $value = $zoneCode;
            }
            else{
                $zoneCode = $request->zone;
                $value = $zoneCode;
            }
            if($request->zone === '0'){
                $value = '_____';
            }
        }
        if($zoneCode === '0')
            $zoneName = 'ኩሎም';
        else
            $zoneName = DB::table('zobatats')->where('zoneCode', $zoneCode)->pluck('zoneName')->first();
        $data = ApprovedHitsuy::where('zoneworedaCode','LIKE', $value.'%')->where('approved_status','1')->whereIn('memberType', $show)->get();
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $today = DateConvert::toEthiopian(date('d/m/Y'));
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $zoneName . '_' . $show_name . ' ኣመራርሓ_' . explode("/", $today)[2] . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'መ.ቑ')
            ->setCellValue('B1', 'ሽም ኣባል')
            ->setCellValue('C1', 'ፆታ')
            ->setCellValue('D1', 'ዕድመ')
            ->setCellValue('E1', 'ትውልዲ ዓዲ')
            ->setCellValue('F1', 'ኣባል ዝኾነሉ ዕለት')
            ->setCellValue('G1', 'ስራሕ')
            ->setCellValue('H1', 'ሓላፍነት')
            ->setCellValue('I1', 'ዝተወደበሉ ማሕበር')
            ->setCellValue('J1', 'ኩነታት መሪሕነት')
            ->setCellValue('K1', 'ዝተፃረየ ወርሓዊ መሃያ');
        $i = 2;

        foreach ($data as $mydata) {
              $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i , $mydata->hitsuyID)
                ->setCellValue('B' . $i , $mydata->hitsuy->name . ' ' . $mydata->hitsuy->fname . ' ' . $mydata->hitsuy->gfname)
                ->setCellValue('C' . $i , $mydata->hitsuy->gender)
                ->setCellValue('D' . $i , (date('Y') - date('Y',strtotime($mydata->hitsuy->dob))))
                ->setCellValue('E' . $i , $mydata->hitsuy->birthPlace)
                ->setCellValue('F' . $i , DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->membershipDate))))
                ->setCellValue('G' . $i , $mydata->hitsuy->occupation)
                ->setCellValue('H' . $i , $mydata->hitsuy->position)
                ->setCellValue('I' . $i , $mydata->assignedAssoc)
                ->setCellValue('J' . $i , $mydata->memberType)
                ->setCellValue('K' . $i , $mydata->netSalary);
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
