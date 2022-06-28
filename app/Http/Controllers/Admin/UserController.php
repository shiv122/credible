<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Helpers\Helper;
use App\Mail\User\Password;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(UserDataTable $table)
    {
        $pageConfigs = ['has_table' => true,];
        //for filter use with
        // $table->with('id', 1);
        return $table->render('content.tables.users', compact('pageConfigs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'nullable|string|max:2000',
            'phone' => 'required|integer|digits:10',
        ]);

        $password = Helper::makePassword($request->name);
        $imageName = 'images/users/avatar-' . Str::uuid() . '.png';
        $avatar = new Avatar();
        $avatar->create($request->name)->save($imageName);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($password),
            'address' => $request->address,
            'image' => $imageName,
        ]);
        $details = ['name' => $request->name, 'password' => $password, 'reset_link' => '#'];
        Mail::to($request->email)->send(new Password($details));

        return response(['status' => 'success', 'header' => "User Added", 'message' => 'User created successfully.', 'table' => 'user-table']);
    }


    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
        ]);

        User::where('id', $request->id)->update([
            'status' => $request->status,
        ]);

        return response(['status' => 'success', 'header' => "User Status Changed", 'message' => 'User status changed successfully.']);
    }
}
