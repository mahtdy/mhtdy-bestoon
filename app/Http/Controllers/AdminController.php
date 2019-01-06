<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckAdmin');
    }

    public function index()
    {
        $users = User::latest()->paginate(10);
        $transs = Transaction::latest()->paginate(10);
        return view('Admin.index',compact('users','transs'));
    }

    public function editUserPage($id)
    {
        $user = User::find($id);
        return view('Admin.User.edit', compact('user'));
    }

    public function editUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'status' => 'required',
        ]);

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_activate = $request->status;
        $user->save();

        return redirect('/admin')->with('flash', 'کاربر با موفقیت ویرایش شد.');
    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return redirect('/admin')->with('flash', 'کاربر با موفقیت حذف شد.');
    }

}
