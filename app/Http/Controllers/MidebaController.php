<?php

namespace App\Http\Controllers;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Mideba;
use  App\Zobatat;
use  App\ApprovedHitsuy;
use App\meseretawiWdabe;
use App\Wahio;
use App\DateConvert;
use App\Constant;
use App\UserAction;
use DB;

use Illuminate\Http\Request;

class MidebaController extends Controller
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
        $key = 'zone';
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $key = 'woreda';
        }
        $data = Mideba::where($key, 'LIKE', $value.'%')->paginate(Constant::PAGE_SIZE);
        
        $tabianame = DB::table("tabias")->pluck("tabiaName","tabiaCode");
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");
        $woredaname = DB::table("woredas")->pluck("name","woredacode");
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
       return view ('membership.mideba',compact('data','zobadatas','tabiadata','woredaname','woredadata','tabianame'));
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
    public function getCodesFromWahio($id){
        $w = Wahio::find($id);
        $arr = [];
        if($w){
            $arr[] = $w->id;
            $arr[] = $w->wahiosmw->widabeCode;
            $arr[] = $w->wahiosmw->widabes->tabiaCode;
            $arr[] = $w->wahiosmw->widabes->tabiatat->woredacode;
            $arr[] = $w->wahiosmw->widabes->tabiatat->zonat->zoneCode;
        }
        return $arr;
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
            'same'    => 'The :attribute and :other must match.',
            'size'    => 'The :attribute must be exactly :size.',
            'between' => 'The :attribute value :input is not between :min - :max.',
            'after'      => 'ምደባ ዝጀመረሉ ዕለት ካብ ምደባ ዘብቀዐሉ ዕለት ክቕድም ኣለዎ።',
            'required' => ':attribute ብትኽክል ኣይኣተወን።',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ'
        ];
        $validator = \Validator::make($request->all(),[ 
            'hitsuyID' => 'required',
            'birkiCommittee' => 'required|in:መሰረታዊ ውዳበ ኮሚቴ,ጣብያ ኮሚቴ,ወረዳ/ክፍለከተማ ኮሚቴ,ዞባ ኮሚቴ,ተራ ኣባል,ካልእ',
            'dereja' => 'required',
            'zone' => 'required',
            'woreda' => 'required',
            'tabiaID' => 'required',
            'proposerWidabe' =>'required',
            'proposerWahio' => 'required',
            'awekakla' => 'required',
            'type' => 'required',
            'approvedBy' => 'required',
            'reason' => 'required|in:ቕፅዓት,ዕቤት,ናይ ውዳበ ውሳነ(ንስራሕ),ናይ ኣባል ሕቶ(ማሕበራዊ),ካሊእ',
            'startDate' => 'required|ethiopian_date'
            //'endDate' => 'required|ethiopian_date'

        ],$messages);
        $fieldNames = [
        'hitsuyID' => 'መለለዪ ሕፁይ',
        'birkiCommittee' => 'ዝተመደበሉ ብርኪ ኮሚቴ',
        'dereja' => 'ደረጃ ምደባ',
        'zone' => 'ዝተመደበሉ ዞባ',
        'woreda' => 'ዝተመደበሉ ወረዳ',
        'tabiaID' => 'ዝተመደበሉ ጣብያ',
        'proposerWidabe' =>'ዝተመደበሉ ውዳበ',
        'proposerWahio' => 'ዝተመደበሉ ዋህዮ',
        'awekakla' => 'ኣወኻኽላ',
        'type' => 'ዝተመደበሉ ቦታ',
        'reason' => 'ዝተመደበሉ ምኽንያት',
        'proposedBy' => 'መበገሲ ሓሳብ ዘቕረበ ኣካል',
        'commentedBy' => 'ርእይቶ ዝሃበ ኣካል',
        'approvedBy' => 'ዘፅደቐ ኣካል',
        'startDate' => 'ምደባ ዝጀመረሉ ዕለት',
        'endDate' => 'ምደባ ዘብቀዐሉ ዕለት',
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
            $validator->errors()->add('duplicate', 'ኣባል ንምምዳብ እኹል ፍቓድ ኣይብሎምን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $hitsuy = ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->first()->toArray();
        if($hitsuy['assignedWahio'] == $request->proposerWahio){
            $validator->errors()->add('duplicate', 'ኣባል ናብ ዘለዎ ቦታ ክምደብ ኣይኽእልን');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $Mideba = new Mideba;
        $oldPlace = $this->getCodesFromWahio($hitsuy['assignedWahio']);
        $Mideba->hitsuyID = $request->hitsuyID;
        $Mideba->birkiCommittee = $request->birkiCommittee;
        $Mideba->deraja = $request->dereja;
        $Mideba->awekakla = $request->awekakla;
        $Mideba->type = $request->type;
        $Mideba->reason = $request->reason;
        $Mideba->proposedBy = $request->proposedBy;
        $Mideba->commentedBy = $request->commentedBy;
        $Mideba->approvedBy = $request->approvedBy;
        $Mideba->startDate = DateConvert::correctDate($request->startDate);

        $Mideba->zone = $request->zone;
        $Mideba->woreda = $request->woreda;
        $Mideba->tabia = $request->tabiaID;
        $Mideba->assignedWudabe = $request->proposerWidabe;
        $Mideba->assignedWahio = $request->proposerWahio;
        $Mideba->oldzone = $oldPlace[4];
        $Mideba->oldworeda = $oldPlace[3];
        $Mideba->oldtabia = $oldPlace[2];
        $Mideba->oldassignedWudabe = $oldPlace[1];
        $Mideba->oldassignedWahio = $oldPlace[0];


        $Mideba->endDate = DateConvert::correctDate($request->startDate);//endDate);
        $Mideba->isProposed = $request->isProposed;
        $Mideba->approvedWudabe = $request->approvedWudabe;
        $Mideba->save();  
        
        $zone=$request->zone;
        $woreda=$request->woreda;
        $tabia = $request->tabiaID;
        $zoneworedaCode="$zone$woreda$tabia";
        $wdabetype = meseretawiWdabe::where('widabeCode', $request->proposerWidabe)->pluck('type')->first();
        ApprovedHitsuy::where('hitsuyID',$request->hitsuyID)->update(['zoneworedaCode' => $zoneworedaCode,
            'assignedWudabe' => $request->proposerWidabe,
            'assignedWahio' => $request->proposerWahio,
            'wudabeType' => $wdabetype]);
    
        Toastr::info("ምደባ ብትኽክል ተመዝጊቡ ኣሎ");
        return back();
    }
    public function editMideba(Request $request)
    {
        $messages = [
            'same'    => 'The :attribute and :other must match.',
            'size'    => 'The :attribute must be exactly :size.',
            'between' => 'The :attribute value :input is not between :min - :max.',
            'after'      => 'ምደባ ዝጀመረሉ ዕለት ካብ ምደባ ዘብቀዐሉ ዕለት ክቕድም ኣለዎ።',
            'required' => ':attribute ብትኽክል ኣይኣተወን።',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ'
        ];
        $validator = \Validator::make($request->all(),[ 
            'hitsuyID' => 'required',
            'birkiCommittee' => 'required|in:መሰረታዊ ውዳበ ኮሚቴ,ጣብያ ኮሚቴ,ወረዳ/ክፍለከተማ ኮሚቴ,ዞባ ኮሚቴ,ተራ ኣባል,ካልእ',
            'dereja' => 'required',
            // 'zone' => 'required',
            // 'woreda' => 'required',
            // 'tabiaID' => 'required',
            // 'proposerWidabe' =>'required',
            // 'proposerWahio' => 'required',
            'awekakla' => 'required',
            'type' => 'required',
            'approvedBy' => 'required',
            'reason' => 'required|in:ቕፅዓት,ዕቤት,ናይ ውዳበ ውሳነ(ንስራሕ),ናይ ኣባል ሕቶ(ማሕበራዊ),ካሊእ',
            'startDate' => 'required|ethiopian_date'
            //'endDate' => 'required|ethiopian_date|after:startDate'

        ],$messages);
        $fieldNames = [
        'hitsuyID' => 'መለለዪ ሕፁይ',
        'birkiCommittee' => 'ዝተመደበሉ ብርኪ ኮሚቴ',
        'dereja' => 'ደረጃ ምደባ',
        'zone' => 'ዝተመደበሉ ዞባ',
        'woreda' => 'ዝተመደበሉ ወረዳ',
        'tabiaID' => 'ዝተመደበሉ ጣብያ',
        'proposerWidabe' =>'ዝተመደበሉ ውዳበ',
        'proposerWahio' => 'ዝተመደበሉ ዋህዮ',
        'awekakla' => 'ኣወኻኽላ',
        'type' => 'ዝተመደበሉ ቦታ',
        'reason' => 'ዝተመደበሉ ምኽንያት',
        'proposedBy' => 'መበገሲ ሓሳብ ዘቕረበ ኣካል',
        'commentedBy' => 'ርእይቶ ዝሃበ ኣካል',
        'approvedBy' => 'ዘፅደቐ ኣካል',
        'startDate' => 'ምደባ ዝጀመረሉ ዕለት',
        'endDate' => 'ምደባ ዘብቀዐሉ ዕለት',
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
            $validator->errors()->add('duplicate', 'ኣባል ንምምዳብ እኹል ፍቓድ ኣይብሎምን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $mid = Mideba::find ( $request->id );             
        $mid->birkiCommittee = $request->birkiCommittee;
        $mid->deraja = $request->dereja;
        $mid->awekakla = $request->awekakla;
        $mid->type = $request->type;
        $mid->reason = $request->reason;
        $mid->proposedBy = $request->proposedBy;
        $mid->commentedBy = $request->commentedBy;
        $mid->approvedBy = $request->approvedBy;
        $mid->startDate = DateConvert::correctDate($request->startDate);

        $mid->endDate = DateConvert::correctDate($request->startDate);//endDate);
        $mid->save();
       UserAction::storeAction('', 'midebas', Constant::CREATE, Constant::MIDEBA, ['መ.ቁ ኣባል' => $request->hitsuyID,'ካብ ዞባ' => $request->oldzone, 'ወረዳ' => $request->oldworeda, 'ናብ ዞባ' => $request->zone, 'ወረዳ' => $request->woreda, 'ምኽንያት' => $request->reason, 'ኮሚቴ' => $request->birkiCommittee,'ደረጃ ምደባ' => $request->dereja, 'ዝውውውር ዝጅምረሉ ዕለት' =>DateConvert::correctDate($request->transStart)], false, []); 
        // $zone = $request->zone;
        // $woreda = $request->woreda;
        // $tabia = $request->tabiaID;
        // $zoneworedaCode = "$zone$woreda$tabia";
        // $wdabetype = meseretawiWdabe::where('widabeCode', $request->proposerWidabe)->pluck('type')->first();
        // ApprovedHitsuy::where('hitsuyID',$request->hitsuyID)->update(['zoneworedaCode' => $zoneworedaCode,
        //     'assignedWudabe' => $request->proposerWidabe,
        //     'assignedWahio' => $request->proposerWahio,
        //     'wudabeType' => $wdabetype]);
        return [true, 'success', "ምደባ ተስተኻኺሉ ኣሎ"];
    }
    public function deleteMideba(Request $request)
    {
        $data = Mideba::find($request->id);
        if($data){
            $zoneworedaCode = $data->oldzone.$data->oldworeda.$data->oldtabia;
            $wdabetype = meseretawiWdabe::where('widabeCode', $data->oldassignedWudabe)->pluck('type')->first();
            DB::transaction(function() use($data, $request, $zoneworedaCode, $wdabetype){
                ApprovedHitsuy::where('hitsuyID',$data->hitsuyID)->update(['zoneworedaCode' => $zoneworedaCode,
                    'assignedWudabe' => $data->oldassignedWudabe,
                    'assignedWahio' => $data->oldassignedWahio,
                    'wudabeType' => $wdabetype]);
                $data->delete();
            });
            return [true, "ምደባ ብትኽክል ተሰሪዙ ኣሎ"];
        }
        return [true, "ምደባ ክርከብ ኣይኸኣለን"];
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
      $crud = Mideba::find($id);
        
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
         $crud = Mideba::find($id);
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
