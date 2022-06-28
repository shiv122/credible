<?php

namespace App\Http\Controllers\API\v1;

use App\Helpers\FileUploader;
use App\Models\User;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return $request->user();
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'nullable|string|in:male,female,other',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:2000',
        ]);
        $user = $request->user();

        if (!empty($request->file('image'))) {
            $image = FileUploader::uploadFile($request->file('image'), 'images/users/');
        } elseif (empty($user->image)) {
            $image = 'images/users/avatar-' . Str::uuid() . '.png';
            $avatar = new Avatar();
            $avatar->create($request->name)->save($image);
        } else {
            $image = $user->image;
        }
        User::where('id', $user->id)->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'location' => $request->location,
            'address' => $request->address,
            'image' => $image,
        ]);
    }


    public function test(Request $request)
    {
        // $request->validate([
        //     'doc.*.name' => 'required|string|max:255',
        //     'doc.*.number' => 'required|string|max:255',
        //     'doc.*.image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        $doc = [];

        foreach ($request->doc as $key => $d) {
            $doc[] = [
                'name' => $d['name'],
                'number' => $d['number'],
            ];
        }
    }
}
