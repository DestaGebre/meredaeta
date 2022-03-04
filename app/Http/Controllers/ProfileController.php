<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile.index')->with('profile', Auth::user());
    }

    public function edit(User $profile)
    {
        return view('profile.index', compact('profile'));
    }

    public function update(User $profile, Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "firstname" => "required",
            "lastname" => "required",
            "image" => "required|image|mimes:jpeg,jpg,png|max:2048"
        ],
        [
            'required' => ':attribute ክምላእ ኣለዎ',
            'image' => 'ፎቶ ክኸውን ኣለዎ',
            'mimes' => 'ዓይነት ፎቶ jpeg፣jpg ወይ png ክኸውን ኣለዎ',
            'max' => 'ፎቶ ካብ 2 ሜጋ ባይት ክዓቢ የብሉን'
        ]);
        $messages = [
            'firstname' => 'ሽም',
            'lastname'=> 'ሽም ኣቦ',
            'image' => 'ፎቶ'
        ];
        $validator->setAttributeNames($messages);
        $validator->validate();
        $image = $request->file('image');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path("img"), $new_name);
        $update_to = $request->all();
        $update_to['image'] = $new_name;
        $profile->update($update_to);
        Toastr::info("Profile has been successfully updated");
        return back();
    }

    public function update_password(User $profile, Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed'
        ]);

        $profile->update([
            'password' => bcrypt($request->password)
        ]);

        Toastr::info("Profile has been successfully updated");
        return back();
    }
}
