<?php

namespace App\Http\Controllers;

use App\Events\PodcastProcessed;
use App\Mail\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

class SignupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('signup');
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
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'birthday' => ['required', 'date'],
            'gender' => ['required', 'in:Male,Female'],
            'phone' => ['required'],
            'profile_pic' => ['required', 'mimes:jpeg,jpg,png']
        ]);

        $email = $request->email;
        $password = Hash::make($request->password);
        $name = $request->first_name.' '.$request->last_name;
        $birthday = date('Y/m/d', strtotime($request->birthday));
        $gender = $request->gender;
        $phone = $request->phone;
        $profile_pic = $request->profile_pic;
        $is_admin = '0';

        $user = User::create([
            'email' => $email,
            'password' => $password,
            'name' => $name,
            'birthday' => $birthday,
            'gender' => $gender,
            'phone' => $phone,
            'is_admin' => $is_admin
        ]);

        if($profile_pic)
        {
            $fileName = time().'_'.$profile_pic->getClientOriginalName();
            $filePath = $request->file('profile_pic')->storeAs('uploads', $fileName, 'public');
            $user->profile_pic = $fileName;
            $profile_pic->move('/storage/'.$filePath, $fileName);
        }

        if($user->save())
        {
            PodcastProcessed::dispatch($email);
            // event(new PodcastProcessed($request->email));
            return redirect()->route('login');
        }
        else
        {
            return redirect()->route('signup');
        }
    }
}
