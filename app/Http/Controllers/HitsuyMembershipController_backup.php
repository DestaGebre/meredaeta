<?php

namespace App\Http\Controllers;

use  App\Hitsuy;
use  App\ApprovedHitsuy;
use  App\NotyetHitsuy;
use  App\RejectedHitsuy;
use  App\CareerInformation;
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
    
    public function index()
    {
        $data = Hitsuy::whereIn('hitsuy_status',['ሕፁይ','ሕፁይነት ተናዊሑ'])->where('regDate','<',Carbon::now()->subMonths(6))->orderBy('regDate','asc')->get();        
        return view ( 'membership.membership' )->withData ( $data );
    }
    public function listMembers()
    {
        //
        $data = ApprovedHitsuy::where('approved_status','1')->get();        
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view ('membership.memberlist',compact('data','zobadatas'));        
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
    public function listHitsuy()
    {
        //
        $data = Hitsuy::where('hitsuy_status','ሕፁይ')->get();        
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view ('membership.hitsuylist',compact('data','zobadatas'));        
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

    public function correctDate($date){
        return date('Y-m-d',strtotime(str_replace('/','-',$date)));
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

        $apprMem = new ApprovedHitsuy;
        $apprMem->hitsuyID = $request->hitsuyID;        
        $apprMem->membershipDate = $this->correctDate($request->membershipDate);
        $apprMem->membershipType = $request->membershipType;

        $hitsuyoccup = Hitsuy::where('hitsuyID',$request->hitsuyID)->orderBy('updated_at', 'desc')->pluck('occupation')->first();
        if($hitsuyoccup=="ምሁር"||$hitsuyoccup=="መምህር"){
            $apprMem->memberType = "ሰብ ሞያ";
        }
        
        $zoneworedaCodeVal = substr($request->hitsuyID,0,4);
        // $zoneworedaCodeVal=intval($zoneworedaCodeVal);

        $apprMem->zoneworedaCode = $zoneworedaCodeVal;
        $apprMem->grossSalary = $request->grossSalary;
        $apprMem->netSalary = $request->netSalary;
        $apprMem->assignedWudabe = $request->assignedWudabe;
        $apprMem->assignedWahio = $request->assignedWahio;
        $apprMem->assignedAssoc = $request->assignedAssoc;
        $apprMem->fileNumber = $request->fileNumber;
        $apprMem->isReported = $request->isReported;
        $apprMem->hasRequested = $request->hasRequested;
        $apprMem->isApproved = $request->isApproved;        
        // $apprMem->save();   

        //update Hitsuy
        $updHist = Hitsuy::find ( $request->hitsuyID );
        $updHist->hitsuy_status ='ኣባል';
        // $updHist->save(); 
        return [true,"ሕፁይነት ብትክክል ፀዲቑ ኣሎ"];
                
    }
    
    public function postponeHitsuy(Request $request)
    {
        //add NotyetHitsuy

        $postMem = new NotyetHitsuy;
        $postMem->hitsuyID = $request->hitsuyID; 
        $postMem->postponedDate = $this->correctDate($request->postponedDate);
        $postMem->save();   

        //update Hitsuy
        $updHist = Hitsuy::find ( $request->hitsuyID );
        $updHist->hitsuy_status ='ሕፁይነት ተናዊሑ';
        $updHist->save(); 

        return [true,"ሕፁይነት ብትክክል ተናዊሑ ኣሎ"];
    }

    public function rejectHitsuy(Request $request)
    {
        //add rejected


        $rejMem = new RejectedHitsuy;
        $rejMem->hitsuyID = $request->hitsuyID;        
        $rejMem->rejectionReason = $request->rejectionReason;
        $rejMem->rejectionDate = $this->correctDate($request->rejectionDate);
        $rejMem->save();

        //update Hitsuy
        $updHist = Hitsuy::find( $request->hitsuyID );
        $updHist->hitsuy_status ='ሕፁይነት ተሰሪዙ';
        $updHist->save(); 

        return [true,"ሕፁይነት ብትክክል ተሰሪዙ ኣሎ"];
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
        $updCareer->startDate = $request->decisiondate;    
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
        $updCareer->startDate = $request->decisiondate;    
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
