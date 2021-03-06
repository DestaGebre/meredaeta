<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;
use  App\ApprovedHitsuy;
use App\TaraMember;
use App\meseretawiWdabe;
use App\Wahio;
use App\Zobatat;
use App\Woreda;
use App\Tabia;
use Illuminate\Http\Request;
use App\Constant;
use App\Filter;

class TaraMembersController extends Controller
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
        $details = null;
        if($request->id && $request->year && $request->period){
            $value = Auth::user()->area;
            if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
                $value = '__'.$value;
            }
            $id = str_replace('_', '/', $request->id);
            $period = $request->period;
            $year = $request->year;
            $member = ApprovedHitsuy::where('hitsuyID','=', $id)->where('zoneworedaCode', 'LIKE', $value.'%')->first();
            if(!$member){
                return abort(404);
            }
            $details = TaraMember::where('hitsuyID', $id)->where('year', $year)->where('half', $period)->first();
        }
       // $data = ApprovedHitsuy::where('approved_status','1')->get();
       $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        
       return view ('membership.teramember',compact('details','zobadatas'));
    }
    public function taramembersIndex(Request $request)
    {
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $data = TaraMember::whereIn('hitsuyID', function($query) use($filter){
            $query->select('hitsuyID')
            ->from(with(new ApprovedHitsuy)->getTable())
            ->where('zoneworedaCode','LIKE', $filter['new_value'] . '%');
            if($filter['widabe']){
                $query = $query->where('assignedWudabe', $filter['widabe']->widabeCode);
            }
            if($filter['wahio']){
                $query = $query->where('assignedWahio', $filter['wahio']->id);
            }
        })->paginate(Constant::PAGE_SIZE);
        // $data=TaraMember::all(); 
        $tabianame = DB::table("tabias")->pluck("tabiaName","tabiaCode");
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");
        $woredaname = DB::table("woredas")->pluck("name","woredacode");
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");    
        return view ('membership.teramemberslist',compact('data','zobadatas','tabianame','tabiadata','woredaname','woredadata', 'zoneCode', 'filter'));
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
    public function editTara(Request $request){
        $messages = [            
            'required' => '*:attribute',
            'integer' => '*:attribute',
            'digits' => '????????????????????? 4 ???????????? ???????????? ?????????',
            'min' => '????????????????????? ????????? :min ???????????? ?????????',
            'max' => '????????????????????? ????????? '.(date('Y')-7).' ???????????? ?????????',
            'between' => '*:attribute',
            'in' => '*:attribute',
        ];
        //
        $validator = \Validator::make($request->all(),[
            'id' => 'required',
            'hitsuyID' => 'required',
            'model' => 'required',            
            'evaluation' => 'required',
            'remark' => 'required',
            'year' => 'required|digits:4|integer|min:1950|max:'.(date('Y')-7)
            // 'half' => 'required|in:6 ?????????,?????????',
        ],$messages);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        $value = Auth::user()->area;
        if(Auth::user()->usertype=='woreda' || Auth::user()->usertype=='woredaadmin'){
            $value = '__'.$value;
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('zoneworedaCode','LIKE', $value.'%')->count()){
            $validator->errors()->add('duplicate', '????????? ?????? ???????????? ?????????');
            return [false, 'error', $validator->errors()->all()];
        }
        if(TaraMember::where('hitsuyID', $request->hitsuyID)->where('year', $request->year)->where('id', '!=', $request->id)/*->where('half', $request->half)*/->count()){
            $validator->errors()->add('duplicate', $request->hitsuyID . ' ?????? ????????? ' . $request->year . ' ??????????????? ?????? :)');
            return [false,  'error', $validator->errors()->all()];   
        }
        $data = TaraMember::where('id', $request->id)->where('hitsuyID', $request->hitsuyID)->first();
        $data->hitsuyID = $request->hitsuyID;
        $data->model = $request->model;
        $data->evaluation = $request->evaluation;
        $data->remark = $request->remark;
        $data->year = $request->year;
        // $data->half = $request->half;
        $data->save();  
        return [true,  'info',"?????? ?????? ????????? ???????????? ?????????????????? ??????"];
    }
    public function deleteTara(Request $request){
        $value = Auth::user()->area;
        $validator = \Validator::make($request->all(),[
            'id' => 'required',
            'hitsuyID' => 'required',
            'year' => 'required|digits:4|integer|min:1950|max:'.(date('Y')-7)
        ]);
        if($validator->fails()){
            return [false];
        }
        if(Auth::user()->usertype=='woreda' || Auth::user()->usertype=='woredaadmin'){
            $value = '__'.$value;
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('zoneworedaCode','LIKE', $value.'%')->count()){
            $validator->errors()->add('duplicate', '????????? ?????? ???????????? ?????????');
            return [false, $validator->errors()->all()];
        }
        /*if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('memberType','????????? ???????????????')->count()){
            $validator->errors()->add('duplicate', '????????? ????????? ??????????????? ???????????????');
            return [false, $validator->errors()->all()];
        }*/
        if(!TaraMember::where('hitsuyID', $request->hitsuyID)->where('year', $request->year)->where('id', $request->id)/*->where('half', $request->half)*/->count()){
            return [false];
        }
        $data = TaraMember::where('id', $request->id)->where('hitsuyID', $request->hitsuyID)->first();
        $data->delete();
        return [true];
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
            'required' => ':attribute ?????????????????????',
            'digits' => '????????????????????? 4 ???????????? ???????????? ?????????',
            'min' => '????????????????????? ????????? :min ???????????? ?????????',
            'max' => '????????????????????? ????????? '.(date('Y')-7).' ???????????? ?????????',
            'in' => ':attribute ???????????? ????????? ?????????????????? ???????????? ?????????',
        ];
        //
        $validator = \Validator::make($request->all(), [
            'hitsuyID' => 'required',
            'model' => 'required',            
            'evaluation' => 'required',
            'remark' => 'required',
            'year' => 'required|digits:4|integer|min:1950|max:'.(date('Y')-7)
            // 'half' => 'required|in:6 ?????????,?????????',
        ],$messages);
        $fieldNames = [
            'hitsuyID' => '???????????? ?????????',
            'model' => '???????????? ?????????',            
            'evaluation' => '???????????? ????????????',
            'remark' => '?????? ????????? ?????? ?????????',
            'year' => '?????????????????????',
            'half' => '????????? ????????????'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        $value = Auth::user()->area;
        if(Auth::user()->usertype=='woreda' || Auth::user()->usertype=='woredaadmin'){
            $value = '__'.$value;
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('zoneworedaCode','LIKE', $value.'%')->count()){
            $validator->errors()->add('duplicate', '????????? ?????? ???????????? ?????????');
            return [false, 'error', $validator->errors()->all()];
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('memberType','?????? ?????????')->count()){
            $validator->errors()->add('duplicate', '????????? ?????? ????????? ???????????????');
            return [false, 'error', $validator->errors()->all()];
        }
        if(TaraMember::where('hitsuyID', $request->hitsuyID)->where('year', $request->year)/*->where('half', $request->half)*/->count()){
            $validator->errors()->add('duplicate', $request->hitsuyID . ' ?????? ????????? ' . $request->year . ' ??????????????? ??????');
            return [false, 'error', $validator->errors()->all()];
        }
        $data = new TaraMember;
        $data->hitsuyID = $request->hitsuyID;
        $data->model = $request->model;
        $data->evaluation = $request->evaluation;
        $data->remark = $request->remark;
        $data->year = $request->year;
        // $data->half = $request->half;
        $data->save();  
        return [true, "info", "?????? ?????? ????????? ???????????? ???????????? ??????????????? ??????????????? ??????"];
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
