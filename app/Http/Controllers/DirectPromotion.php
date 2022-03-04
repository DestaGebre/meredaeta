<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use  App\Hitsuy;
use  App\ApprovedHitsuy;

use  App\Zobatat;
use  App\Woreda;
use App\Tabia;
use App\meseretawiWdabe;
use App\Wahio;
use App\Constant;
use App\Filter;
use DB;


class DirectPromotion extends Controller
{
    public function __construct()    //if not authenticated redirect to login
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $query = ApprovedHitsuy::where('zoneworedaCode','LIKE', $filter['new_value'] . '%')->where('approved_status','1');
        if($filter['widabe']){
            $query = $query->where('assignedWudabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('assignedWahio', $filter['wahio']->id);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        return view ('directpromotion', compact('data', 'zoneCode', 'filter', 'zobadatas'));
    }
    public function promote(Request $request){
        $validator = \Validator::make($request->all(), [
            'hitsuyID' => 'required',
            'promotionLevel' => 'required|in:ተራ ኣባል,ጀማሪ ኣመራርሓ,ማእኸላይ ኣመራርሓ,ላዕለዋይ ኣመራርሓ,ታሕተዋይ ኣመራርሓ',
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
        "promotionLevel" => "ደረጃ ኣመራርሓ",];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, $validator->errors()->all()];
        }

        if(!ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->count()){
            $validator->errors()->add('duplicate', 'ኣባል ኣብ መዝገብ የለን');
            return [false,  $validator->errors()->all()];
        }
        $hitsuy = ApprovedHitsuy::where('hitsuyID', $request->hitsuyID)->update(['memberType' => $request->promotionLevel]);
        return [true, "ደረጃ ኣመራርሓ ኣባል ተሰጋጊሩ ኣሎ"];
    }
}
