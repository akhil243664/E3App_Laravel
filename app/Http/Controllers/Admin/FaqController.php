<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\CentralLogics\Helpers;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Admin;


class FaqController extends Controller
{
    function index()
    {
        $admin = Admin::find(auth('admin')->id());
        $faqs=Faq::where('country_slug',$admin->country_slug)->paginate(15);
        return view('admin.faq.index',compact('faqs'));
    }
	 function liste()
    {
        $admin = Admin::find(auth('admin')->id());
        $faqs=Faq::where('country_slug',$admin->country_slug)->paginate(15);
        return view('admin.faq.list',compact('faqs'));
    }
	
 

    function store(Request $request)
    {
        $admin = Admin::find(auth('admin')->id());
        $request->validate([
            'ques' => 'required|unique:faqs',
			'ans' => 'required',
        ], [
            'ques.required' => 'FAQ question is required!',
			'ans.required' => 'FAQ answer is required!',
        ]);
        $faq = new Faq();
        $faq->ques = $request->ques;
        $faq->country_slug = $admin->country_slug;
        $faq->image = Helpers::upload('faq/', 'png', $request->file('image'));
        $faq->ans = $request->ans;
        $faq->save();

      
       return redirect()->back()->withSuccess('FAQ added successfully');
    }

    public function edit($id)
    {

        $faq = Faq::findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }

   

    public function update(Request $request, $id)
    {
        $admin = Admin::find(auth('admin')->id());
        $request->validate([
            'ques' => 'required|unique:faqs',
			'ans' => 'required',
        ], [
            'ques.required' => 'FAQ question is required!',
			'ans.required' => 'FAQ answer is required!',
        ]);

        $faq = Faq::find($id);
        $faq->ques = $request->ques;
        $faq->ans = $request->ans;
        $faq->country_slug = $admin->country_slug;
        $faq->image = $request->has('image') ? Helpers::update('faq/', $faq->image, 'png', $request->file('image')) : $faq->image;
        $faq->save();
       
		 return redirect()->back()->withSuccess('FAQ updated successfully');
    }

    public function delete(Request $request)
    {
        $faq = Faq::findOrFail($request->id);
        $faq->delete();
	    return redirect()->back()->withErrors('FAQ removed');
        return back();
    }

    public function exportfaq(Request $request){
        $admin = Admin::find(auth('admin')->id());
        $faq = Faq::where('country_slug',$admin->country_slug)->get();
        $storage = [];
        if(count($faq)>0){
         foreach($faq as $item)
        {
           
            $storage[] = [
                'id'=>$item->id,
                'question'=>$item->ques,
                'answer'=>$item->ans,
                'image'=>$item->image,
                'created_at'=>date('F jS, Y', strtotime($item->created_at)),
            ];
        }
        return (new FastExcel($storage))->download('faqs.xlsx');
    }else{
        return redirect()->back()->withErrors('No Faqs found');
    }
    }

   
}
