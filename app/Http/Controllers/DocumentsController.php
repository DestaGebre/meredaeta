<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\Documents;


class DocumentsController extends Controller
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
        return view ('documents.newdocument');
    }

    public function upload(Request $request){
        $validator = \Validator::make($request->all(), [
            "title" => "required",
            "description" => "",
            "file" => "required|mimes:pdf,docx,xlsx|max:2048"
        ],
        [
            'required' => ':attribute ክምላእ ኣለዎ',
            'mimes' => 'ፋይል ዎርድ፣ ፒ.ዲ.ኤፍ ወይ ኤክሴል ክኸውን ክኸውን ኣለዎ',
            'max' => 'ፋይል ካብ 2 ሜጋ ባይት ክዓቢ የብሉን'
        ]);
        $messages = [
            'title' => 'ሽም ፋይል',
            'description'=> 'መብርሂ',
            'file' => 'ፋይል'
        ];
        $validator->setAttributeNames($messages);
        $validator->validate();
        if(Documents::where('title',$request->title)->count()){
            $validator->errors()->add('duplicate', 'ሽም ፋይል ኣብ መዝገብ ኣሎ');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $image = $request->file('file');
        $new_name = $request->title . rand() . '.' . $image->getClientOriginalExtension();
        while(file_exists(public_path("documents") . '/'. $new_name)) {
            $new_name = $request->title . rand() . '.' . $image->getClientOriginalExtension();
        }
        $image->move(public_path("documents"), $new_name);
        $dataDocument = new Documents;
        $dataDocument->title = ($request->title);
        $dataDocument->description = ($request->description);
        $dataDocument->file = $new_name;
        $dataDocument->save();
        Toastr::info('ፋይል ተፃዒኑ ኣሎ');   
        return redirect('dashboard');
    }
    public function deleteDoc(Request $request){
        $validator = \Validator::make($request->all(), [
            "title" => "required"
        ],
        [
            'required' => ':attribute ክምላእ ኣለዎ',
        ]);
        $messages = [
            'title' => 'ሽም ፋይል',
        ];
        $validator->setAttributeNames($messages);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!Documents::where('title', $request->title)->count()){
            $validator->errors()->add('duplicate', 'ዶክመንት ኣብ መዝገብ ኣይተረኸበን');
            return [false, 'error', $validator->errors()->all()];
        }
        $doc = Documents::where('title',$request->title)->first();
        $filename = $doc->file;
        if(file_exists(public_path("documents") . '/'. $filename)){
            unlink(public_path("documents") . '/'. $filename);
            $doc->delete();
            return [true, 'success', 'ፋይል ብትኽክል ጠፊኡ ኣሎ'];
        }
        return [true, 'success', 'ፋይል ጠፊኡ ኣሎ'];
        
    }
    public function listDocuments(Request $request){
        $data = Documents::orderBy('created_at', 'DESC')->get();
        return view ( 'documents.listdocuments', compact('data'));  
    }
    public function download($title, Request $request){
        if(Documents::where('title',$title)->count()){
            $doc = Documents::where('title',$title)->first();
            $filename = $doc->file;
            if(file_exists(public_path("documents") . '/'. $filename)){
                return Response::download(public_path("documents") . '/'. $filename, $title . '.' . array_slice(explode('.', $filename ), -1, 1)[0], [
                    'Content-Length: '. filesize(public_path("documents") . '/'. $filename)
                ]);
            }
            else{
                Toastr::error('ይቕረታ ፋይል ክርከብ ኣይከኣለን');
                return redirect('dashboard');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
    }

}
