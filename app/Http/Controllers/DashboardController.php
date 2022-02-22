<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $email = session('email');
        $user = User::where('email', $email)->first();
        return view('examples.dashboard')->with('user', $user);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function imageupload(Request $request)
    {
        $email = session('email');
        $user = User::where('email', $email)->first();

        if(File::exists(public_path('storage/uploads/'.$user->profile_pic)))
        {
            File::delete(public_path('storage/uploads/'.$user->profile_pic));
            $profile_pic = $request->file;
            $fileName = time().'_'.$profile_pic->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            // $profile_pic->move('/storage/'.$filePath, $fileName);
            $user->profile_pic = $fileName;
            $user->save();
        }
        else
        {
            $profile_pic = $request->file;
            $fileName = time().'_'.$profile_pic->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            // $profile_pic->move('/storage/'.$filePath, $fileName);
            $user->profile_pic = $fileName;
            $user->save();
        }

        return response()->json($user->profile_pic);
    }

    public function edit(Request $request)
    {
        if($request->password != '')
        {
            $request->validate([
                'first_name' => ['required'],
                'last_name' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required', 'min:6'],
                'birthday' => ['required', 'date'],
                'gender' => ['required', 'in:Male,Female'],
                'phone' => ['required'],
            ]);

            User::where('id', $request->id)->update([
                'name' => $request->first_name.' '.$request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'phone' => $request->phone
            ]);
        }
        else
        {
            $request->validate([
                'first_name' => ['required'],
                'last_name' => ['required'],
                'email' => ['required', 'email'],
                'birthday' => ['required', 'date'],
                'gender' => ['required', 'in:Male,Female'],
                'phone' => ['required'],
            ]);

            User::where('id', $request->id)->update([
                'name' => $request->first_name.' '.$request->last_name,
                'email' => $request->email,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'phone' => $request->phone
            ]);
        }

        return redirect()->route('dashboard');
    }

}
