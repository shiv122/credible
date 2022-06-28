<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Helpers\FileUploader;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;

class BusinessController extends Controller
{

    public function index()
    {
        $business = Business::with(['data.images'])->get();
        return  BusinessResource::collection($business);
    }


    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:2000',
            'website' => 'nullable|url',
            'phone' => 'required|string|size:10',
            'email' => 'required|string|email|max:255',
            'type' => 'required|string|in:individual,organization',
            'age_of_business' => 'required|numeric',
            'data' => 'required|array',
            'data.*.name' => 'required|string|max:255',
            'data.*.number' => 'required|string|max:255',
            'data.*.image.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'social_links' => 'nullable|array',
            'social_links.*.for' => 'required|string|max:255',
            'social_links.*.url' => 'required|url',
        ]);

        return   DB::transaction(function () use ($request) {
            $business = $request->user()->business()->create([
                'name' => $request->name,
                'address' => $request->address,
                'website' => $request->website,
                'phone' => $request->phone,
                'email' => $request->email,
                'type' => $request->type,
                'age_of_business' => $request->age_of_business,
            ]);

            foreach ($request->data as $key => $d) {
                $data =   $business->data()->create([
                    'name' => $d['name'],
                    'number' => $d['number'],
                ]);
                foreach ($d['image'] as $key => $image) {
                    $data->images()->create([
                        'image' => FileUploader::uploadFile($image, 'images/business/'),
                    ]);
                }
            }

            foreach ($request->social_links as $key => $s) {
                $business->social_links()->create([
                    'for' => $s['for'],
                    'url' => $s['url'],
                ]);
            }

            return $business;
        });
    }
}
