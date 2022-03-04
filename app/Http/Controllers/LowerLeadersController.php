<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;
use  App\ApprovedHitsuy;
use App\LowerLeader;
use App\meseretawiWdabe;
use App\Wahio;
use App\Zobatat;
use App\Woreda;
use App\Tabia;
use App\Constant;
use App\Filter;

class LowerLeadersController extends Controller
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
            $details = LowerLeader::where('hitsuyID', $id)->where('year', $year)->where('half', $period)->first();
        }
       // $data = ApprovedHitsuy::where('approved_status','1')->get();
       $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        
       return view ('membership.lowerleaderform',compact('details','zobadatas'));
    }
    public function lowerleadersIndex(Request $request)
    {
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $data = LowerLeader::whereIn('hitsuyID', function($query) use($filter){
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
        // $data=LowerLeader::all();       
        $tabianame = DB::table("tabias")->pluck("tabiaName","tabiaCode");
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");
        $woredaname = DB::table("woredas")->pluck("name","woredacode");
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view ('membership.lowleaderslist',compact('data','zobadatas','tabiadata','tabianame','woredaname','woredadata', 'zoneCode', 'filter'));
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
    public function editLower(Request $request){
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
            'hitsuyID' => 'required',
            'model' => 'required|in:ሞዴል,ዘይሞዴል',            
            'evaluation' => 'required|in:A,B,C',
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
            return redirect()->back()->withErrors($validator)->withInput();
        }
        /*if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('memberType','ጀማሪ አመራርሓ')->count()){
            $validator->errors()->add('duplicate', 'ኣባል ጀማሪ አመራርሓ ኣይኮነን');
            return redirect()->back()->withErrors($validator)->withInput();
        }*/
        if(LowerLeader::where('hitsuyID', $request->hitsuyID)->where('year', $request->year)->where('id', '!=', $request->id)/*->where('half', $request->half)*/->count()){
            $validator->errors()->add('duplicate', $request->hitsuyID . ' ኣብ ዓመት ' . $request->year . ' ተገምጊሙ እዩ');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = LowerLeader::where('id', $request->id)->where('hitsuyID', $request->hitsuyID)->first();
        $data->hitsuyID = $request->hitsuyID;
        $data->model = $request->model;
        $data->evaluation = $request->evaluation;
        $data->remark = $request->remark;     
        $data->year = $request->year;
        $data->save();
        Toastr::info("ናይ ጀማሪ ኣመራርሓ ማህደር ተስተኻኺሉ ኣሎ");
        return redirect()->back();
    }
    public function deleteLower(Request $request){
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
        if(!LowerLeader::where('hitsuyID', $request->hitsuyID)->where('year', $request->year)->where('id', $request->id)/*->where('half', $request->half)*/->count()){
            return [false];
        }
        $data = LowerLeader::where('id', $request->id)->where('hitsuyID', $request->hitsuyID)->first();
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
    {   //
        $messages = [            
            'required' => ':attribute ብትኽክል ኣይኣተወን',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'max' => 'ዓመተምህረት ቅድሚ '.(date('Y')-7).' ክኸውን ኣለዎ',
        ];
        //
        $validator = \Validator::make($request->all(),[
            'hitsuyID' => 'required',
            'model' => 'required|in:ሞዴል,ዘይሞዴል',            
            'evaluation' => 'required|in:A,B,C',
            'remark' => 'required',
            'year' => 'required|digits:4|integer|min:1950|max:'.(date('Y')-7)
            // 'half' => 'required|in:6 ወርሒ,ዓመት',
        ],$messages);
        $fieldNames = [
            'hitsuyID' => 'መለለዩ ኣባል',
            'model' => 'ዓይነት ኣባል',
            'evaluation' => 'ውፅኢት ገምጋም',
            'remark' => 'ናይ በዓል ዋና ርኢቶ',
            'year' => 'ዓመተ ምህረት',
            'half' => 'እዋን ገምጋም',
        ];
        $validator->setAttributeNames($fieldNames);
        $validator->validate();
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->count()){
            $validator->errors()->add('duplicate', 'ኣባል ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->where('memberType','ታሕተዋይ ኣመራርሓ')->whereNotIn('occupation', ['ሲቪል ሰርቫንት', 'ሰብ ሞያ', 'መምህር'])->count()){
            $validator->errors()->add('duplicate', 'ኣባል ታሕተዋይ ኣመራርሓ ኣይኮነን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(LowerLeader::where('hitsuyID', $request->hitsuyID)->where('year', $request->year)/*->where('half', $request->half)*/->count()){
            $validator->errors()->add('duplicate', $request->hitsuyID . ' ኣብ ዓመት ' . $request->year . ' ተገምጊሙ እዩ');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = new LowerLeader;
        $data->hitsuyID = $request->hitsuyID;
        $data->model = $request->model;
        $data->evaluation = $request->evaluation;
        $data->remark = $request->remark;     
        $data->year = $request->year;
        $data->save();  
  
        Toastr::info("ናይ ታሕተዋይ ኣመራርሓ ኣባላት ህወሓት ማህደር ብትኽክል ተመዝጊቡ ኣሎ");
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
