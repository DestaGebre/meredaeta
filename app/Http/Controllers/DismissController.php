<?php

namespace App\Http\Controllers;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Dismiss;
use  App\ApprovedHitsuy;
use  App\Hitsuy;
use  App\Zobatat;
use App\DateConvert;
use App\Constant;
use DB;

use Illuminate\Http\Request;

class DismissController extends Controller
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
        $data = Dismiss::whereIn('hitsuyID', function($query) use($value){
            $query->select('hitsuyID')
            ->from(with(new ApprovedHitsuy)->getTable())
            ->where('zoneworedaCode', 'LIKE', $value.'%');
        })->paginate(Constant::PAGE_SIZE);
        // $data = Dismiss::all ();
        $tabianame = DB::table("tabias")->pluck("tabiaName","tabiaCode");
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");
        $woredaname = DB::table("woredas")->pluck("name","woredacode");
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
       return view ('membership.dismissal',compact('data','zobadatas','tabiadata','woredaname','woredadata','tabianame'));
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
        //
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
            'dismissreason' => 'required|in:ናይ ውልቀ ሰብ ሕቶ,ብቕፅዓት,ብኽብሪ,ብሞት,ካሊእ',
            'detailReason' => 'required',
            'proposedBy' => 'required',
            'approvedBy' => 'required',      
            'datedismiss' => 'required|ethiopian_date',
            'isReported' => 'required',
            'isApproved' => 'required',
        ],$messages);
        $fieldNames = [
        "hitsuyID" => "መለለዩ ሕፁይ",
        "dismissreason" => "ዝተሳነበተሉ ምኽንያት",
        "detailReason" => "ዝተሰናበተሉ/ዝተባረረሉ ዝርዝር ምኽንያት",
        "proposedBy" => "ናይ ስንብት መበገሲ ሓሳብ ዘቕረበ ኣካል",
        "approvedBy" => "ዘፅደቐ ኣካል",
        "datedismiss" => "ዕለት ስንብት",
        ];
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
            $validator->errors()->add('duplicate', 'ኣባል ንምስንባት እኹል ፍቓድ ኣይብሎምን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $dismiss = new Dismiss;
        $dismiss->hitsuyID = $request->hitsuyID;
        $dismiss->dismissReason = $request->dismissreason;
        $dismiss->detailReason = $request->detailReason;
        $dismiss->proposedBy = $request->proposedBy;
        $dismiss->approvedBy = $request->approvedBy;
        
        $dismiss->dismissDate = DateConvert::correctDate($request->datedismiss);
        $dismiss->isReported = $request->isReported;
        $dismiss->isApproved = $request->isApproved;
        $dismiss->save();  
          
        ApprovedHitsuy::where('hitsuyID',$request->hitsuyID)->update(['approved_status' => 'ዝተሰናበተ']);
        $updHist = Hitsuy::find ( $request->hitsuyID );
        $updHist->hitsuy_status ='ዝተሰናበተ';
        $updHist->save();

        Toastr::info("ስንብት ብትኽክል ተመዝጊቡ ኣሎ");
        return back();

    }
    public function editDismiss(Request $request)
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
            'dismissreason' => 'required|in:ናይ ውልቀ ሰብ ሕቶ,ብቕፅዓት,ብኽብሪ,ብሞት,ካሊእ',
            'detailReason' => 'required',
            'proposedBy' => 'required',
            'approvedBy' => 'required',      
            'datedismiss' => 'required|ethiopian_date'
        ],$messages);
        $fieldNames = [
        "id" => "መለለዩ ስንብት",
        "hitsuyID" => "መለለዩ ሕፁይ",
        "dismissreason" => "ዝተሳነበተሉ ምኽንያት",
        "detailReason" => "ዝተሰናበተሉ/ዝተባረረሉ ዝርዝር ምኽንያት",
        "proposedBy" => "ናይ ስንብት መበገሲ ሓሳብ ዘቕረበ ኣካል",
        "approvedBy" => "ዘፅደቐ ኣካል",
        "datedismiss" => "ዕለት ስንብት",
        ];
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
            $validator->errors()->add('duplicate', 'ኣባል ንምስንባት እኹል ፍቓድ ኣይብሎምን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
       $dis = Dismiss::find($request->id);
        $dis->dismissReason = $request->dismissreason;
        $dis->detailReason = $request->detailReason;
        
        $dis->proposedBy = $request->proposedBy;
        $dis->approvedBy = $request->approvedBy;
        
        $dis->dismissDate = DateConvert::correctDate($request->datedismiss);
        $dis->save();
        
        return [true, 'success', 'ስንብት ተስተካኪሉ ኣሎ'];
    }

     public function deleteDismiss(Request $request)
    {
        $data = Dismiss::find($request->id);
        if($data){
            ApprovedHitsuy::where('hitsuyID',$data->hitsuyID)->update(['approved_status' => '1']);
            Hitsuy::where('hitsuyID',$data->hitsuyID)->update(['hitsuy_status' => 'ኣባል']);
            $data->delete();
            return [true, "ስንብት ብትኽክል ተሰሪዙ ኣሎ"];
        }
        return [true, "ስንብት ክርከብ ኣይኸኣለን"];
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
        $crud = Dismiss::find($id);
        
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
        //
        $crud = Dismiss::find($id);
        $crud->id = $request->get('id');
       
        $crud->save();
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
