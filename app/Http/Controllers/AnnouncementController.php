<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\Zobatat;
use  App\Woreda;

use  App\Announcement;

class AnnouncementController extends Controller
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
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        $dataAnnouncement = new Announcement;
        $dataAnnouncement->title = $request->title;
        $dataAnnouncement->content = $request->description;
        if(Auth::user()->usertype == 'admin'){
            $dataAnnouncement->area = 'all';
            $dataAnnouncement->areaname = '';
        }
        if(Auth::user()->usertype == 'zoneadmin'){
            $dataAnnouncement->area = 'zone';
            $dataAnnouncement->areaname = Zobatat::where('zoneCode', Auth::user()->area)->first()->toArray()['zoneName'];
        }
        if(Auth::user()->usertype == 'woredaadmin'){
            $dataAnnouncement->area = 'woreda';
            $dataAnnouncement->areaname = Woreda::where('woredacode', Auth::user()->area)->first()->toArray()['name'];
        }
        $dataAnnouncement->code = Auth::user()->area;
        $dataAnnouncement->save();

        return [true, "info", "ሓበሬታ ተመዝጊቡ ኣሎ", $dataAnnouncement->area, $dataAnnouncement->areaname, $dataAnnouncement->id];
        return back();
    }

    public function deleteannouncement(Request $request){
        $validator = \Validator::make($request->all(), [
            "id" => "integer|required",
        ],
        [
            'required' => ':attribute ክምላእ ኣለዎ',
        ]);
        $messages = [
            'id'=> 'መለለዪ ሓበሬታ',
        ];
        $validator->setAttributeNames($messages);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!Announcement::where('id', $request->id)->count()){
            $validator->errors()->add('duplicate', 'ሓበሬታ ኣብ መዝገብ ኣይተረኸበን');
            return [false, 'error', $validator->errors()->all()];
        }
        if(Announcement::where('id', $request->id)->pluck('code')->first() != Auth::user()->area){
            $validator->errors()->add('duplicate', 'ሓበሬታ ንምጥፋእ እኹል ፍቓድ ኣይተውሃቦምን');
            return [false, 'error', $validator->errors()->all()];
        }
        $dataAnnouncement = Announcement::find( $request->id);
        $dataAnnouncement->delete();
        return [true, "info", "ሓበሬታ ጠፊኡ ኣሎ"];
    }
    public function editannouncement(Request $request){
        $validator = \Validator::make($request->all(), [
            "id" => "integer|required",
            "title" => "required",
            "description" => "required",
        ],
        [
            'required' => ':attribute ክምላእ ኣለዎ',
        ]);
        $messages = [
            'id'=> 'መለለዪ ሓበሬታ',
            'title' => 'ርእሲ',
            'description'=> 'ዝርዝር ሓበሬታ',
        ];
        $validator->setAttributeNames($messages);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!Announcement::where('id', $request->id)->count()){
            $validator->errors()->add('duplicate', 'ሓበሬታ ኣብ መዝገብ ኣይተረኸበን');
            return [false, 'error', $validator->errors()->all()];
        }
        if(Announcement::where('id', $request->id)->pluck('code')->first() != Auth::user()->area){
            $validator->errors()->add('duplicate', 'ሓበሬታ ንምስትኽኻል እኹል ፍቓድ ኣይተውሃቦምን');
            return [false, 'error', $validator->errors()->all()];
        }
        $dataAnnouncement = Announcement::find( $request->id);
        $dataAnnouncement->title = $request->title;
        $dataAnnouncement->content = $request->description;
        if(Auth::user()->usertype == 'admin'){
            $dataAnnouncement->area = 'all';
            $dataAnnouncement->areaname = '';
        }
        if(Auth::user()->usertype == 'zoneadmin'){
            $dataAnnouncement->area = 'zone';
            $dataAnnouncement->areaname = Zobatat::where('zoneCode', Auth::user()->area)->first()->toArray()['zoneName'];
        }
        if(Auth::user()->usertype == 'woredaadmin'){
            $dataAnnouncement->area = 'woreda';
            $dataAnnouncement->areaname = Woreda::where('woredacode', Auth::user()->area)->first()->toArray()['name'];
        }
        $dataAnnouncement->code = Auth::user()->area;
        $dataAnnouncement->save();

        return [true, "info", "ሓበሬታ ተመዝጊቡ ኣሎ", $dataAnnouncement->area, $dataAnnouncement->areaname, $dataAnnouncement->id];
    }
}
