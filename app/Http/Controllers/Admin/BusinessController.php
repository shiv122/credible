<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\BusinessDataTable;
use App\Models\Business;

class BusinessController extends Controller
{

    public function index(BusinessDataTable $table, Request $request)
    {
        $type = Str::afterLast($request->url(), '/');
        $pageConfigs = ['has_table' => true];
        if ($type == 'pending') {
            $table->with('type', 'inactive');
        } elseif ($type == 'blocked') {
            $table->with('type', 'blocked');
        } else {
            $table->with('type', 'active');
        }
        return $table->render('content.tables.businesses', compact('pageConfigs'));
    }

    public function show($id)
    {
        $business =  Business::where('id', $id)
            ->with(['data.images', 'social_links', 'user:id,name,phone,email,image'])
            ->first();
        $images = $business->data->pluck('images')->map(function ($item) {
            return $item->pluck('image');
        })->flatten();
        return view('content.pages.business-details', compact('business', 'images'));
    }
}
