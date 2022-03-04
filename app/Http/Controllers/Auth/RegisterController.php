<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('App\Http\middleware\AdminMiddleware');
    }



    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = \Validator::make($data,[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'usertype' => 'required|in:admin,zone,woreda,zoneadmin,woredaadmin,management',
        ],
        [
            'required' => ':attribute ኣይተመልአን',
            'email' => ':attribute ብትኽክል ኣይተመልአን',
            'min' => ':attribute ካብ :min ፊደላት ክውሕድ የብሉን',
            'max' => ':attribute ካብ :max ፊደላት ክበዝሕ የብሉን',
            'confirmed' => 'ፓስዎርድታት መዓረ ክኾኑ ኣለዎም',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'is_area_valid' => 'ኮድ ኮድባ ጮማዬ'
        ]);
        $fieldNames = [
            'firstname' => 'ሽም',
            'lastname' => 'ሽም ኣቦ',
            'email' => 'ኢሜይል',
            'password' => 'ፓስዎርድ',
            'usertype' => 'ሓላፍነት',
            'area' => 'ኮድ'
        ];
        $validator->setAttributeNames($fieldNames);
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // return User::create([
        //     'firstname' => $data['firstname'],
        //     'lastname' => $data['lastname'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        //     'type' => 'admin'
        // ]);
        $user = new User;
        $user -> firstname = $data['firstname'];
        $user -> lastname = $data['lastname'];
        $user -> email = $data['email'];
        $user -> password = bcrypt($data['password']);
        $user -> usertype = $data['usertype'];
        $user -> save();
        return $user;
        Toastr::success("ተጠቃማይ ".$data['firstname']." ብትኽኽል ተፈጢሩ");
    }
}
