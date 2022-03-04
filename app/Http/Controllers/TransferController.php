<?php

namespace App\Http\Controllers;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;


use App\Http\Requests;
use  App\Transfer;
use  App\Zobatat;
use  App\ApprovedHitsuy;
use App\meseretawiWdabe;
use App\Wahio;
use App\DateConvert;
use App\Constant;
use App\UserAction;
use DB;
use Illuminate\Http\Request;

class TransferController extends Controller
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
        $data = Transfer::where($key, 'LIKE', $value.'%')->paginate(Constant::PAGE_SIZE);
        $tabianame = DB::table("tabias")->pluck("tabiaName","tabiaCode");
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");
        $woredaname = DB::table("woredas")->pluck("name","woredacode");
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
       return view ('membership.transfer',compact('data','zobadatas','tabiadata','woredaname','woredadata','tabianame'));
    }

    public function listTransfers()
    {
        //
        $data = Transfer::all();
        $tabianame = DB::table("tabias")->pluck("tabiaName","tabiaCode");
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");
        $woredaname = DB::table("woredas")->pluck("name","woredacode");
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
       return view ('membership.transferlist',compact('data','zobadatas','tabiadata','woredaname','woredadata','tabianame'));
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
    public function store(Request $request)
    {
        $messages = [
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'alpha' => ':attribute ፊደላት ጥራሕ ክኸውን ኣለዎ',
            'after' => 'ዝውውር ዝጅምረሉ ዕለት ካብ ዝውውር ዘብቅዐሉ ዕለት ክቕድም ኣለዎ'
        ];
        //
        $validator = \Validator::make($request->all(),[ 
            'hitsuyID' => 'required',
            'commite' => 'required|in:መሰረታዊ ውዳበ ኮሚቴ,ጣብያ ኮሚቴ,ወረዳ ኮሚቴ,ዞባ ኮሚቴ,ማእኸላይ ኮሚቴ,ማእኸላይ ኮሚቴ',
            'level' => 'required|in:ኣባል,ፀሓፊ,ሰብሳቢ',
            'place' => 'required|in:ናይ ውድብ,ናይ መንግስቲ',
            'zone' => 'required',
            'woreda' => 'required',
            'tabiaID' => 'required',
            'proposerWidabe' => 'required',
            'proposerWahio' => 'required',
            'reason' => 'required|in:ቕፅዓት,ዕቤት,ናይ ውዳበ ውሳነ(ንስራሕ),ናይ ኣባል ሕቶ(ማሕበራዊ),ካሊእ',
            'transStart' => 'required|ethiopian_date',
            // 'transend' => 'required|ethiopian_date|after:transStart'
        ],$messages);
        $fieldNames = [
        "hitsuyID" => "መለለዩ ሕፁይ",
        "commite" => "ዝተዛወረሉ ኮሚቴ",
        "level" => "ደረጃ ዝውውር",
        "place" => "ዝተዛወረሉ ቦታ",
        'zone' => 'ዝተዛወረሉ ዞባ',
        'woreda' => 'ዝተዛወረሉ ወረዳ',
        'tabiaID' => 'ዝተዛወረሉ ጣብያ',
        'proposerWidabe' => 'ዝተዛወረሉ መሰረታዊ ውዳበ',
        'proposerWahio' => 'ዝተዛወረሉ ዋህዮ',
        'office' => 'ቤ/ፅሕፈት(ትካል)',
        'position' => 'ሓላፍነት',
        'transby' => 'ዘዛወረ ኣካል',
        'approvedby' => 'ዘፅደቐ ኣካል',
        "placement" => "ምድብ ስራሕ",
        "reason" => 'ዝተዛወረሉ ምኽንያት',
        "transStart" => 'ዝውውር ዝጀመረሉ ዕለት',
        "transend" => 'ዝውውር ዘብቀዐሉ ዕለት',];
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
            $validator->errors()->add('duplicate', 'ኣባል ንምዝውዋር እኹል ፍቓድ ኣይብሎምን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $hitsuy = ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->first()->toArray();
        if($hitsuy['assignedWahio'] == $request->proposerWahio){
            $validator->errors()->add('duplicate', 'ኣባል ናብ ዘለዎ ቦታ ክዛወር ኣይኽእልን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $transfer = new Transfer;
        $oldPlace = $this->getCodesFromWahio($hitsuy['assignedWahio']);
        $transfer->hitsuyID = $request->hitsuyID;
        $transfer->committee = $request->commite;
        $transfer->dereja = $request->level;
        $transfer->place = $request->place;
        //zone woreda should not be saved only fetched(not from ID but from zoneworedaCode)
        $transfer->zone = $request->zone;
        $transfer->woreda = $request->woreda;
        $transfer->tabia = $request->tabiaID;
        $transfer->assignedWudabe = $request->proposerWidabe;
        $transfer->assignedWahio = $request->proposerWahio;
        $transfer->oldzone = $oldPlace[4];//$request->oldzone;
        $transfer->oldworeda = $oldPlace[3];//$request->oldworeda;
        $transfer->oldtabia = $oldPlace[2];
        $transfer->oldassignedWudabe = $oldPlace[1];//$request->oldproposerWidabe;
        $transfer->oldassignedWahio = $oldPlace[0]; //$request->oldassignedWahio;
        // $transfer->oldposition = $request->oldposition;

        $transfer->reason = $request->reason;
        $transfer->assignment = $request->placement;
        $transfer->office = $request->office;
        $transfer->position = $request->position;
        $transfer->transferedBy = $request->transby;
        $transfer->approvedBy = $request->transby;
        $transfer->startDate = DateConvert::correctDate($request->transStart);
        $transfer->isProposed = $request->isReported;
        $transfer->approvedWudabe = $request->isApproved;
        $transfer->partyPos = $request->isApproved2;
        
        // ApprovedHitsuy::where('hitsuyID',$request->hitsuyID)->update(['approved_status' => 'ዝተዛወረ']);
        $zone = $request->zone;
        $woreda = $request->woreda;
        $tabia = $request->tabiaID;
        $zoneworedaCode="$zone$woreda$tabia";
        DB::transaction(function() use($transfer, $request, $zoneworedaCode){
            $transfer->save();  
            $wdabetype = meseretawiWdabe::where('widabeCode', $request->proposerWidabe)->pluck('type')->first();
            ApprovedHitsuy::where('hitsuyID',$request->hitsuyID)->update(['zoneworedaCode' => $zoneworedaCode,
            'assignedWudabe' => $request->proposerWidabe,
            'assignedWahio' => $request->proposerWahio,
            'wudabeType' => $wdabetype]);
        });

        Toastr::info("ዝውውር ብትኽክል ተመዝጊቡ ኣሎ");
          UserAction::storeAction('', 'transfers', Constant::CREATE, Constant::TRANSFER, ['መ.ቁ ኣባል' => $request->hitsuyID,'ካብ ዞባ' => $request->oldzone, 'ወረዳ' => $request->oldworeda, 'ናብ ዞባ' => $request->zone, 'ወረዳ' => $request->woreda, 'ምኽንያት' => $request->reason,  'ዝውውውር ዝጅምረሉ ዕለት' =>DateConvert::correctDate($request->transStart)], false, []); 
        return back();
    }
     public function editTransfer(Request $request)
    {
        $messages = [
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'alpha' => ':attribute ፊደላት ጥራሕ ክኸውን ኣለዎ',
            'after' => 'ዝውውር ዝጅምረሉ ዕለት ካብ ዝውውር ዘብቅዐሉ ዕለት ክቕድም ኣለዎ'
        ];
        //
        $validator = \Validator::make($request->all(),[ 
            'id' => 'required',
            'hitsuyID' => 'required',
            'commite' => 'required|in:መሰረታዊ ውዳበ ኮሚቴ,ጣብያ ኮሚቴ,ወረዳ ኮሚቴ,ዞባ ኮሚቴ,ማእኸላይ ኮሚቴ,ማእኸላይ ኮሚቴ',
            'level' => 'required|in:ኣባል,ፀሓፊ,ሓላፊ',
            'place' => 'required|in:ናይ ውድብ,ናይ መንግስቲ',
            'zone' => 'required',
            'woreda' => 'required',
            'tabiaID' => 'required',
            'proposerWidabe' => 'required',
            'proposerWahio' => 'required',
            'office' => 'required',
            'position' => 'required',
            'transby' => 'required',
            'approvedby' => 'required',
            'placement' => 'required',
            'reason' => 'required|in:ቕፅዓት,ዕቤት,ናይ ውዳበ ውሳነ(ንስራሕ),ናይ ኣባል ሕቶ(ማሕበራዊ),ካሊእ',
            'transStart' => 'required|ethiopian_date',
            // 'transend' => 'required|ethiopian_date|after:transStart'
        ],$messages);
        $fieldNames = [
        "id" => "መለለዪ ዝውውር",
        "hitsuyID" => "መለለዩ ሕፁይ",
        "commite" => "ዝተዛወረሉ ኮሚቴ",
        "level" => "ደረጃ ዝውውር",
        "place" => "ዝተዛወረሉ ቦታ",
        'zone' => 'ዝተዛወረሉ ዞባ',
        'woreda' => 'ዝተዛወረሉ ወረዳ',
        'tabiaID' => 'ዝተዛወረሉ ጣብያ',
        'proposerWidabe' => 'ዝተዛወረሉ መሰረታዊ ውዳበ',
        'proposerWahio' => 'ዝተዛወረሉ ዋህዮ',
        'office' => 'ቤ/ፅሕፈት(ትካል)',
        'position' => 'ሓላፍነት',
        'transby' => 'ዘዛወረ ኣካል',
        'approvedby' => 'ዘፅደቐ ኣካል',
        "placement" => "ምድብ ስራሕ",
        "reason" => 'ዝተዛወረሉ ምኽንያት',
        "transStart" => 'ዝውውር ዝጀመረሉ ዕለት',
        "transend" => 'ዝውውር ዘብቀዐሉ ዕለት',];
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
            $validator->errors()->add('duplicate', 'ኣባል ንምዝውዋር እኹል ፍቓድ ኣይብሎምን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
       $trans = Transfer::find ( $request->id );
       if($trans->oldassignedWahio == $request->proposerWahio){
            $validator->errors()->add('duplicate', 'ኣባል ናብ ዘለዎ ቦታ ክዛወር ኣይኽእልን');
            return [false, 'error', $validator->errors()->all()];
       }
        $trans->committee = $request->commite;
        $trans->dereja = $request->level;
        $trans->place = $request->place;
        $trans->zone = $request->zone;
        $trans->woreda = $request->woreda;
        $trans->assignedWudabe = $request->proposerWidabe;
        $trans->assignedWahio = $request->proposerWahio;
        $trans->reason = $request->reason;
        $trans->assignment = $request->placement;
        $trans->office = $request->office;
        $trans->position = $request->position;
        $trans->transferedBy = $request->transby;
        $trans->approvedBy = $request->approvedby;
        $trans->startDate = DateConvert::correctDate($request->transStart);
        $trans->save();

        $zone = $request->zone;
        $woreda = $request->woreda;
        $tabia = $request->tabiaID;
        $zoneworedaCode = "$zone$woreda$tabia";
        $wdabetype = meseretawiWdabe::where('widabeCode', $request->proposerWidabe)->pluck('type')->first();
        ApprovedHitsuy::where('hitsuyID',$request->hitsuyID)->update(['zoneworedaCode' => $zoneworedaCode,
            'assignedWudabe' => $request->proposerWidabe,
            'assignedWahio' => $request->proposerWahio,
            'wudabeType' => $wdabetype]);
        return [true, 'success', "ዝውውር ተስተኻኺሉ ኣሎ"];
    }
     public function deleteTransfer(Request $request)
    {
        $data =Transfer::find($request->id);
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
            return [true, "ዝውውር ብትኽክል ተሰሪዙ ኣሎ"];
        }
        return [true, "ዝውውር ክርከብ ኣይኸኣለን"];
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
         $crud = Transfer::find($id);
        
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
        $crud = Transfer::find($id);
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
