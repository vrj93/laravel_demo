<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('examples.admindashboard');
    }

    public function logout(Request $request)
    {
        if(session('is_admin') == 1)
        {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('admin');
        }
    }

    public function users()
    {
        $users = User::all();

        return view('examples.users')->with('users', $users);
    }

    public function delete($id)
    {
        User::where('id',$id)->delete();

        return back();
    }

    public function edit($id, $is_admin)
    {
        User::where('id',$id)->update(['is_admin'=>$is_admin]);

        return back();
    }
}
