<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Constant;
use App\Http\Requests;
use  App\User;
use  App\Zobatat;
use  App\Woreda;

use Illuminate\Http\Request;

class UserRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()    //if not authenticated redirect to login
    {
        // if(Auth::user() && Auth::user()->usertype == 'admin')   //only for admin users
        //     $this->middleware('auth'); 
        // else            
        //     Auth::logout();
        // $this->middleware('auth');
        $this->middleware('App\Http\middleware\AdminMiddleware');
    }

    public function index()
    {
        //
        // $data = User::all ();
        // return view ( 'membership.addstaff' )->withData ( $data );
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
        if(array_search(Auth::user()->usertype, ['admin', 'zoneadmin', /*'woredaadmin'*/]) === false){
            return abort(403);
        }
        $validator = \Validator::make($request->all(),[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'usertype' => 'required|in:admin,zoneadmin,woredaadmin,zone,woreda,management',
        ],
        [
            'required' => ':attribute ኣይተመልአን',
            'email' => ':attribute ብትኽክል ኣይተመልአን',
            'min' => ':attribute ካብ :min ፊደላት ክውሕድ የብሉን',
            'max' => ':attribute ካብ :max ፊደላት ክበዝሕ የብሉን',
            // 'confirmed' => 'ፓስዎርድታት መዓረ ክኾኑ ኣለዎም',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'unique' => 'ኢሜይል ኣብ መዝገብ ኣሎ'
        ]);
        $fieldNames = [
            'firstname' => 'ሽም',
            'lastname' => 'ሽም ኣቦ',
            'email' => 'ኢሜይል',
            'password' => 'ፓስዎርድ',
            'usertype' => 'ሓላፍነት',
        ];
        $validator->setAttributeNames($fieldNames);
        $validator->validate();
        if(array_search($request->usertype, ['zone', 'woreda', 'zoneadmin', 'woredaadmin']) !== false){
            if(!isset($request->area)){
                $validator->errors()->add('duplicate', 'ኮድ ኣይተመልአን');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else{
                if(array_search($request->usertype, ['zone', 'zoneadmin']) !== false){
                    if(!Zobatat::where('zoneCode',$request->area)->count()){
                        $validator->errors()->add('duplicate', 'ኮድ ዞባ ኣብ መዝገብ የለን');
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                }
                if(array_search($request->usertype, ['woreda', 'woredaadmin']) !== false){
                    if(!Woreda::where('woredacode',$request->area)->count()){
                        $validator->errors()->add('duplicate', 'ኮድ ወረዳ ኣብ መዝገብ የለን');
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                }
            }
        }
        if(Auth::user()->usertype == 'zoneadmin'){
            if($request->usertype == 'zone' && !($request->area==Auth::user()->area)){
                $validator->errors()->add('duplicate', 'ኮድ ዞባ ኣይተረኸበን');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else if(array_search($request->usertype, ['woreda', 'woredaadmin']) !== false && !(Woreda::where('woredacode',$request->area)->where('zoneCode', Auth::user()->area)->count())){
                $validator->errors()->add('duplicate', 'ኮድ ወረዳ ኣይተረኸበን');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else if(array_search($request->usertype, ['zone', 'woreda', 'woredaadmin']) === false){
                $validator->errors()->add('duplicate', 'ዓይነት ሓላፍነት ኣይፍለጥን');
                return redirect()->back()->withErrors($validator)->withInput();
            }

        }
        if(Auth::user()->usertype == 'woredaadmin'){
            if($request->usertype == 'woreda' && !($request->area==Auth::user()->area)){
                $validator->errors()->add('duplicate', 'ኮድ ወረዳ ኣይተረኸበን');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else if($request->usertype != 'woreda') {
                $validator->errors()->add('duplicate', 'ዓይነት ሓላፍነት ኣይፍለጥን');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        $user = new User;
        $user -> firstname = $request->firstname;
        $user -> lastname = $request->lastname;
        $user -> email = $request->email;
        $user -> password = bcrypt($request->password);
        $user -> usertype = $request->usertype;
        if(array_search($request->usertype, ['zone', 'zoneadmin', 'woreda', 'woredaadmin']) !== false)
            $user -> area = $request->area;
        else
            $user -> area = '';
        $user -> save();
        Toastr::success('ተጠቃሚ ሲስተም ተፈጢሩ ኣሎ');
        return back();
        // return User::create([
        //     'firstname' => $data['firstname'],
        //     'lastname' => $data['lastname'],
        //     'email' => $data['myemail'],
        //     'password' => bcrypt($data['mypass']),
        // ]);
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
	public function listUsers()
    {
        //
        $data = User::paginate(Constant::PAGE_SIZE);
        return view('auth.users',compact('data'));
    }
	public function userdelete(Request $request){
        $data = User::where('id', $request->id)->where('firstname', $request->firstname)->where('lastname', $request->lastname)->first();
        if($data){
            $data->delete();
            return [true];
        }
        return [false];
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
