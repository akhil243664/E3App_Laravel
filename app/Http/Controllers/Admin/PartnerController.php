<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Api_Advcampaign;
use App\Models\CuelinkCampaign;
use App\Models\CuelinkOffer;
use App\Models\Offer;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\CentralLogics\Helpers;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Admin;
use App\Models\Category;


class PartnerController extends Controller
{
    
    
    public function update_tagline(Request $request, $id)
    {
        $request->validate([
            'tagline' => 'required',
        ]);
        
         

          DB::table('partners')->where(['id' => $id])->update([
            'tagline' => $request->tagline,
            'updated_at' => now(),
        ]);
       
        
        return redirect()->back()->withSuccess('Tagline Updated Successfully');
       
    }
    public function update_comission(Request $request, $id)
    {
        $request->validate([
            'com_type' => 'required',
            'com_per' => 'required',
            
        ]);
        
         

          DB::table('partners')->where(['id' => $id])->update([
            'comission_type' => $request->com_type,
            'comission_percentage' => $request->com_per,
            'updated_at' => now(),
        ]);
       
        
        return redirect()->back()->withSuccess('Comission Settings Updated Successfully');
       
    }
    
    function index()
    {
         $admin = Admin::find(auth('admin')->id());
        $partners=Partner::orderBy('name')->where('affiliate_partner','manual')->where('country_slug',$admin->country_slug)->paginate(15);
        return view('admin.partner.index',compact('partners'));
    }

function list(Request $request)
    {
     $admin = Admin::find(auth('admin')->id());
    DB::table('partners')->update([
            'notify' => 1,
        ]);
     $key = [];
        if($request->search)
        {
            $key = explode(' ', $request['search']);
        }
        $partners=Partner::when(count($key) > 0, function($query)use($key){
            foreach ($key as $value) {
                $query->orWhere('name', 'like', "%{$value}%");
            };
        })->orderBy('id','desc')->where('country_slug',$admin->country_slug)->where('affiliate_partner','manual')->paginate(15);
        return view('admin.partner.list',compact('partners'));
    }
         
    public function top_cashback(Partner $partner, Request $request)
    {
      
        $partner->top_cashback = $request->top_cashback;
        $partner->save();

       return redirect()->back()->withSuccess('Top Cashback status updated');
       
    }
    function store(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
        $request->validate([
            'name' => 'required|unique:categories',
        ], [
            'name.required' => 'Name is required!',
        ]);
        $partner = new Partner();
        $partner->name = $request->name;
        $partner->country_slug = $admin->country_slug;
        $partner->right_tab = $request->right_tab;
        $partner->right_tab_desc = '<!DOCTYPE html><body>'.$request->right_tab_desc.'</body></html>';
        $partner->left_tab = $request->left_tab;
        $partner->left_tab_desc = '<!DOCTYPE html><body>'.$request->left_tab_desc.'</body></html>';
        $partner->image = Helpers::upload('partner/', 'png', $request->file('image'));
        $partner->save();

      
       return redirect()->back()->withSuccess('partner added successfully');
    }

    public function edit($id)
    {
        
        $partner = Partner::findOrFail($id);
        $category = optional(Category::find($partner->category_id));
        $categorys = Category::all();
        return view('admin.partner.edit', compact('partner','categorys','category'));
    }

    public function status(Request $request)
    {
        $partner = Partner::find($request->id);
        $partner->status = $request->status;
        $partner->save();
         return redirect()->back()->withSuccess('partner status updated');
    }
    
    
     public function active_status(Request $request)
    {
        $partner = Partner::find($request->partner);
        $partner->status = $request->status;
        $partner->save();
         
         if($partner){
             $admitad=Api_Advcampaign::where('adv_id',$request->partner)->update(['status'=>$request->status]);
             $cuelinkcampaign=CuelinkCampaign::where('adv_id',$request->partner)->update(['status'=>$request->status]);
              $cuelinkcam=CuelinkCampaign::where('adv_id',$request->partner)->get();
             foreach($cuelinkcam as $cue){
                 $CuelinkOffer=CuelinkOffer::where('campaign_id',$cue->campaign_id)->update(['status'=>$request->status]);
             }
             $ads=Offer::where('partner_id',$request->partner)->update(['status'=>$request->status]);
          }
         
         return redirect()->back()->with('success','partner active status updated');
    }

    public function update(Request $request, $id)
    {
     $admin = Admin::find(auth('admin')->id());
        $request->validate([
            'name' => 'required|unique:categories,name,'.$id,
        ]);

        $partner = Partner::find($id);

        $partner->name = $request->name;
        $partner->right_tab = $request->right_tab;
        $partner->country_slug = $admin->country_slug;
        $partner->right_tab_desc = '<!DOCTYPE html><body>'.$request->right_tab_desc.'</body></html>';
        $partner->left_tab = $request->left_tab;
        $partner->left_tab_desc = '<!DOCTYPE html><body>'.$request->left_tab_desc.'</body></html>';
        $partner->image = $request->has('image') ? Helpers::update('partner/', $partner->image, 'png', $request->file('image')) : $partner->image;
        // $partner->category_id = $request->category_id ;

        $partner->save();
       
         return redirect()->back()->withSuccess('partner updated successfully');
    }

    public function delete(Request $request)
    {
        $partner = Partner::findOrFail($request->id);
        
        $partner->delete();
        return redirect()->back()->withErrors('advertiser removed');
        
        return back();
    }

  

   
    public function searchadvertisers(Request $request){
         $admin = Admin::find(auth('admin')->id());
        $key = explode(' ', $request['search']);
        $partners=Partner::where('country_slug',$admin->country_slug)->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->limit(50)->where('affiliate_partner','manual')->get();

       
        return response()->json([
            'view'=>view('admins.partner.partials._table',compact('partners'))->render(),
            'count'=>$partners->count()
        ]);
    }


    public function exportadvertiser(Request $request){
         $admin = Admin::find(auth('admin')->id());
        $adv = Partner::where('country_slug',$admin->country_slug)->get();
        $storage = [];
        if(count($adv)>0){
         foreach($adv as $item)
        {
           
            $storage[] = [
                'id'=>$item->id,
                'name'=>$item->name,
                'image'=>$item->image,
                'affiliate_partner'=>$item->affiliate_partner,
                'left_tab'=>$item->left_tab,
                'left_tab_desc'=>$item->left_tab_desc,
                'right_tab'=>$item->right_tab,
                'right_tab_desc'=>$item->right_tab_desc,
                'top_cashback'=>$item->top_cashback==1 ? "yes":"no",
                'commission_type'=>$item->commission_type==1 ? "Cashback":"Rewards",
                'commission_percentage'=>$item->commission_percentage,
                'tagline'=>$item->tagline,
                'created_at'=>date('F jS, Y', strtotime($item->created_at)),
            ];
        }
        return (new FastExcel($storage))->download('Advertisers.xlsx');
    }else{
        return redirect()->back()->withErrors('No Advertiser found');
    }
    }
}
