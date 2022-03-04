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

class HitsuyMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        // $data = Hitsuy::whereIn('hitsuy_status',['ሕፁይ','ሕፁይነት ተናዊሑ','ሕፁይነት ተሰሪዙ'])->where('hitsuyID', 'LIKE', $value.'%')/*->where('regDate','<',Carbon::now()->subMonths(6))*/->orderBy('regDate','asc')->paginate(Constant::PAGE_SIZE);
        $query = Hitsuy::where('hitsuyID','LIKE', $filter['new_value'] . '%')->whereIn('hitsuy_status', ['ሕፁይ','ሕፁይነት ተናዊሑ','ሕፁይነት ተሰሪዙ'])/*->where('regDate','<',Carbon::now()->subMonths(6))*/->orderBy('regDate','asc');
        if($filter['widabe']){
            $query = $query->where('proposerWidabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('proposerWahio', $filter['wahio']->id);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view ( 'membership.membership' , compact('data', 'zoneCode', 'zobadatas', 'filter'));
    }
    public function listMembers(Request $request)
    {
        //
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $query = ApprovedHitsuy::where('zoneworedaCode','LIKE', $filter['new_value'] . '%')->where('approved_status','1');
        if($filter['widabe']){
            $query = $query->where('assignedWudabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('assignedWahio', $filter['wahio']->id);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view('membership.memberlist',compact('data', 'zoneCode', 'filter', 'zobadatas'));
    }
    public function listMembersExcel()
    {
        $value = Auth::user()->area;
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $value = '__'.$value;
        }
        $data = ApprovedHitsuy::where('zoneworedaCode','LIKE', $value.'%')->where('approved_status','1')->get();
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $zoneCode = Auth::user()->area;
        $today = DateConvert::toEthiopian(date('d/m/Y'));
        if(Auth::user()->usertype == 'admin'){
            $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
        }
        $zoneName = Zobatat::where('zoneCode', $zoneCode)->select(['zoneName'])->first()->toArray()['zoneName'];
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $zoneName . '_' . explode("/", $today)[2] . '_ኣባላት.xlsx"');
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
        ->setCellValue('J1', 'ዓይነት ኣባል')
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
                ->setCellValue('J' . $i , $mydata->membershipType)
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
    public function listDismissed(Request $request)
    {
        //
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $query = ApprovedHitsuy::where('zoneworedaCode','LIKE', $filter['new_value'] . '%')->where('approved_status','ዝተሰናበተ');
        if($filter['widabe']){
            $query = $query->where('assignedWudabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('assignedWahio', $filter['wahio']->id);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view('membership.dismissedlist',compact('data', 'zoneCode', 'filter', 'zobadatas'));
    }
    public function listDismissedExcel()
    {
        $value = Auth::user()->area;
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $value = '__'.$value;
        }
        $data = ApprovedHitsuy::where('zoneworedaCode','LIKE', $value.'%')->where('approved_status','ዝተሰናበተ')->get();
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $zoneCode = Auth::user()->area;
        $today = DateConvert::toEthiopian(date('d/m/Y'));
        if(Auth::user()->usertype == 'admin'){
            $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
        }
        $zoneName = Zobatat::where('zoneCode', $zoneCode)->select(['zoneName'])->first()->toArray()['zoneName'];
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $zoneName . '_' . explode("/", $today)[2] . '_ኣባላት.xlsx"');
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
        ->setCellValue('J1', 'ዓይነት ኣባል')
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
                ->setCellValue('J' . $i , $mydata->membershipType)
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
    public function wahioleadersindex()
    {
        //
        $data = ApprovedHitsuy::where('approved_status','1')->get();      
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view ('leadership.wahioleaders',compact('data','zobadatas'));        
    }
    public function meseretawileadersindex()
    {
        //
        $data = ApprovedHitsuy::where('approved_status','1')->get();      
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view ('leadership.meseretawileaders',compact('data','zobadatas'));        
    }
    public function listHitsuy(Request $request)
    {
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $query = Hitsuy::where('hitsuyID','LIKE', $filter['new_value'] . '%')->whereIn('hitsuy_status', ['ሕፁይ','ሕፁይነት ተናዊሑ','ሕፁይነት ተሰሪዙ'])/*->where('regDate','<',Carbon::now()->subMonths(6))*/->orderBy('regDate','asc');
        if($filter['widabe']){
            $query = $query->where('proposerWidabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('proposerWahio', $filter['wahio']->id);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view ('membership.hitsuylist',compact('data','zoneCode', 'filter', 'zobadatas'));
    }

    public function listHitsuyExcel()
    {
        $value = Auth::user()->area;
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $value = '__'.$value;
        }
        $data = Hitsuy::whereIn('hitsuy_status',['ሕፁይ', 'ሕፁይነት ተናዊሑ', 'ሕፁይነት ተሰሪዙ'])->where('hitsuyID', 'LIKE', $value.'%')->get();
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $zoneCode = Auth::user()->area;
        $today = DateConvert::toEthiopian(date('d/m/Y'));
        if(Auth::user()->usertype == 'admin'){
            $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
        }
        $zoneName = Zobatat::where('zoneCode', $zoneCode)->select(['zoneName'])->first()->toArray()['zoneName'];
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $zoneName . '_' . explode("/", $today)[2] . '_ሕፁያት.xlsx"');
        header('Cache-Control: max-age=0');
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'መ.ቑ')
            ->setCellValue('B1', 'ሽም ሕፁይ')
            ->setCellValue('C1', 'ፆታ')
            ->setCellValue('D1', 'ዕድመ')
            ->setCellValue('E1', 'ትውልዲ ዓዲ')
            ->setCellValue('F1', 'ዝተመልመለሉ ዕለት')
            ->setCellValue('G1', 'ኩነታት ሕፁይነት')
            ->setCellValue('H1', 'ስራሕ')
            ->setCellValue('I1', 'ሓላፍነት');
        $i = 2;

        foreach ($data as $mydata) {
              $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i , $mydata->hitsuyID)
                ->setCellValue('B' . $i , $mydata->name . $mydata->fname . $mydata->gfname)
                ->setCellValue('C' . $i , $mydata->gender)
                ->setCellValue('D' . $i , (date('Y') - date('Y',strtotime($mydata->dob)))-8)
                ->setCellValue('E' . $i , $mydata->birthPlace)
                ->setCellValue('F' . $i , DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->regDate))))
                ->setCellValue('G' . $i , $mydata->hitsuy_status)
                ->setCellValue('H' . $i , $mydata->occupation)
                ->setCellValue('I' . $i , $mydata->position);
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
    public function listRemoved(Request $request)
    {
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $query = Hitsuy::where('hitsuyID','LIKE', $filter['new_value'] . '%')->whereIn('hitsuy_status', ['ሕፁይነት ተሰሪዙ'])/*->where('regDate','<',Carbon::now()->subMonths(6))*/->orderBy('regDate','asc');
        if($filter['widabe']){
            $query = $query->where('proposerWidabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('proposerWahio', $filter['wahio']->id);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view ('membership.removedlist',compact('data','zoneCode', 'filter', 'zobadatas'));
    }
    public function listRemovedExcel()
    {
        $value = Auth::user()->area;
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $value = '__'.$value;
        }
        $data = Hitsuy::whereIn('hitsuy_status',['ሕፁይነት ተሰሪዙ'])->where('hitsuyID', 'LIKE', $value.'%')->get();
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $zoneCode = Auth::user()->area;
        $today = DateConvert::toEthiopian(date('d/m/Y'));
        if(Auth::user()->usertype == 'admin'){
            $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
        }
        $zoneName = Zobatat::where('zoneCode', $zoneCode)->select(['zoneName'])->first()->toArray()['zoneName'];
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $zoneName . '_' . explode("/", $today)[2] . '_ሕፁያት.xlsx"');
        header('Cache-Control: max-age=0');
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'መ.ቑ')
            ->setCellValue('B1', 'ሽም ሕፁይ')
            ->setCellValue('C1', 'ፆታ')
            ->setCellValue('D1', 'ዕድመ')
            ->setCellValue('E1', 'ትውልዲ ዓዲ')
            ->setCellValue('F1', 'ዝተመልመለሉ ዕለት')
            ->setCellValue('G1', 'ኩነታት ሕፁይነት')
            ->setCellValue('H1', 'ስራሕ')
            ->setCellValue('I1', 'ሓላፍነት');
        $i = 2;

        foreach ($data as $mydata) {
              $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i , $mydata->hitsuyID)
                ->setCellValue('B' . $i , $mydata->name . $mydata->fname . $mydata->gfname)
                ->setCellValue('C' . $i , $mydata->gender)
                ->setCellValue('D' . $i , (date('Y') - date('Y',strtotime($mydata->dob)))-8)
                ->setCellValue('E' . $i , $mydata->birthPlace)
                ->setCellValue('F' . $i , DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->regDate))))
                ->setCellValue('G' . $i , $mydata->hitsuy_status)
                ->setCellValue('H' . $i , $mydata->occupation)
                ->setCellValue('I' . $i , $mydata->position);
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //add ApprovedHitsuy
        $validator = \Validator::make($request->all(), [
            'hitsuyID' => 'required',
            'membershipDate' => 'required|ethiopian_date',
            // 'membershipType' => 'required|in:ተጋዳላይ,ሲቪል',
            // 'grossSalary' => 'numeric',
            'netSalary' => 'numeric',
            'assignedWudabe' => 'required',
            'assignedWahio' => 'required',
            'assignedAssoc' => 'required',
            // 'fileNumber' => 'required',
            'isReported' => 'required',
            'hasRequested' => 'required',
            'isApproved' => 'required',
            ],
            [
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ'
            ]);
        $fieldNames = [
        "hitsuyID" => "መለለዩ ሕፁይ",
        "membershipDate" => "ኣባል ዝኾነሉ ዕለት",
        "membershipType" => "ዓይነት ኣባል",
        "grossSalary" => "ጠቕላላ ደሞዝ",
        'netSalary' => 'ዝተፃረየ ደሞዝ',
        'assignedWudabe' => 'ዝተወደበሉ መሰረታዊ ውዳበ',
        'assignedWahio' => 'ዝተወደበሉ ዋህዮ',
        'assignedAssoc' => 'ዝተወደበሉ ማሕበር',
        'fileNumber' => 'ቑፅሪ ሰነድ',
        'isReported' => 'ሪፖርት ቐሪቡ',
        'hasRequested' => 'ሕፁይ ሓቲቱ',
        'isApproved' => 'ፀዲቑ'];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        foreach ($request->assignedAssoc as $assoc){
            if(array_search($assoc, ['ደቂ ኣንስትዮ', 'ሓረስታይ', 'መንእሰይ', 'ጉድኣት ኩናት', 'ተጋደልቲ', 'ደቂ ስውኣት', 'ሊግ መንእሰይ', 'ሊግ ደቂ ኣነስትዮ', 'መምህራን']) === false){
                return [false, 'error', 'ውዳበ '. $assoc. ' ኣይፍለጥን'];
            }
        }
        if(!Hitsuy::where('hitsuyID', $request->hitsuyID)->count()){
            $validator->errors()->add('duplicate', 'ሕፁይ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        if(!meseretawiWdabe::where('widabeCode',$request->assignedWudabe)->count()){
            $validator->errors()->add('duplicate', 'መሰረታዊ ውዳበ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];   
        }
        if(!Wahio::where('id',$request->assignedWahio)->count()){
            $validator->errors()->add('duplicate', 'ዋህዮ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];   
        }
        if(ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->count()){
            $validator->errors()->add('duplicate', 'ኣባል ኣብ መዝገብ ኣሎ።<br>በይዝኦም ንኣድሚንስትሬተር የዘራርቡ');
            return [false, 'error', $validator->errors()->all()];
        }
        $apprMem = new ApprovedHitsuy;
        $apprMem->hitsuyID = $request->hitsuyID;        
        $apprMem->membershipDate = DateConvert::correctDate($request->membershipDate);
        $apprMem->membershipType = 'ሲቪል';

        $hitsuyoccup = Hitsuy::where('hitsuyID',$request->hitsuyID)->orderBy('updated_at', 'desc')->pluck('occupation')->first();
        if($hitsuyoccup=='መምህራን'||$hitsuyoccup=='ሰብ ሞያ'){
            if(!$request->netSalary){
                $validator->errors()->add('duplicate', 'ዝተፃረየ ደሞዝ ኣይተመልአን');
                return [false, 'error', $validator->errors()->all()];          
            }
        }
        if($hitsuyoccup=="ሰብ ሞያ"||$hitsuyoccup=="ሲቪል ሰርቫንት"){
            $apprMem->memberType = "ሰብ ሞያ";
        }
        
        $zoneworedaCodeVal = substr($request->hitsuyID,0, 9);
        // $zoneworedaCodeVal=intval($zoneworedaCodeVal);

        $apprMem->gender = Hitsuy::where('hitsuyID',$request->hitsuyID)->orderBy('updated_at', 'desc')->pluck('gender')->first();
        $apprMem->occupation = Hitsuy::where('hitsuyID',$request->hitsuyID)->orderBy('updated_at', 'desc')->pluck('occupation')->first();

        $apprMem->zoneworedaCode = $zoneworedaCodeVal;
       
        if(!$request->netSalary)
		{
            $apprMem->netSalary = 0;
			$apprMem->grossSalary = 0;
		}
        else
		{
         $apprMem->netSalary = $request->netSalary;
		 $apprMem->grossSalary = $request->netSalary;
		}
		 
        $apprMem->assignedWudabe = $request->assignedWudabe;
        $apprMem->wudabeType = meseretawiWdabe::where('widabeCode', $request->assignedWudabe)->pluck('type')->first();
        $apprMem->assignedWahio = $request->assignedWahio;
        $apprMem->assignedAssoc = join(',', $request->assignedAssoc);
        $apprMem->fileNumber = '';
        $apprMem->isReported = $request->isReported;
        $apprMem->hasRequested = $request->hasRequested;
        $apprMem->isApproved = $request->isApproved;        
        $apprMem->save();   

        //update Hitsuy
        $updHist = Hitsuy::find ( $request->hitsuyID );
        $updHist->hitsuy_status ='ኣባል';
        $updHist->save(); 
        return [true, "info", "ኣባልነት ብትክክል ፀዲቑ ኣሎ"];
                
    }
    public function editMember(Request $request)
    {
        //add ApprovedHitsuy
        $validator = \Validator::make($request->all(), [
            'hitsuyID' => 'required',
            'name' =>'required|alpha',
            'fname' =>'required|alpha',
            'gfname' =>'required|alpha',
            'dob' =>'required|ethiopian_date',
            'gender' => 'required|in:ተባ,ኣን',
            'membershipDate' => 'required|ethiopian_date',
            'membershipType' => 'required|in:ተጋዳላይ,ሲቪል',
            'grossSalary' => 'numeric',
            'netSalary' => 'required|numeric',
            'assignedAssoc' => 'required',
            'fileNumber' => '',
            ],
            [
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ'
            ]);
        $fieldNames = [
        "hitsuyID" => "መለለዩ ሕፁይ",
        'name' =>'ሽም',
        'fname' =>'ሽም ኣቦ',
        'gfname' =>'ሽም ኣቦ ሓጎ',
        'dob' =>'ዝተወለደሉ ዕለት',
        'gender' => 'ፆታ',
        'assignedAssoc' => 'ዝተወደበሉ ማሕበር',
        "membershipDate" => "ኣባል ዝኾነሉ ዕለት",
        "membershipType" => "ዓይነት ኣባል",
        "grossSalary" => "ጠቕላላ ደሞዝ",
        'netSalary' => 'ዝተፃረየ ደሞዝ',
        'fileNumber' => 'ቑፅሪ ሰነድ'];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->count()){
            $validator->errors()->add('duplicate', 'ኣባል ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        foreach ($request->assignedAssoc as $assoc){
            if(array_search($assoc, ['ደቂ ኣንስትዮ', 'ሓረስታይ', 'መንእሰይ', 'ጉድኣት ኩናት', 'ተጋደልቲ', 'ደቂ ስውኣት', 'ሊግ መንእሰይ', 'ሊግ ደቂ ኣነስትዮ', 'መምህራን']) === false){
                return [false, 'error', 'ውዳበ '. $assoc. ' ኣይፍለጥን'];
            }
        }
        ApprovedHitsuy::where('hitsuyID',$request->hitsuyID)->update(['membershipDate' => DateConvert::correctDate($request->membershipDate),'membershipType' => $request->membershipType, 'gender' => $request->gender, 'grossSalary' => $request->grossSalary,'netSalary' => $request->netSalary,'fileNumber' => $request->fileNumber, 'assignedAssoc' => join(',', $request->assignedAssoc)]);
        Hitsuy::where('hitsuyID',$request->hitsuyID)->update(['dob' => DateConvert::correctDate($request->dob), 'gender' => $request->gender, 'name' => $request->name,'fname' => $request->fname,'gfname' => $request->gfname]);
        return [true, "info", "ኣባል ተስተኻኺሉ ኣሎ"];
                
    }
    
    public function postponeHitsuy(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'hitsuyID' => 'required',
            'postponedDate' => 'required|ethiopian_date'],
            [
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን',]);
        $fieldNames = [
        "hitsuyID1" => "መለለዩ ሕፁይ",
        "postponedDate" => "ዝተናውሐሉ ዕለት",];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!Hitsuy::where('hitsuyID', $request->hitsuyID)->count()){
            $validator->errors()->add('duplicate', 'ሕፁይ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        //add NotyetHitsuy

        $postMem = new NotyetHitsuy;
        $postMem->hitsuyID = $request->hitsuyID; 
        $postMem->postponedDate = DateConvert::correctDate($request->postponedDate);
        $postMem->save();   

        //update Hitsuy
        $updHist = Hitsuy::find ( $request->hitsuyID );
        $updHist->hitsuy_status ='ሕፁይነት ተናዊሑ';
        $updHist->save(); 

        return [true, "info", "ሕፁይነት ብትክክል ተናዊሑ ኣሎ"];
    }

    public function rejectHitsuy(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'hitsuyID' => 'required',
            'rejectionReason' => 'required',
            'rejectionDate' => 'required|ethiopian_date'
        ],[
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን'
        ]);
        $fieldNames = [
        "hitsuyID2" => "መለለዩ ሕፁይ",
        "rejectionReason" => "ዝተሰረዘሉ ምኽንያት",
        "rejectionDate" => "ዝተሰረዘሉ ዕለት"];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!Hitsuy::where('hitsuyID', $request->hitsuyID)->count()){
            $validator->errors()->add('duplicate', 'ሕፁይ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        //add rejected
        $rejMem = new RejectedHitsuy;
        $rejMem->hitsuyID = $request->hitsuyID;        
        $rejMem->rejectionReason = $request->rejectionReason;
        $rejMem->rejectionDate = DateConvert::correctDate($request->rejectionDate);
        $rejMem->save();

        //update Hitsuy
        $updHist = Hitsuy::find( $request->hitsuyID );
        $updHist->hitsuy_status ='ሕፁይነት ተሰሪዙ';
        $updHist->save(); 

        return [true, "info", "ሕፁይነት ብትክክል ተሰሪዙ ኣሎ"];
    }
    
    public function wahioleadersupdate(Request $request)
    {
        //update CareerInformation

        $updCareer = new CareerInformation;
        $updCareer->hitsuyID = $request->hitsuyID;        
        $updCareer->exprienceType = "ፖለቲካ";
        $updCareer->career = "ዋህዮ ኣመራርሓ";      
        $updCareer->position = $request->leadertype;      
        $updCareer->institute = $request->woredaID;      
        $updCareer->address = $request->wahioID;
        $updCareer->startDate = DateConvert::correctDate($request->decisiondate);
        $updCareer->save();   

        //update Member's position 
         $rHID=$request->hitsuyID;
         ApprovedHitsuy::where('hitsuyID',$rHID)->update(['wahioposition' => $request->leadertype]);;
        

        if($request->hitsuyID1!="የለን"){
            ApprovedHitsuy::where('hitsuyID',$request->hitsuyID1)->update(['wahioposition' => 'ተራ ኣባል']);
            
            CareerInformation::where('hitsuyID',$request->hitsuyID1)->where('position',$request->leadertype)->update(['endDate' => $request->decisiondate]);
            
        }

        Toastr::info("ዋህዮ ኣመራርሓ ብትክክል ተመዝጊቡ ኣሎ");
        return back();                
    }

    public function meseretawileadersupdate(Request $request)
    {
        //update CareerInformation

        $updCareer = new CareerInformation;
        $updCareer->hitsuyID = $request->hitsuyID;        
        $updCareer->exprienceType = "ፖለቲካ";
        $updCareer->career = "መሰረታዊ ውዳበ ኣመራርሓ";      
        $updCareer->position = $request->leadertype;      
        $updCareer->institute = $request->woredaID;      
        $updCareer->address = $request->meseretawiID;
        $updCareer->startDate = DateConvert::correctDate($request->decisiondate);
        $updCareer->save();   

        //update Member's position 
         $rHID=$request->hitsuyID;
         ApprovedHitsuy::where('hitsuyID',$rHID)->update(['meseratawiposition' => $request->leadertype]);;
        

        if($request->hitsuyID1!="የለን"){
            ApprovedHitsuy::where('hitsuyID',$request->hitsuyID1)->update(['meseratawiposition' => 'ተራ ኣባል']);
            
            CareerInformation::where('hitsuyID',$request->hitsuyID1)->where('position',$request->leadertype)->update(['endDate' => $request->decisiondate]);
            
        }

        Toastr::info("መሰረታዊ ውዳበ ኣመራርሓ ብትክክል ተመዝጊቡ ኣሎ");
        return back();                
    }
        
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
