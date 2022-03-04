<?php
namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Penalty;
use  App\Zobatat;
use  App\Hitsuy;
use  App\ApprovedHitsuy;
use App\DateConvert;
use App\Constant;
use DB;

use Illuminate\Http\Request;


class PenalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()    //if not authenticated redirect to login
    {
        $this->middleware('auth');
    }
    public function index()
    { 
        $value = Auth::user()->area;
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $value = '__'.$value;
        }
        $data = Penalty::whereIn('hitsuyID', function($query) use($value){
            $query->select('hitsuyID')
            ->from(with(new ApprovedHitsuy)->getTable())
            ->where('zoneworedaCode', 'LIKE', $value.'%');
        })->paginate(Constant::PAGE_SIZE);
        // $data = Penalty::all ();
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
	    return view ('membership.penalty',compact('data','zobadatas'));
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
        $messages = [            
            'ethiopian_date' => ':attribute: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'alpha' => ':attribute ፊደላት ጥራሕ ክኸውን ኣለዎ',
            'after' => 'ዝውውር ዝጅምረሉ ዕለት ካብ ዝውውር ዘብቅዐሉ ዕለት ክቕድም ኣለዎ'
        ];       
	    $validator = \Validator::make($request->all(),[ 
            'hitsuyID' => 'required',
            'chargeType' => 'required|in:ቀሊል ናይ ስነምግባር ጉድለት,ወርሓዊ ወፈያ ንልዕሊ ሓደ ወርሒ ምሕላፍ,ንናይ ህወሓት ፕሮግራምን ሕገ ደንቢን ዘይምቕባ,ብኸቢድ ገበን ተኸሲሱ ገበነኛ ዝተብሃለ,ናይ ጉጅለ ምንቅስቓስ ምክያድ,ናይ ስነምግባር መጠንቐቕታ ተዋሂብዎ ዝደገመ,ናይ ኣባልነት ወፈያ ብእዋኑ ዘይምኽፋልን ልዕሊ ክልተ ጊዜ መጠንቐቕታ ዝተውሃቦ,መሰል ኣባል እንትግሃስ ብተደጋጋሚ እናገጠሞን እናፈለጠን ብዝግባእ ዘይተቓለሰ,ገምጋምን ምንቅቓፍን ብተደጋጋሚ ንሰብ መጥቕዒ ወይ መጥቀሚ ክጥቀም ዝሃቀነን',
            'chargeLevel' => 'required|in:ቀሊል,ኸቢድ',
            'penaltyGiven' => 'required|in:መጠንቀቕታ,ናይ ሕፀ እዋን ምንዋሕ,ካብ ሕፁይነት ምብራር,ካብ ሙሉእ ናብ ሕፁይ ኣባልነት ምውራድ,ካብ ሓላፍነት ንውሱን ጊዜ ምእጋድ,ካብ ሓላፍነት ምውራድ,ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ,ካብ ኣባልነት ምብራር',
            'proposedBy' => 'required',
            'startDate' => 'required|ethiopian_date'
        ],$messages);
        $fieldNames = [
        "hitsuyID" => "መለለዩ ሕፁይ",
        "chargeType" => "ዓይነት ጥፍኣት",
        "chargeLevel" => "ደረጃ ጥፍኣት",
        "penaltyGiven" => "ዝተውሃበ ቕፅዓት",
        "proposedBy" => "መበገሲ ሓሳብ ዘቕረበ ኣካል",
        "startDate" => "ቕፅዓት ዝተውሃበሉ ዕለት",];
        $validator->setAttributeNames($fieldNames);
        $validator->validate();
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->count()){
            $validator->errors()->add('duplicate', 'ኣባል ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $value = Auth::user()->area;
        if(Auth::user()->usertype=='woreda' || Auth::user()->usertype=='woredaadmin'){
            $value = '__'.$value;
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('zoneworedaCode','LIKE', $value.'%')->count()){
            $validator->errors()->add('duplicate', 'ኣባል ንምቕፃዕ እኹል ፍቓድ ኣይብሎምን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
	    $penalty = new Penalty;
        $penalty->hitsuyID = $request->hitsuyID;
		$penalty->chargeType = $request->chargeType;
		$penalty->chargeLevel = $request->chargeLevel;
		$penalty->penaltyGiven = $request->penaltyGiven;
		$penalty->proposedBy = $request->proposedBy;
		$penalty->approvedBy = $request->approvedBy;
        if($request->penaltyGiven=="መጠንቀቕታ"||$request->penaltyGiven=="ናይ ሕፀ እዋን ምንዋሕ"||$request->penaltyGiven=="ካብ ሓላፍነት ንውሱን ጊዜ ምእጋድ"||$request->penaltyGiven=="ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ"){
		    $penalty->duration = "6 ኣዋርሕ";

            if($request->penaltyGiven=="ናይ ሕፀ እዋን ምንዋሕ"){
                $updHist = Hitsuy::find ( $request->hitsuyID );
                $updHist->hitsuy_status ='ሕፁይነት ተናዊሑ';
                $updHist->save(); 
            }else if($request->penaltyGiven=="ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ"){
                ApprovedHitsuy::where('hitsuyID',$request->hitsuyID)->update(['approved_status' => 'ዝተኣገደ']);
            }else{

            }
        }else{
            $penalty->duration = " ";

            if($request->penaltyGiven=="ካብ ሕፁይነት ምብራር"){
                $updHist = Hitsuy::find($request->hitsuyID);
                $updHist->hitsuy_status ='ካብ ሕፁይነት ዝተባረረ';
                $updHist->save();
            }else if($request->penaltyGiven=="ካብ ሙሉእ ናብ ሕፁይ ኣባልነት ምውራድ"){
                ApprovedHitsuy::where('hitsuyID',$request->hitsuyID)->update(['approved_status' => 'ናብ ሕፁይነት ዝወረደ']);
                $updHist = Hitsuy::find ( $request->hitsuyID );
                $updHist->hitsuy_status ='ሕፁይ';
                $updHist->save();
            }else if($request->penaltyGiven=="ካብ ኣባልነት ምብራር"){
                ApprovedHitsuy::where('hitsuyID',$request->hitsuyID)->update(['approved_status' => 'ዝተባረረ']);
                $updHist = Hitsuy::find ( $request->hitsuyID );
                $updHist->hitsuy_status ='ካብ ኣባልነት ዝተባረረ';
                $updHist->save();
            }else{

            }
        }
		$penalty->startDate = DateConvert::correctDate($request->startDate);
        $penalty->isReported = $request->isReported;
        $penalty->isApproved = $request->isApproved;
        $penalty->save();  
    		
        Toastr::info("ቅፅዓት ብትኽክል ተመዝጊቡ ኣሎ");
		return back();
 		
		

    }
	
	public function editPenality(Request $request)
    {
        $messages = [            
            'ethiopian_date' => ':attribute: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'alpha' => ':attribute ፊደላት ጥራሕ ክኸውን ኣለዎ',
            'after' => 'ዝውውር ዝጅምረሉ ዕለት ካብ ዝውውር ዘብቅዐሉ ዕለት ክቕድም ኣለዎ'
        ];       
        $validator = \Validator::make($request->all(),[ 
            'id' => 'required',
            'hitsuyID' => 'required',
            'chargeType' => 'required|in:ቀሊል ናይ ስነምግባር ጉድለት,ወርሓዊ ወፈያ  ንልዕሊ ሓደ ወርሒ ምሕላፍ,ንናይ ህወሓት ፕሮግራምን ሕገ ደንቢን ዘይምቕባ,ብኸቢድ ገበን ተኸሲሱ ገበነኛ ዝተብሃለ,ናይ ጉጅለ ምንቅስቓስ ምክያድ,ናይ ስነምግባር መጠንቐቕታ ተዋሂብዎ ዝደገመ,ናይ ኣባልነት ወፈያ ብእዋኑ ዘይምኽፋልን ልዕሊ ክልተ ጊዜ መጠንቐቕታ ዝተውሃቦ,መሰል ኣባል እንትግሃስ ብተደጋጋሚ እናገጠሞን እናፈለጠን ብዝግባእ ዘይተቓለሰ,ገምጋምን ምንቅቓፍን ብተደጋጋሚ ንሰብ መጥቕዒ ወይ መጥቀሚ ክጥቀም ዝሃቀነን',
            'chargeLevel' => 'required|in:ቀሊል,ኸቢድ',
            'penaltyGiven' => 'required|in:መጠንቀቕታ,ናይ ሕፀ እዋን ምንዋሕ,ካብ ሕፁይነት ምብራር,ካብ ሙሉእ ናብ ሕፁይ ኣባልነት ምውራድ,ካብ ሓላፍነት ንውሱን ጊዜ ምእጋድ,ካብ ሓላፍነት ምውራድ,ካብ ኣባልነት ንውሱን ጊዜ ምእጋድ,ካብ ኣባልነት ምብራር',
            'proposedBy' => 'required',
            'startDate' => 'required|ethiopian_date'
        ],$messages);
        $fieldNames = [
        "id" => "መለለዩ ቕፅዓት",
        "hitsuyID" => "መለለዩ ሕፁይ",
        "chargeType" => "ዓይነት ጥፍኣት",
        "chargeLevel" => "ደረጃ ጥፍኣት",
        "penaltyGiven" => "ዝተውሃበ ቕፅዓት",
        "proposedBy" => "መበገሲ ሓሳብ ዘቕረበ ኣካል",
        "startDate" => "ቕፅዓት ዝተውሃበሉ ዕለት",];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->count()){
            $validator->errors()->add('duplicate', 'ኣባል ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        $value = Auth::user()->area;
        if(Auth::user()->usertype=='woreda' || Auth::user()->usertype=='woredaadmin'){
            $value = '__'.$value;
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('zoneworedaCode','LIKE', $value.'%')->count()){
            $validator->errors()->add('duplicate', 'ኣባል ንምቕፃዕ እኹል ፍቓድ ኣይብሎምን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
	    $pen = Penalty::find ( $request->id );		        
		$pen->chargeType = $request->chargeType;
		$pen->chargeLevel = $request->chargeLevel;
		$pen->penaltyGiven = $request->penaltyGiven;
		$pen->proposedBy = $request->proposedBy;
		$pen->approvedBy = $request->approvedBy;
		// $pen->duration = $request->duration;
		$pen->startDate = DateConvert::correctDate($request->startDate);
		$pen->save ();
		
		return [true, 'success', "ቅፅዓት ብትኽክል ተስተካኪሉ ኣሎ"];
	}
	  public function deletePenality(Request $request)
    {
        $data = Penalty::find($request->id);
        if($data){
            ApprovedHitsuy::where('hitsuyID',$data->hitsuyID)->update(['approved_status' => '1']);
            Hitsuy::where('hitsuyID',$data->hitsuyID)->update(['hitsuy_status' => 'ኣባል']);
            $data->delete();
            return [true, "ቅፅዓት ብትኽክል ተሰሪዙ ኣሎ"];
        }
        return [true, "ቅፅዓት ክርከብ ኣይኸኣለን"];
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
        $crud = Penality::find($id);
        
        return view('pages.zoneedit', compact('crud','id'));

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
        $crud = Penality::find($id);
        $crud->id = $request->get('id');
       
        $crud->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
		 
	}


