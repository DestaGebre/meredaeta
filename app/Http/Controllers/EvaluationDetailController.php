<?php

namespace App\Http\Controllers;

use Auth;

use  App\ApprovedHitsuy;
use App\SuperLeader;
use App\MiddleLeader;
use App\FirstInstantLeader;
use App\LowerLeader;
use App\Expert;
use App\TaraMember;

use  App\Zobatat;
use  App\Woreda;
use Illuminate\Http\Request;

class EvaluationDetailController extends Controller
{
    public function topleaderDetails(Request $request){
        if(!$request->id || !$request->year || !$request->period)
            return abort(404);
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
        $data = SuperLeader::where('hitsuyID', $id)->where('year', $year)->where('half', $period)->first();
        if(!$data)
            return abort(404);
        $name = $member->hitsuy->name . ' ' . $member->hitsuy->fname . ' ' . $member->hitsuy->gfname;
        $zoneName = Zobatat::where('zoneCode', substr($member->zoneworedaCode, 0, 2))->first()->zoneName;
        $woredaName = Woreda::where('woredacode', substr($member->zoneworedaCode, 2, 3))->first()->name;
        return view ('leadership.topleaderdetail',compact('id', 'year', 'period', 'data', 'name', 'member', 'zoneName', 'woredaName'));
    }
    public function mediumleaderDetails(Request $request){
        if(!$request->id || !$request->year || !$request->period)
            return abort(404);
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
        $data = MiddleLeader::where('hitsuyID', $id)->where('year', $year)->where('half', $period)->first();
        if(!$data)
            return abort(404);
        $name = $member->hitsuy->name . ' ' . $member->hitsuy->fname . ' ' . $member->hitsuy->gfname;
        $zoneName = Zobatat::where('zoneCode', substr($member->zoneworedaCode, 0, 2))->first()->zoneName;
        $woredaName = Woreda::where('woredacode', substr($member->zoneworedaCode, 2, 3))->first()->name;
        return view ('leadership.middleleaderdetail',compact('id', 'year', 'period', 'data', 'name', 'member', 'zoneName', 'woredaName'));
    }
    public function firstinstantleaderDetails(Request $request){
        if(!$request->id || !$request->year || !$request->period)
            return abort(404);
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
        $data = FirstInstantLeader::where('hitsuyID', $id)->where('year', $year)->where('half', $period)->first();
        if(!$data)
            return abort(404);
        $name = $member->hitsuy->name . ' ' . $member->hitsuy->fname . ' ' . $member->hitsuy->gfname;
        $zoneName = Zobatat::where('zoneCode', substr($member->zoneworedaCode, 0, 2))->first()->zoneName;
        $woredaName = Woreda::where('woredacode', substr($member->zoneworedaCode, 2, 3))->first()->name;
        return view ('leadership.firstinstantleaderdetail',compact('id', 'year', 'period', 'data', 'name', 'member', 'zoneName', 'woredaName'));        
    }
    public function lowleaderDetails(Request $request){
        if(!$request->id || !$request->year || !$request->period)
            return abort(404);
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
        $data = LowerLeader::where('hitsuyID', $id)->where('year', $year)->where('half', $period)->first();
        if(!$data)
            return abort(404);
        $name = $member->hitsuy->name . ' ' . $member->hitsuy->fname . ' ' . $member->hitsuy->gfname;
        $zoneName = Zobatat::where('zoneCode', substr($member->zoneworedaCode, 0, 2))->first()->zoneName;
        $woredaName = Woreda::where('woredacode', substr($member->zoneworedaCode, 2, 3))->first()->name;
        return view ('leadership.lowleaderdetail',compact('id', 'year', 'period', 'data', 'name', 'member', 'zoneName', 'woredaName'));                
    }
    public function expertDetails(Request $request){
        if(!$request->id || !$request->year || !$request->period)
            return abort(404);
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
        $data = Expert::where('hitsuyID', $id)->where('year', $year)->where('half', $period)->first();
        if(!$data)
            return abort(404);
        $name = $member->hitsuy->name . ' ' . $member->hitsuy->fname . ' ' . $member->hitsuy->gfname;
        $zoneName = Zobatat::where('zoneCode', substr($member->zoneworedaCode, 0, 2))->first()->zoneName;
        $woredaName = Woreda::where('woredacode', substr($member->zoneworedaCode, 2, 3))->first()->name;
        return view ('leadership.expertdetail',compact('id', 'year', 'period', 'data', 'name', 'member', 'zoneName', 'woredaName'));                
    }
    public function teramemberDetails(Request $request){
        if(!$request->id || !$request->year || !$request->period)
            return abort(404);
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
        $data = TaraMember::where('hitsuyID', $id)->where('year', $year)->where('half', $period)->first();
        if(!$data)
            return abort(404);
        $name = $member->hitsuy->name . ' ' . $member->hitsuy->fname . ' ' . $member->hitsuy->gfname;
        $zoneName = Zobatat::where('zoneCode', substr($member->zoneworedaCode, 0, 2))->first()->zoneName;
        $woredaName = Woreda::where('woredacode', substr($member->zoneworedaCode, 2, 3))->first()->name;
        return view ('leadership.teramemberdetail',compact('id', 'year', 'period', 'data', 'name', 'member', 'zoneName', 'woredaName'));                        
    }
}
