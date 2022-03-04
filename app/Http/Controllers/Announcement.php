<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\Announcement;

class Announcement extends Controller
{
    public function __construct()    //if not authenticated redirect to login
    {
        // if(Auth::user() && Auth::user()->usertype == 'admin')   //only for admin users
        //     $this->middleware('auth'); 
        // else            
        //     Auth::logout();
        // $this->middleware('auth');
        $this->middleware('App\Http\middleware\StaffMiddleware');
    }

    public function index()
    {
        return view('documents.announcement');
    }

    public function addannouncement(Request $request){
        $validator = \Validator::make($request->all(), [
            "title" => "required",
            "description" => "required",
        ],
        [
            'required' => ':attribute ክምላእ ኣለዎ',
        ]);
        $messages = [
            'title' => 'ርእሲ',
            'description'=> 'ዝርዝር ሓበሬታ',
        ];
        $validator->setAttributeNames($messages);
        $validator->validate();
        $dataAnnouncement = new Announcement;
        $dataAnnouncement->title = $request->title;
        $dataAnnouncement->description = $request->description;

        Toastr::info('ሓበሬታ ተመዝጊቡ ኣሎ');
        return back();
    }
}
