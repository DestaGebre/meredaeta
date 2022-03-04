<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;
use  App\ApprovedHitsuy;
use App\Expert;
use App\meseretawiWdabe;
use App\Wahio;
use App\Zobatat;
use App\Woreda;
use App\Tabia;
use App\Constant;
use App\Filter;

class ExpertsController extends Controller
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
            $details = Expert::where('hitsuyID', $id)->where('year', $year)->where('half', $period)->first();
        }
       // $data = ApprovedHitsuy::where('approved_status','1')->get();
       $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        
       return view ('membership.expertform',compact('details','zobadatas'));
    }
     public function expertsIndex(Request $request)
    {
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $data = Expert::whereIn('hitsuyID', function($query) use($filter){
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
        // $data=Expert::all();       
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");
        $woredaname = DB::table("woredas")->pluck("name","woredacode");
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view ('membership.expertslist',compact('data','zobadatas','tabiadata','woredaname','woredadata', 'zoneCode', 'filter'));
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
    public function editExpert(Request $request){
        $messages = [            
            'required' => '*:attribute',
            'integer' => '*:attribute',
            'digits' => 'ዓመተምህረት 4 ኣሃዛት ክኸውን ኣለዎ',
            'min' => 'ዓመተምህረት ድሕሪ :min ክኸውን ኣለዎ',
            'max' => 'ዓመተምህረት ቅድሚ '.(date('Y')-7).' ክኸውን ኣለዎ',
            'between' => '*:attribute',
            'in' => '*:attribute',
        ];
        //
        $validator = \Validator::make($request->all(),[
            'id' => 'required',
            'answer1' => 'required',            
            'answer2' => 'required',
            'answer3' => 'required',
            'answer4' => 'required',            
            'answer5' => 'required',
            'answer6' => 'required',
            'answer7' => 'required',            
            'answer8' => 'required',
            'answer9' => 'required',
            'answer10' => 'required',  
            'result1' => 'required|integer|between:0,10',
            'result2' => 'required|integer|between:0,10',
            'result3' => 'required|integer|between:0,10',
            'result4' => 'required|integer|between:0,10',
            'result5' => 'required|integer|between:0,10',
            'result6' => 'required|integer|between:0,10',
            'result7' => 'required|integer|between:0,10',
            'result8' => 'required|integer|between:0,10',
            'remark' => 'required',
            'year' => 'required|digits:4|integer|min:1950|max:'.(date('Y')-7)
            // 'half' => 'required|in:6 ወርሒ,ዓመት',
        ],$messages);
        if($validator->fails()){
            return [false, $validator->errors()->all()];
        }
        $value = Auth::user()->area;
        if(Auth::user()->usertype=='woreda' || Auth::user()->usertype=='woredaadmin'){
            $value = '__'.$value;
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('zoneworedaCode','LIKE', $value.'%')->count()){
            $validator->errors()->add('duplicate', 'ኣባል ኣብ መዝገብ የለን');
            return [false, $validator->errors()->all()];
        }
        if(Expert::where('hitsuyID', $request->hitsuyID)->where('year', $request->year)->where('id', '!=', $request->id)/*->where('half', $request->half)*/->count()){
            $validator->errors()->add('duplicate', $request->hitsuyID . ' ኣብ ዓመት ' . $request->year . ' ተገምጊሙ እዩ');
            return [false, $validator->errors()->all()];   
        }
        $data = Expert::where('id', $request->id)->where('hitsuyID', $request->hitsuyID)->first();
        $data->hitsuyID = $request->hitsuyID;
        $data->answer1 = $request->answer1;
        $data->answer2 = $request->answer2;
        $data->answer3 = $request->answer3;
        $data->answer4 = $request->answer4;
        $data->answer5 = $request->answer5;
        $data->answer6 = $request->answer6;
        $data->answer7 = $request->answer7;
        $data->answer8 = $request->answer8;
        $data->answer9 = $request->answer9;
        $data->answer10 = $request->answer10;
        $data->result1 = $request->result1;
        $data->result2 = $request->result2;
        $data->result3 = $request->result3;
        $data->result4 = $request->result4;
        $data->result5 = $request->result5;
        $data->result6 = $request->result6;
        $data->result7 = $request->result7;
        $data->result8 = $request->result8;
        $data->remark = $request->remark;
        $data->year = $request->year;
        $data->sum = $data->result1 + $data->result2 + $data->result3 + $data->result4 + $data->result5 + $data->result6 + $data->result7 + $data->result8;
        $data->save();  
        return [true, "ናይ ሰብ ሞያ ግምገማ ተስተኻኺሉ ኣሎ"];
    }
    public function deleteExpert(Request $request){
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
            $validator->errors()->add('duplicate', 'ኣባል ኣብ መዝገብ የለን');
            return [false, $validator->errors()->all()];
        }
        /*if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('memberType','ጀማሪ ኣመራርሓ')->count()){
            $validator->errors()->add('duplicate', 'ኣባል ጀማሪ ኣመራርሓ ኣይኮነን');
            return [false, $validator->errors()->all()];
        }*/
        if(!Expert::where('hitsuyID', $request->hitsuyID)->where('year', $request->year)->where('id', $request->id)/*->where('half', $request->half)*/->count()){
            return [false];
        }
        $data = Expert::where('id', $request->id)->where('hitsuyID', $request->hitsuyID)->first();
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
        //
        $messages = [            
            'required' => '*:attribute',
            'integer' => '*:attribute',
            'digits' => 'ዓመተምህረት 4 ኣሃዛት ክኸውን ኣለዎ',
            'min' => 'ዓመተምህረት ድሕሪ :min ክኸውን ኣለዎ',
            'max' => 'ዓመተምህረት ቅድሚ '.(date('Y')-7).' ክኸውን ኣለዎ',
            'between' => '*:attribute',
            'in' => '*:attribute',
        ];
        //
        $validator = \Validator::make($request->all(),[
            'answer1' => 'required',            
            'answer2' => 'required',
            'answer3' => 'required',
            'answer4' => 'required',            
            'answer5' => 'required',
            'answer6' => 'required',
            'answer7' => 'required',            
            'answer8' => 'required',
            'answer9' => 'required',
            'answer10' => 'required',  
            'result1' => 'required|integer|between:0,10',
            'result2' => 'required|integer|between:0,10',
            'result3' => 'required|integer|between:0,10',
            'result4' => 'required|integer|between:0,10',
            'result5' => 'required|integer|between:0,10',
            'result6' => 'required|integer|between:0,10',
            'result7' => 'required|integer|between:0,10',
            'result8' => 'required|integer|between:0,10',
            'remark' => 'required',
            'year' => 'required|digits:4|integer|min:1950|max:'.(date('Y')-7)
            // 'half' => 'required|in:6 ወርሒ,ዓመት',
        ],$messages);
        if($validator->fails()){
            return [false, $validator->errors()->all()];
        }
        $value = Auth::user()->area;
        if(Auth::user()->usertype=='woreda' || Auth::user()->usertype=='woredaadmin'){
            $value = '__'.$value;
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('zoneworedaCode','LIKE', $value.'%')->count()){
            $validator->errors()->add('duplicate', 'ኣባል ኣብ መዝገብ የለን');
            return [false, $validator->errors()->all()];
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->whereIn('memberType',['ተራ ኣባል', 'ታሕተዋይ ኣመራርሓ'])->whereIn('occupation', ['ሲቪል ሰርቫንት', 'ሰብ ሞያ', 'መምህር'])->count()){
            $validator->errors()->add('duplicate', 'ኣባል ሰብ ሞያ ኣይኮነን');
            return [false, $validator->errors()->all()];
        }
        if(Expert::where('hitsuyID', $request->hitsuyID)->where('year', $request->year)/*->where('half', $request->half)*/->count()){
            $validator->errors()->add('duplicate', $request->hitsuyID . ' ኣብ ዓመት ' . $request->year . ' ተገምጊሙ እዩ');
            return [false, $validator->errors()->all()];   
        }
    	$data = new Expert;
        $data->hitsuyID = $request->hitsuyID;
        $data->answer1 = $request->answer1;
        $data->answer2 = $request->answer2;
        $data->answer3 = $request->answer3;
        $data->answer4 = $request->answer4;
        $data->answer5 = $request->answer5;
        $data->answer6 = $request->answer6;
        $data->answer7 = $request->answer7;
        $data->answer8 = $request->answer8;
        $data->answer9 = $request->answer9;
        $data->answer10 = $request->answer10;
        $data->result1 = $request->result1;
        $data->result2 = $request->result2;
        $data->result3 = $request->result3;
        $data->result4 = $request->result4;
        $data->result5 = $request->result5;
        $data->result6 = $request->result6;
        $data->result7 = $request->result7;
        $data->result8 = $request->result8;
        $data->remark = $request->remark;
        $data->year = $request->year;
        $data->sum = $data->result1 + $data->result2 + $data->result3 + $data->result4 + $data->result5 + $data->result6 + $data->result7 + $data->result8;
        $data->save();  
  
        return [true, "ናይ ሰብ ሞያ ኣባላት ህወሓት ማህደር ብትኽክል ተመዝጊቡ ኣሎ"];


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
