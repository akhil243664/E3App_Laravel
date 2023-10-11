<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trending;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\CentralLogics\Helpers;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;


class TrendingController extends Controller
{
    function index()
    {
          $admin = Admin::find(auth('admin')->id());
        $trending=Trending::where('country_slug',$admin->country_slug)->get();
        return view('admin.trending.index',compact('trending'));
    }
	 function store(Request $request)
    {
          $admin = Admin::find(auth('admin')->id());
        $trending=new Trending();
		 $trending->name=$request->name;
         $trending->country_slug=$admin->country_slug;
		 $trending->created_at=now();
		 $trending->updated_at=now();
		 $trending->save();
       return redirect()->back()->withSuccess('Trending search Keyword added successfully');
    }
	
	 public function delete(Request $request)
    {
        $trending = Trending::findOrFail($request->id);
        $trending->delete();
		return redirect()->back()->withSuccess('Trending search Keyword removed');
    }
	
}