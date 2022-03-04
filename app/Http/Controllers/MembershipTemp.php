<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\Zobatat;
use App\Http\Requests;
use  App\Hitsuy;
use  App\ApprovedHitsuy;
use App\meseretawiWdabe;
use DB;

use Illuminate\Http\Request;


class MembershipTemp extends Controller
{
    public function __construct()    //if not authenticated redirect to login
    {
        $this->middleware('auth');
    }
    public function index()
    {
      $data = Hitsuy::all ();
      $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
      return view ('membership.directmembership',compact('data','zobadatas'));
        
    }

    public function correctDate($date){
        return date('Y-m-d',strtotime(str_replace('/','-',$date)));
    }

    public function dateValidation($d){
        $pattern = "/^(([12][0-9]|30|0?[1-9])\/(0?[1-9]|1[0-2])\/([12][0-9]{3}))|(0?[1-6])\/13\/([12][0-9]{3})$/";
        if(preg_match($pattern, $d)){
            if(explode("/", $d)[1] != "13"){
                return true;
            }
            else{
                if((int)explode("/", $d)[0] != 6){
                    return true;
                }
                else{
                    if(((int)explode("/", $d)[2] + 1) % 4 == 0){
                        return true;
                    }
                    else
                        return false;
                }
            }
        }
        return false;
    }
    public function startDayOfEthiopian($year){
        $newYearDay = floor($year / 100) - floor($year / 400) - 4;
        return (($year - 1 ) % 4 === 3) ? $newYearDay + 1 : $newYearDay;
    }

