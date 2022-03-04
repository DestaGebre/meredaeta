<?php

namespace App\Http\Controllers;

require_once substr(dirname(__FILE__), 0, -17).'\PHPExcel-1.8\Classes\PHPExcel.php';

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
// use PHPExcel_Style_Borders;
use PHPExcel_Shared_Font;
use App\DateConvert;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Zobatat;
use App\Http\Requests;
use App\CoreDegefti;
use App\Constant;
use App\UserAction;
use DB;

use Illuminate\Http\Request;

class CoreDegeftiController extends Controller
{
    
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()    //if not authenticated redirect to login
    {
        $this->middleware('auth');
    }
    public function index()
    {
      //
      $data = CoreDegefti::all();
      return view('membership.coreDegefti',compact('data'));
    }
	public function listCoreTwo()
    {
        //
        $data = CoreDegefti::paginate(Constant::PAGE_SIZE);
        return view('membership.core',compact('data'));
    }

    public function listCore()
    {
        //
        $data = CoreDegefti::paginate(Constant::PAGE_SIZE);
        return view('membership.corelist',compact('data'));
    }
    public function listCoreExcel()
    {
        $zoneCode = Auth::user()->area;
        $today = DateConvert::toEthiopian(date('d/m/Y'));
        if(Auth::user()->usertype == 'admin'){
            $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
        }
        $zoneName = Zobatat::where('zoneCode', $zoneCode)->select(['zoneName'])->first()->toArray()['zoneName'];
        header('Content-Type: application/vvnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $zoneName . '_' . explode("/", $today)[2] . '_ኮር_ደገፍቲ.xlsx"');
        header('Cache-Control: max-age=0');
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'መ.ቑ')
            ->setCellValue('B1', 'ሽም')
            ->setCellValue('C1', 'ፆታ')
            ->setCellValue('D1', 'ዕድመ')
            ->setCellValue('E1', 'ትውልዲ ዓዲ')
            ->setCellValue('F1', 'ኮር ደጋፊ ዝኾነሉ ዕለት')
            ->setCellValue('G1', 'ደረጃ ት/ቲ')
            ->setCellValue('H1', 'ምድብ ስራሕ')
            ->setCellValue('I1', 'ውሳነ ዘፅደቐ ውዳበ')
            ->setCellValue('J1', 'ዝተወደበሉ ውዳበ')
            ->setCellValue('K1', 'ዝተሳተፈሉ ብርኪ ኮሚቴ')
            ->setCellValue('L1', 'ኣብ ኮሚቴ ዘለዎ ተሳትፎ');

        $data = CoreDegefti::all();
        $i = 2;

        foreach ($data as $mydata) {
              $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i , $mydata->id)
                ->setCellValue('B' . $i , $mydata->name . $mydata->fname . $mydata->gfname)
                ->setCellValue('C' . $i , $mydata->gender)
                ->setCellValue('D' . $i , (date('Y') - date('Y',strtotime($mydata->dob))))
                ->setCellValue('E' . $i , $mydata->birthPlace)
                ->setCellValue('F' . $i , DateConvert::toEthiopian(date('d/m/Y',strtotime($mydata->coreDegafiregDate))))
                ->setCellValue('G' . $i , $mydata->position)
                ->setCellValue('H' . $i , $mydata->occupation)
                ->setCellValue('I' . $i , $mydata->degaficonfirmedWidabe)
                ->setCellValue('J' . $i , $mydata->assignedWidabe)
                ->setCellValue('K' . $i , $mydata->participatedCommittee)
                ->setCellValue('L' . $i , $mydata->degafiparticipationinCommittee);
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
    function makeLinks($x){
        foreach($x as $k=>$v){
            $x[$k] = '<a href="#'.$k.'">'.$v.'</a>';
        }
        return $x;
    }
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute ኣይተመልአን',
            'integer' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'after' => 'ዕለት ትውልዲ ቅድሚ ኣባልነት ኮር ደጋፊ ዝረኸበሉ እዋን ክኸውን ኣለዎ',
            'digits' => 'ቑፅሪ ስልኪ 10 ድጂት ክኸውን ኣለዎ'
        ];
        // validate each attribute, $errors should be placed in the view
        $validator = \Validator::make($request->all(),[
            'name' => 'required',            
            'fname' => 'required',
            'gfname' => 'required',
            'gender' => 'required|alpha|in:ተባ,ኣን', 
            'birthPlace' => 'required',            
            'occupation' => 'required',
            'position' => 'required',
            'fileNumber' => 'required', 
            'address' => 'required',
            'poBox' => 'required',         
            'participatedCommittee' => 'required', 
            'degafiparticipationinCommittee' => 'required',  
            'tell' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'dob' => 'required|ethiopian_date',
            'coreDegafiregDate' => 'required|ethiopian_date'

        ],$messages);
        $fieldNames = [
        'name' => 'ሽም ደጋፊ',            
        'fname' => 'ሽም ኣቦ',
        'gfname' => 'ሽም ኣቦሓጎ',
        'gender' => 'ፆታ', 
        'birthPlace' => 'ትውልዲ ቦታ',
        'occupation' => 'ማሕበራዊ መሰረት',
        'position' => 'ደረጃ ትምህርቲ',
        'fileNumber' => 'ፋይል ቑፅሪ',
        'address' => 'ኣድራሻ',
        'poBox' => 'ቁ.ሳ.ፖ',
        'participatedCommittee' => 'ዝተሳተፈሉ ብርኪ ኮሚቴ',
        'degafiparticipationinCommittee' => 'ኣብ ኮሚቴ ዘለዎ ተሳትፎ',
        'tell' => 'ቑፅሪ ስልኪ',
        'email' => 'ኢሜይል',
        'dob' => 'ዕለት ትውልዲ',
        'coreDegafiregDate' => 'ኮር ደጋፊ ዝኾነሉ ዕለት'
        ];
        // $fieldNames = $this->makeLinks($fieldNames);
        $validator->setAttributeNames($fieldNames);
        $validator->validate();
		$newMem = new CoreDegefti;
        $newMem->name = $request->name;
		$newMem->fname = $request->fname;
		$newMem->gfname = $request->gfname;
		$newMem->gender = $request->gender;
		$newMem->birthPlace = $request->birthPlace;
		$newMem->dob = DateConvert::correctDate($request->dob);
		$newMem->position = $request->position;
		$newMem->occupation = $request->occupation;
		//$newMem->sme = $request->sme;
		$newMem->coreDegafiregDate = DateConvert::correctDate($request->coreDegafiregDate);
        $newMem->proposerMem = $request->proposerMem;
		$newMem->degaficonfirmedWidabe = $request->degaficonfirmedWidabe;
		$newMem->assignedWidabe = $request->assignedWidabe;
		$newMem->participatedCommittee = $request->participatedCommittee;
		$newMem->degafiparticipationinCommittee = $request->degafiparticipationinCommittee;
		//$newMem->tabiaID = $request->tabiaID;
		$newMem->address = $request->address;
		$newMem->tell = $request->tell;
		$newMem->poBox = $request->poBox;
		$newMem->fileNumber = $request->fileNumber;		
		$newMem->email = $request->email;
		$newMem->bosSubmittedTsebtsab = $request->bosSubmittedTsebtsab;
		$newMem->widabeacceptedDegafi = $request->widabeacceptedDegafi;
		$newMem->save();   
        Toastr::info("ኮር ደጋፊ ብትኽክል ተመዝጊቡ ኣሎ");
        UserAction::storeAction('', 'coredegeftis', Constant::CREATE, Constant::CORE_DEGEFTI, ['ሽም' => $request->name,'ሽም ኣቦ' => $request->fname, 'ፆታ' => $request->gender, 'ዕለት ትውልዲ' => $request->dob, 'ኣድራሻ' => $request->address, 'ማሕበራዊ መሰረት' => $request->occupation,  'ውዳበ' => $request->assignedWidabe], false, []);  
		return back();

    }
	public function editCoreDegefti(Request $request)
    {
	    $newMem = CoreDegefti::find ( $request->id );
        $newMem->name = $request->name;
		$newMem->fname = $request->fname;
		$newMem->gfname = $request->gfname;
		$newMem->gender = $request->gender;
		$newMem->birthPlace = $request->birthPlace;
		$newMem->dob = $request->dob;
		$newMem->position = $request->position;
		$newMem->occupation = $request->occupation;
		//$newMem->sme = $request->sme;
		$newMem->coreDegafiregDate = $request->coreDegafiregDate;
        $newMem->proposerMem = $request->proposerMem;
		$newMem->degaficonfirmedWidabe = $request->degaficonfirmedWidabe;
		$newMem->assignedWidabe = $request->assignedWidabe;
		$newMem->participatedCommittee = $request->participatedCommittee;
		$newMem->degafiparticipationinCommittee = $request->degafiparticipationinCommittee;
		//$newMem->tabiaID = $request->tabiaID;
		$newMem->address = $request->address;
		$newMem->tell = $request->tell;
		$newMem->poBox = $request->poBox;
		$newMem->fileNumber = $request->fileNumber;		
		$newMem->email = $request->email;
		$newMem->bosSubmittedTsebtsab = $request->bosSubmittedTsebtsab;
		$newMem->widabeacceptedDegafi = $request->widabeacceptedDegafi;
        $newMem->save();   
        
		$data->save ();
		
		return back();
		
	}
	  public function deleteCoreDegefti(Request $request)
    {
     
    	$data =CoreDegefti::find($request->id)->delete();
        Toastr::info("ኮር ደጋፊ ብትኽክል ተስተካኪሉ ኣሎ");
    	return response()->json($data);	
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
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
