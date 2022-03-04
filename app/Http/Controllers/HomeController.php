<?php

namespace App\Http\Controllers;

use  App\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use  App\Zobatat;
use  App\Woreda;
use App\Constant;

use  App\Documents;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = null;
        if(Auth::user()->usertype == 'admin'){
            $data = Announcement::orderBy('created_at', 'DESC')
            ->paginate(Constant::ANNOUNCEMENT_SIZE);
        }
        if(array_search(Auth::user()->usertype, ['zone', 'zoneadmin']) !== false){
            $data = Announcement::where('area', 'all')
            ->orWhere(function ($query){
                $query->where('area', 'zone')
                ->where('code', Auth::user()->area);
            })
            ->orWhere(function ($query){
                $query->where('area', 'woreda')
                ->whereIn('code', function($query){
                    $query->select('code')
                    ->from(with(new woreda)->getTable())
                    ->where('zoneCode', '01');
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(Constant::ANNOUNCEMENT_SIZE);
        }
        if(array_search(Auth::user()->usertype, ['woreda', 'woredaadmin']) !== false){
            $data = Announcement::where('area', 'all')
            ->orWhere(function ($query){
                $query->where('area', 'zone')
                ->where('code', Woreda::where('woredacode', Auth::user()->area)->first()->toArray()['zoneCode']);
            })
            ->orWhere(function ($query){
                $query->where('area', 'woreda')
                ->where('code', Auth::user()->area);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(Constant::ANNOUNCEMENT_SIZE);
        }
        $doc = Documents::orderBy('created_at', 'DESC')
        ->paginate(Constant::PAGE_SIZE);
        return view('dashboard', compact('data', 'doc'));
    }
}
