<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Auth;
use  App\ApprovedHitsuy;
use  App\Transfer;
use  App\Siltena;
use  App\Penalty;

use App\SuperLeader;
use App\MiddleLeader;
use App\FirstInstantLeader;
use App\LowerLeader;
use App\Expert;
use App\TaraMember;

use  App\Mideba;
use  App\EducationInformation;
use  App\CareerInformation;

class MemberHistory extends Controller
{
    public function index($id, Request $request){
        $value = Auth::user()->area;
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $value = '__'.$value;
        }
        $id = str_replace('_', '/', $id);
        $member = ApprovedHitsuy::where('hitsuyID','=', $id)->where('zoneworedaCode', 'LIKE', $value.'%')->first();
        if(!$member){
            return abort(404);
        }
        $transfers = Transfer::where('hitsuyID', '=', $id)->orderBy('startDate', 'desc')->get();
        $midebas = Mideba::where('hitsuyID', '=', $id)->orderBy('startDate', 'desc')->get();
        $siltenas = Siltena::where('hitsuyID', '=', $id)->orderBy('startDate', 'desc')->get();
        $penalties = Penalty::where('hitsuyID', '=', $id)->orderBy('startDate', 'desc')->get();
        $educations = EducationInformation::where('hitsuyID', '=', $id)->orderBy('graduationDate', 'desc')->get();
        $expriences = CareerInformation::where('hitsuyID', '=', $id)->orderBy('startDate', 'desc')->get();
        $gemgams = false;
        $gemgams_super = SuperLeader::where('hitsuyID', $id)->orderBy('year', 'desc')->orderBy('half', 'desc')->get();
        $gemgams_middle = MiddleLeader::where('hitsuyID', $id)->orderBy('year', 'desc')->orderBy('half', 'desc')->get();
        $gemgams_lower = LowerLeader::where('hitsuyID', $id)->orderBy('year', 'desc')->orderBy('half', 'desc')->get();
        $gemgams_first = FirstInstantLeader::where('hitsuyID', $id)->orderBy('year', 'desc')->orderBy('half', 'desc')->get();
        $gemgams_expert = Expert::where('hitsuyID', $id)->orderBy('year', 'desc')->orderBy('half', 'desc')->get();
        $gemgams_tara = TaraMember::where('hitsuyID', $id)->orderBy('year', 'desc')->orderBy('half', 'desc')->get();
        // if($member->memberType == 'ላዕለዋይ ኣመራርሓ'){
        //     $gemgams = SuperLeader::where('hitsuyID', $id)->orderBy('year', 'desc')->orderBy('half', 'desc')->get();
        // }
        // if($member->memberType == 'ታሕተዋይ ኣመራርሓ'){
        //     $gemgams = LowerLeader::where('hitsuyID', $id)->orderBy('year', 'desc')->orderBy('half', 'desc')->get();
        // }
        return view('membership.history', compact('member', 'transfers', 'midebas', 'siltenas', 'penalties', 'gemgams', 'educations', 'expriences', 'gemgams_super', 'gemgams_middle', 'gemgams_lower', 'gemgams_first', 'gemgams_expert', 'gemgams_tara'));
     }
}
