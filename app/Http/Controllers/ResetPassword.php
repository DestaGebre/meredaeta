<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\User;
use  App\Zobatat;
use  App\Woreda;

use Illuminate\Http\Request;

class ResetPassword extends Controller
{
    public function __construct()    //if not authenticated redirect to login
    {
        // if(Auth::user() && Auth::user()->usertype == 'admin')   //only for admin users
        //     $this->middleware('auth'); 
        // else            
        //     Auth::logout();
        // $this->middleware('auth');
        $this->middleware('App\Http\middleware\AdminMiddleware');
    }

    public function index(Request $request)
    {
        return view ( 'membership.reset' );
    }
    public function reset(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ],
        [
            'required' => ':attribute ኣይተመልአን',
            'email' => ':attribute ብትኽክል ኣይተመልአን',
            'min' => ':attribute ካብ :min ፊደላት ክውሕድ የብሉን',
            'max' => ':attribute ካብ :max ፊደላት ክበዝሕ የብሉን',
        ]);
        $fieldNames = [
            'email' => 'ኢሜይል',
            'password' => 'ፓስዎርድ'
        ];
        if(array_search(Auth::user()->usertype, ['admin', 'zoneadmin', 'woredaadmin']) === false){
            $validator->errors()->add('duplicate', 'እኹል ፍቓድ ኣይብሎምን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $validator->setAttributeNames($fieldNames);
        $validator->validate();
        $u = User::where('email', $request->email)->first();
        if(!$u){
            $validator->errors()->add('duplicate', 'ተጠቃሚ ኣይተረኸበን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(Auth::user()->email == $u->email){
            $validator->errors()->add('duplicate', 'እኹል ፍቓድ ኣይብሎምን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(Auth::user()->usertype == 'admin'){
            $u -> password = bcrypt($request->password);
        }
        if(Auth::user()->usertype == 'zoneadmin'){
            if($u->usertype == 'zone' && $u->area == Auth::user()->area){
                $u -> password = bcrypt($request->password);
            }
            else if(array_search($u->usertype, ['woreda', 'woredaadmin']) !== false && Woreda::where('woredacode',$u->area)->where('zoneCode', Auth::user()->area)->count()){
                $u -> password = bcrypt($request->password);
            }
            else{
                $validator->errors()->add('duplicate', 'እኹል ፍቓድ ኣይብሎምን');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        if(Auth::user()->usertype == 'woredaadmin'){
            if($u->usertype == 'woreda' && $u->area == Auth::user()->area){
                $u -> password = bcrypt($request->password);
            }
            else{
                $validator->errors()->add('duplicate', 'እኹል ፍቓድ ኣይብሎምን');
                return redirect()->back()->withErrors($validator)->withInput();       
            }
        }
        $u->save();
        Toastr::success('ፓስዎርድ ሪሴት ተገይሩ ኣሎ');
        return back();
    }
}
