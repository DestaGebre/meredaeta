<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Siltena;
use  App\Hitsuy;
use  App\Filter;
use  App\ApprovedHitsuy;
use App\DateConvert;
use App\Constant;
use DB;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
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
    public function index(Request $request)
    {
        //
        // $data = Hitsuy::where('hitsuy_status','ኣባል')->get(); 
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];

        $leader_types = ['ኩሎም', 'ጀማሪ ኣመራርሓ', 'ማእኸላይ ኣመራርሓ', 'ላዕለዋይ ኣመራርሓ', 'ታሕተዋይ ኣመራርሓ'];
        $show = $request->show ? ($request->show == 'ኩሎም'? $leader_types: [$request->show]) : $leader_types;
        $show_name = $request->show ? $request->show : 'ኩሎም';
        if($request->show == 'ታሕተዋይ ኣመራርሓ'){
            $show[] = 'መ/ዉ/አመራርሓ';
            $show[] = 'ዋህዮ ኣመራርሓ';
        }
        // $value = Auth::user()->area;
        // if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
        //     $value = '__'.$value;
        // }
        $query = ApprovedHitsuy::where('approved_status','1')->where('zoneworedaCode', 'LIKE', $filter['new_value'].'%')->whereIn('memberType', $show);
        if($filter['widabe']){
            $query = $query->where('assignedWudabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('assignedWahio', $filter['wahio']->id);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $mwidabedata = DB::table("meseretawi_wdabes")->pluck("widabeName","widabeCode");
        $wahiodata = DB::table("wahios")->pluck("wahioName","id");
        
        return view ('membership.training',compact('data','zobadatas','wahiodata','mwidabedata', 'leader_types', 'show', 'show_name', 'zoneCode', 'filter'));
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
            'integer' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ'
        ];
        $validator = \Validator::make($request->all(), [  
            'memeberID' => 'required',
            'trainingLevel' => 'required|in:ጀማሪ ኣመራርሓ ስልጠና,ማእኸላይ ኣመራርሓ ስልጠና,ላዕለዋይ ኣመራርሓ ስልጠና',
            'trainer' => 'required',
            'trainingPlace' => 'required',
            'trainingType' => 'required|in:ናይ ውድብ,ናይ መንግስቲ',
            'zoneDecision' => 'required',  
            'woredaApproved' => 'required',                     
            'numDays' => 'required|integer',
            'startDate' => 'required|ethiopian_date',
            'endDate' => 'required|ethiopian_date'

        ],$messages);
        $fieldNames = [
        'memeberID' => 'መፍለዪ ቑፅሪ ኣባላት',
        'trainingLevel' => 'ዝወሰዶ ስልጠና ',
        'trainer' => 'ስልጠና ዝሃበ ኣካል',
        'trainingPlace' => 'ናይ ስልጠና ቦታ',
        'trainingType' => 'ዝተውሃበ ስልጠና',
        'zoneDecision' => 'ናይ ዞባ ውሳነ ቐሪቡ',  
        'woredaApproved' => 'ናይ ወረዳ ውሳነ ቐሪብ',                     
        'numDays' => 'ጠቕላላ ናይ ስልጠና መዓልትታት',
        'startDate' => 'ስልጠና ዝጀመረሉ ዕለት',
        'endDate' => 'ስልጠና ዝተወደአሉ ዕለት'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        $memeberIDs=json_decode($request->memeberID);
        // update approved based on type of training, ow don't update status
        // $plausible = ['ተራ ኣባል' => 'ጀማሪ ኣመራርሓ ስልጠና', 'ሲቪል ሰርቫንት' => 'ጀማሪ ኣመራርሓ ስልጠና', 'ጀማሪ ኣመራርሓ' => 'ታሕተዋይ ኣመራርሓ ስልጠና', 'ታሕተዋይ ኣመራርሓ' => 'ማእኸላይ ኣመራርሓ ስልጠና', 'ማእኸላይ ኣመራርሓ' => 'ላዕለዋይ ኣመራርሓ ስልጠና', 'ላዕለዋይ ኣመራርሓ' => ''];
        // $next_level = ['ተራ ኣባል' => 'ጀማሪ ኣመራርሓ', 'ሲቪል ሰርቫንት' => 'ጀማሪ ኣመራርሓ', 'ጀማሪ ኣመራርሓ' => 'ታሕተዋይ ኣመራርሓ', 'ታሕተዋይ ኣመራርሓ' => 'ማእኸላይ ኣመራርሓ', 'ማእኸላይ ኣመራርሓ' => 'ላዕለዋይ ኣመራርሓ', 'ላዕለዋይ ኣመራርሓ' => ''];
        $plausible = ['ተራ ኣባል' => 'ጀማሪ ኣመራርሓ ስልጠና', 'ታሕተዋይ ኣመራርሓ' => 'ጀማሪ ኣመራርሓ ስልጠና', 'ሲቪል ሰርቫንት' => 'ጀማሪ ኣመራርሓ ስልጠና', 'ጀማሪ ኣመራርሓ' => 'ማእኸላይ ኣመራርሓ ስልጠና', 'መ/ዉ/አመራርሓ' => 'ማእኸላይ ኣመራርሓ ስልጠና', 'ዋህዮ ኣመራርሓ' => 'ማእኸላይ ኣመራርሓ ስልጠና', 'ማእኸላይ ኣመራርሓ' => 'ላዕለዋይ ኣመራርሓ ስልጠና', 'ላዕለዋይ ኣመራርሓ' => ''];
        $next_level = ['ተራ ኣባል' => 'ጀማሪ ኣመራርሓ','ታሕተዋይ ኣመራርሓ' => 'ጀማሪ ኣመራርሓ', 'ሲቪል ሰርቫንት' => 'ጀማሪ ኣመራርሓ', 'ጀማሪ ኣመራርሓ' => 'ማእኸላይ ኣመራርሓ','መ/ዉ/አመራርሓ' => 'ማእኸላይ ኣመራርሓ', 'ዋህዮ ኣመራርሓ' => 'ማእኸላይ ኣመራርሓ', 'ማእኸላይ ኣመራርሓ' => 'ላዕለዋይ ኣመራርሓ', 'ላዕለዋይ ኣመራርሓ' => ''];
        $value = Auth::user()->area;
        if(Auth::user()->usertype=='woreda' || Auth::user()->usertype=='woredaadmin'){
            $value = '__'.$value;
        }
        DB::beginTransaction();
        foreach($memeberIDs as $hID) {
            if(!ApprovedHitsuy::where('hitsuyID', $hID)->count()){
                $validator->errors()->add('duplicate', 'ስልጠና ኣይተመዝገበን መለለዪ ኣባል '.$hID.' ኣብ መዝገብ ኣይተረኸበን');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];
            }
            if(!ApprovedHitsuy::where('hitsuyID', $hID)->where('zoneworedaCode','LIKE', $value.'%')->count()){
                $validator->errors()->add('duplicate', 'ስልጠና ኣይተመዝገበን ናይ መለለዪ ኣባል '.$hID.' ስልጠና ንምምዝጋብ እኹል ፍቓድ ኣይብሎምን');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];
            }

            $member = ApprovedHitsuy::where('hitsuyID', $hID)->first();

            if(!isset($plausible[$member->memberType])){
                $validator->errors()->add('duplicate', 'ስልጠና ኣይተመዝገበን<br> '.$hID.' (' . $member->memberType . ') ' . $request->trainingLevel . ' ደረጃ ስልጠና ኣይተፈልጠን');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];
            }

            if($request->trainingLevel != $plausible[$member->memberType]){
                $validator->errors()->add('duplicate', 'ስልጠና ኣይተመዝገበን<br> '.$hID.' (' . $member->memberType . ') ' . $request->trainingLevel . ' ክወስድ ኣይኽእልን');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];

            }


            $data = new Siltena;                   
            $data->hitsuyID = $hID; 
            $data->trainingLevel = $request->trainingLevel;
            $data->trainer = $request->trainer;
            $data->startDate = DateConvert::correctDate($request->startDate);
            $data->endDate = DateConvert::correctDate($request->endDate);
            $data->numDays = $request->numDays;
            $data->trainingPlace = $request->trainingPlace;
            $data->trainingType = $request->trainingType;
            $data->zoneDecision = $request->zoneDecision;
            $data->woredaApproved =$request->woredaApproved;
            $data->zoneApproved =$request->zoneApproved;
            $data->officeApproved =$request->officeApproved;
            $data->isDocumented =$request->isDocumented;
            $data->save();

            ApprovedHitsuy::where('hitsuyID', $hID)->update(['memberType' => $next_level[$member->memberType]]);
            
        }
        DB::commit();
        return [true, "info", "ስልጠና ብትክክል ተመዝጊቡ ኣሎ"];
        // return response ()->json ( $hID ); 
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
