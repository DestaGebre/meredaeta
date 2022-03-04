<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\Srire;
use  App\Zobatat;
use  App\Woreda;
use  App\meseretawiWdabe;
use  App\Wahio;
use App\Constant;
use App\Filter;
use App\UserAction;
use App\User;
use DB;

use Illuminate\Http\Request;

class UserActionController extends Controller
{   
    public function __construct()    //if not authenticated redirect to login
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $filter = Filter::filter_values($request);
        $recordid = isset($filter['recordid']) ? $filter['recordid'] : '';
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $zoneCode = $filter['zoneCode'];
        $code = ($zoneCode ? $zoneCode : '__');
        $query = ($filter['specific']) ? UserAction::where('action', $filter['action']) : UserAction::where('action', 'LIKE', '%');
        $data = null;
        if(Auth::user()->usertype == 'woredaadmin'){
            $data = $query->whereIn('userid', function($query){
                $query->select('id')
                ->from(with(new User)->getTable())
                ->whereIn('usertype', ['woreda', 'woredaadmin'])
                ->where('area', Auth::user()->area);
            })->paginate(Constant::PAGE_SIZE);    
        }
        else if(Auth::user()->usertype == 'zoneadmin'){
         $subquery = null;
         if($filter['woreda']){
            $subquery = [$filter['woreda']->woredacode];
         }
         else{
            $subquery = function($query){
                    $query->select('woredacode')
                    ->from(with(new Woreda)->getTable())
                    ->where('zoneCode', Auth::user()->area);
                };
         }
         $data = $query->where('recordid', 'LIKE', $recordid . '%')->whereIn('userid', function($query) use($subquery){
                $query->select('id')
                ->from(with(new User)->getTable())
                ->whereIn('usertype', ['woreda', 'woredaadmin'])
                ->whereIn('area', $subquery);
            })->paginate(Constant::PAGE_SIZE);       
        }
        else if(Auth::user()->usertype == 'admin'){
         $query = $query->where('recordid', 'LIKE', $recordid . '%')->whereIn('userid', function($query) use($filter){
                $query->select('id')
                ->from(with(new User)->getTable());
                if($filter['woreda']){
                    $query->whereIn('usertype', ['woreda', 'woredaadmin'])->whereIn('area', [$filter['woreda']->woredacode]);
                }
                else if($filter['zoneCode']){
                    $query->whereIn('usertype', ['zone', 'zoneadmin'])->whereIn('area', [$filter['zoneCode']]);
                }
            });
         if(!$filter['woreda'] && !$request->zone){
            $query->orWhere(function ($query){
                $query->where('userid', Auth::user()->id);
            });
         }
         $data = $query->paginate(Constant::PAGE_SIZE);       
        }
        return view ('useraction.index',compact('data', 'filter', 'zobadatas', 'zoneCode'));
    } 
    public function details(Request $request){
        $action = UserAction::find($request->id);
        $areaDetail = null;
        if(!$action)
            abort(404);
        $user = User::find($action->userid);
        if(Auth::user()->usertype === 'woredaadmin'){
            if($user->area !== Auth::user()->area)
                abort(403);
            $woreda = Woreda::where('woredacode', $area)->first();
            $zone = Zobatat::where('zoneCode', $woreda->zoneCode)->first();
            $areaDetail = $zone->zoneName . '/' . $woreda->name;
        }
        if(Auth::user()->usertype === 'zoneadmin' || Auth::user()->usertype === 'admin'){
            $area = $user->area;
            if(strlen($area) == 2){
                if(Auth::user()->usertype === 'zoneadmin' && $area !== Auth::user()->area)
                    abort(403);
                $zone = Zobatat::where('zoneCode', $area)->first();
                $areaDetail = $zone->zoneName;
            }
            else{
                if(Auth::user()->usertype === 'zoneadmin' && Woreda::where('woredacode', $area)->select('zoneCode')->first()->zoneCode !== Auth::user()->area)
                    abort(403);
                if(!strlen($area))
                    $areaDetail = 'ኣድሚንስትሬተር';
                else{
                    $woreda = Woreda::where('woredacode', $area)->first();
                    $zone = Zobatat::where('zoneCode', $woreda->zoneCode)->first();
                    $areaDetail = $zone->zoneName . '/' . $woreda->name;
                }
            }
        }
        $role = $user->usertype;
        return view('useraction.detail', compact('action', 'areaDetail', 'role'));
    }
    
}