    public function toGregorian($d){
        $year = (int)explode("/", $d)[2];
        $month = (int)explode("/", $d)[1];
        $date = (int)explode("/", $d)[0];

        $newYearDay = $this->startDayOfEthiopian($year);
        $gregorianYear = $year + 7;

        $gregorianMonths = [0.0, 30, 31, 30, 31, 31, 28, 31, 30, 31, 30, 31, 31, 30];

        $nextYear = $gregorianYear + 1;
        if(($nextYear % 4 === 0 && $nextYear % 100 != 0) || $nextYear % 400 === 0){
            $gregorianMonths[6] = 29;
        }

        $until = (($month - 1) * 30.0) + $date;
        if($until <= 37 && $year <= 1575){
            $until += 28;
            $gregorianMonths[0] = 31;
        }
        else{
            $until += $newYearDay - 1;
        }

        if($year - 1 % 4 === 3){
            $until += 1;
        }
        $m = 0;
        $gregorianDate;
        for($i=0; $i < count($gregorianMonths); $i++){
            if($until <= $gregorianMonths[$i]){
                $m = $i;
                $gregorianDate = $until;
                break;
            }
            else{
                $m = $i;
                $until -= $gregorianMonths[$i];
            }
        }
        if($m > 4){
            $gregorianYear += 1;
        }
        $order = [8, 9, 10, 11, 12, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $gregorianMonths = $order[$m];
        return (string)$gregorianDate . '/' . (string)$gregorianMonths . '/' . (string)$gregorianYear;

    }

    public function store(Request $request)
    {   
        $messages = [
            'after'      => 'ዕለት ትውልዲ ዕለት ካብ ዝተመልመለሉ ዕለት ክቕድም ኣለዎ',
            'required' => ':attribute ብትኽክል ኣይኣተወን',
            'alpha' => ':attribute ፊደላት ጥራሕ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'date_format' => ':attribute: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'digits' => 'ቑፅሪ ስልኪ 10 ድጂት ክኸውን ኣለዎ',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',

        ];
        // validate each attribute, $errors should be placed in the view
        $validator = \Validator::make($request->all(),[
            'name' => 'required',            
            'fname' => 'required',
            'gfname' => '',
            'gender' => 'required|in:ተባ,ኣን', 
            'birthPlace' => 'required',            
            'occupation' => 'required|in:መምህር,ተምሃራይ,ሲቪል ሰርቫንት,መፍረዪ,ንግዲ,ግልጋሎት,ኮስንትራክሽን,ከተማ ሕርሻ,ሸቃላይ',
            // 'position' => 'required|alpha',
            // 'fileNumber' => 'required', 
            //'address' => 'required|alpha_num',                         
            'tell' => 'digits:10',
            'dob' => 'required|ethiopian_date',
            'regDate' => 'required|ethiopian_date',
            'proposerWahio' => 'required',
            'leadership' => 'required|in:ተራ ኣባል,መ/ዉ/አመራርሓ,ዋህዮ አመራርሓ,ጀማሪ አመራርሓ,ማእኸላይ አመራርሓ,ላዕለዋይ አመራርሓ,ታሕተዋይ አመራርሓ',
            'mahber' => 'in:ደቂ ኣንስትዮ,መናእሰይ,ገባር,መምህራን',
            'netsalary' => 'numeric',
            'educationlevel' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12,ሰርቲፊኬት,ዲፕሎማ,ዲግሪ,ማስተርስ,ፒ.ኤች.ዲ'

        ],$messages);
        $fieldNames = [
        'name' => 'ሽም',            
        'fname' => 'ሽም ኣቦ',
        'gfname' => 'ሽም ኣቦሓጎ',
        'gender' => 'ፆታ', 
        'birthPlace' => 'ትውልዲ ወረዳ',            
        'occupation' => 'ማሕበራው መሰረት',
        'position' => 'ሓላፍነት',
        'fileNumber' => 'ቑፅሪ ፋይል', 
        //'address' => 'required|alpha_num',                         
        'tell' => 'ቑፅሪ ስልኪ',
        'email' => 'ኢሜይል',
        'dob' => 'ዕለት ትውልዲ',
        'regDate' => 'ኣባልነት ዘመን',
        'proposerWahio' => 'ዋህዮ',
        'leadership' => 'ኩነታት መሪሕነት',
        'netsalary' => 'ዝተፃረየ ደሞዝ',
        ];
        $validator->setAttributeNames($fieldNames);
        $validator->validate();
        if($request->occupation=='መምህር'||$request->occupation=='ሲቪል ሰርቫንት'){
            if(!$request->netSalary){
                $validator->errors()->add('duplicate', 'ዝተፃረየ ደሞዝ ኣይተመልአን');
                return [false, 'error', $validator->errors()->all()];          
            }
        }
        $request->dob = $this->toGregorian($request->dob);
        $request->regDate = $this->toGregorian($request->regDate);
        //Generating Customized ID,
        // $year="10";
        $today=date("Y-m-d");        
        $yearsub = substr($today,0,4);
        $monthsub = substr($today,5,2);
        $daysub = substr($today,8,2);
        $yearValue=intval($yearsub);
        $monthValue=intval($monthsub);
        $dayValue=intval($daysub);
        if (12 >=($monthValue) && ($monthValue) >= 10){ //if month value is between 10-12, subtract 8
            $year=$yearValue-7;
        }else if (8 >=($monthValue) && ($monthValue) >= 1){ //if month value is between 1-8, subtract 7
            $year=$yearValue-8;
        }else if ( ($monthValue) == 9){ //if month value is 9, check date subtract 8
            if (10 >=($dayValue) && ($dayValue) >= 1){
                $year=$yearValue-8;
            }else if (30 >=($dayValue) && ($dayValue) >= 11){
                $year=$yearValue-7;
            }else{
                
            }                
        }else{
                
        } 
        $year = substr($year,2,2);
        $year=intval($year);
        $zoneCode = $request->zone;
        $worCode = $request->woreda;
        $tabCode = $request->tabiaID;
        $zwtCode="$zoneCode$worCode$tabCode"; //this should be tabiaCode??should be set,
        $lastHitsuy = Hitsuy::orderBy('created_at', 'desc')->where('hitsuyID','LIKE',$zwtCode.'%')->first();
        if($lastHitsuy){ //if there is last Hitsuy            
            $mID = substr($lastHitsuy->hitsuyID,10,6); //starting at 7th and length 3
            $lastID=sprintf('%06d', intval($mID) + 1);
            $finalID="$zwtCode/".$lastID;//."/".$year;
        }else{
            $finalID="$zwtCode/000001";//.$year;
        }


        $newMem = new Hitsuy;
        $newMem->hitsuyID = $finalID;
        $newMem->name = $request->name;
        $newMem->fname = $request->fname;
        $newMem->gfname = $request->gfname;
        $newMem->gender = $request->gender;
        $newMem->birthPlace = $request->birthPlace;
        $newMem->dob = $this->correctDate($request->dob);
        $newMem->occupation = $request->occupation;
        // $newMem->position = $request->position;
        $newMem->position = "";
        $newMem->sme = $request->sme;
        $newMem->regDate = $this->correctDate($request->regDate);
        $newMem->proposerWidabe = $request->proposerWidabe;
        $newMem->proposerWahio = $request->proposerWahio;
        $newMem->proposerMem = $request->proposerMem;
        $newMem->fileNumber = "";
        $newMem->region = 'ትግራይ';
        $newMem->tabiaID = $request->tabiaID;
        $newMem->address = $request->address;
        $newMem->tell = $request->tell;
        $newMem->email = $request->email;
        $newMem->isRequested = "1";       
        $newMem->hasPermission = "1";
        $newMem->isWilling = "1";
        $newMem->isReportedWahioHalafi = "1";
        $newMem->isReportedWahioMem = "1";
        $newMem->isReportedWahioMem = "1";
        $newMem->isReportedWahioMem = "1";
        $newMem->educationlevel = $request->educationlevel;
        $newMem->skill = $request->skill;
        $newMem->hitsuy_status = 'ኣባል';
        $newMem->save();   



        $apprMem = new ApprovedHitsuy;
        $apprMem->hitsuyID = $finalID;        
        $apprMem->membershipDate = $this->correctDate($request->regDate);
        $apprMem->membershipType = 'ሲቪል';
        if($request->occupation=="ምሁር"||$request->occupation=="መምህር"){
            $apprMem->memberType = "ሰብ ሞያ";
        }
        $zoneworedaCodeVal = substr($finalID,0,9);
        // $zoneworedaCodeVal=intval($zoneworedaCodeVal);

        $apprMem->gender = $request->gender;
        $apprMem->occupation = $request->occupation;
        $apprMem->wudabeType = meseretawiWdabe::where('widabeCode', $request->proposerWidabe)->pluck('type')->first();

        $apprMem->zoneworedaCode = $zoneworedaCodeVal;
        $apprMem->grossSalary = 0;
        if(!$request->netSalary)
            $apprMem->netSalary = 0;
        else
            $apprMem->netSalary = $request->netSalary;
        $apprMem->assignedWudabe = $request->proposerWidabe;
        $apprMem->assignedWahio = $request->proposerWahio;
        $apprMem->assignedAssoc = $request->mahber;
        $apprMem->fileNumber = "";
        $apprMem->isReported = "1";
        $apprMem->hasRequested = "1";
        $apprMem->isApproved = "1";
        $apprMem->save();   


        Toastr::info("ኣባል ብትኽክል ተፈጢሩ ኣሎ");
        return back();

    }

}
