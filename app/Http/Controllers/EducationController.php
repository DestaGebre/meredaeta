<?php

namespace App\Http\Controllers;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;


use App\Http\Requests;
use  App\EducationInformation;
use App\ApprovedHitsuy;
use App\Hitsuy;
use App\Constant;

use App\meseretawiWdabe;
use App\Wahio;
use App\Zobatat;
use App\Woreda;
use App\Tabia;
use App\Filter;

use DB;
use Illuminate\Http\Request;

class EducationController extends Controller
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
        $data = EducationInformation::all ();
        return view ('membership.educationinfo')->withData ( $data );
    }
    public function educationIndex(Request $request)
    {
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        // $data = DB::table('education_informations')->join('approved_hitsuys', 'approved_hitsuys.hitsuyID', '=', 'education_informations.hitsuyID')->where('approved_hitsuys.zoneworedaCode', 'LIKE', $value.'%')->get();
        $data = EducationInformation::whereIn('hitsuyID', function($query) use($filter){
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
        // $data = EducationInformation::where('hitsuyID', 'LIKE', $value.'%')->get();
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view ('membership.educationinfo',compact('data','zoneCode', 'filter', 'zobadatas'));
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
        $validator = \Validator::make($request->all(), [
            'hitsuyID' => 'required',
            'educationType' => 'required',
            'educationLevel' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12,ሰርቲፊኬት,ዲፕሎማ,ዲግሪ,ማስተርስ,ፒ.ኤች.ዲ',
            'institute' => 'required',
            'graduationDate' => 'required|digits:4|integer|min:1950|max:'.(date('Y')-7),
            ],
            [
            'required' => ':attribute ኣይተመልአን',
            'digits' => 'ዝተመረቐሉ ግዜ ዓመተ ምህረት ክኸውን ኣለዎ',
            'min' => ':attribute ድሕሪ 1950 ክኸውን ኣለዎ',
            'max' => ':attribute ቅድሚ ክሳብ '.(date('Y')-7).' ክኸውን ኣለዎ',
            'integer' => 'ዝተመረቐሉ ግዜ ዓመተ ምህረት ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            ]);
        $fieldNames = [
        "hitsuyID" => "መለለዩ ሕፁይ",
        "educationType" => "ዓይነት ትምህርቲ",
        "educationLevel" => "ደረጃ ትምህርቲ",
        "institute" => "ዝሃቦ ትካል",
        "graduationDate" => "ዝተመረቐሉ ዓመት",];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, $validator->errors()->all()];
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->count()){
            $validator->errors()->add('duplicate', 'ኣባል ኣብ መዝገብ የለን');
            return [false,  $validator->errors()->all()];
        }
        if(EducationInformation::where('hitsuyID', $request->hitsuyID)->where('educationType', $request->educationType)->where('educationLevel', $request->educationLevel)->count()){
            $validator->errors()->add('duplicate', 'መረዳእታ ትምህርቲ ኣብ መዝገብ ኣሎ');
            return [false,  $validator->errors()->all()];
        }
        $edu = new EducationInformation;
        $edu->hitsuyID = $request->hitsuyID;
        $edu->educationType = $request->educationType;
        $edu->educationLevel = $request->educationLevel;
        $edu->institute = $request->institute;
        $edu->graduationDate = $request->graduationDate;
        $edu->save();  
        $eduArray = ['1','2','3','4','5','6','7','8','9','10','11','12','ሰርቲፊኬት','ዲፕሎማ','ዲግሪ','ማስተርስ','ፒ.ኤች.ዲ'];
        $hitsuy = Hitsuy::find($request->hitsuyID);
        if(array_search($request->educationLevel, $eduArray) > array_search($hitsuy->educationlevel, $eduArray)){
            $hitsuy->educationlevel = $request->educationLevel;
            $hitsuy->save();
        }
        return [true, "ናይ ትምህርቲ መረዳእታ ብትኽክል ተመዝጊቡ ኣሎ"];

    }
    public function editEducation(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id' => 'required',
            'hitsuyID' => 'required',
            'educationType' => 'required',
            'educationLevel' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12,ሰርቲፊኬት,ዲፕሎማ,ዲግሪ,ማስተርስ,ፒ.ኤች.ዲ',
            'institute' => 'required',
            'graduationDate' => 'required|digits:4|integer|min:1950|max:'.(date('Y')-7),
            ],
            [
            'required' => ':attribute ኣይተመልአን',
            'digits' => 'ዝተመረቐሉ ግዜ ዓመተ ምህረት ክኸውን ኣለዎ',
            'min' => ':attribute ድሕሪ 1950 ክኸውን ኣለዎ',
            'max' => ':attribute ቅድሚ '.(date('Y')-7).' ክኸውን ኣለዎ',
            'integer' => 'ዝተመረቐሉ ግዜ ዓመተ ምህረት ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            ]);
        $fieldNames = [
        "id" => "መለለዪ መረዳእታ ትምህርቲ",
        "hitsuyID" => "መለለዩ ሕፁይ",
        "educationType" => "ዓይነት ትምህርቲ",
        "educationLevel" => "ደረጃ ትምህርቲ",
        "institute" => "ዝሃቦ ትካል",
        "graduationDate" => "ዝተመረቐሉ ዓመት",];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->count()){
            $validator->errors()->add('duplicate', 'ኣባል ኣብ መዝገብ የለን');
            return [false,  'error', $validator->errors()->all()];
        }
        if(EducationInformation::where('hitsuyID', $request->hitsuyID)->where('educationType', $request->educationType)->where('educationLevel', $request->educationLevel)->count()){
            $validator->errors()->add('duplicate', 'መረዳእታ ትምህርቲ ኣብ መዝገብ ኣሎ');
            return [false, 'error', $validator->errors()->all()];
        }

       $educ = EducationInformation::find( $request->id );
        $educ->educationType = $request->educationType;
        $educ->educationLevel = $request->educationLevel;
        $educ->institute = $request->institute;
        $educ->graduationDate = $request->graduationDate;
        $educ->save();
        return [true, 'info', "ናይ ትምህርቲ መረዳእታ ብትኽክል ተስተኻኺሉ ኣሎ"];
    }
    public function deleteducation(Request $request)
    {
        $expres =EducationInformation::find($request->id)->delete();
        return [true, "ፎርጅድ ናይ ትምህርቲ መረዳእታ ብትኽክል ተሰሪዙ ኣሎ"];
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
