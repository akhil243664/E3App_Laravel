<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Partner;
use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Admin;

class OfferController extends Controller
{

    public function add_new()
    {
         $admin = Admin::find(auth('admin')->id());
          $categories = Category::where('country_slug',$admin->country_slug)->where(['position' => 0])->get();

        $check=DB::table('cuelink')->where('country_slug',$admin->country_slug)->first();
       $check2=DB::table('impact')->where('country_slug',$admin->country_slug)->first();
       $check3=DB::table('admitad')->where('country_slug',$admin->country_slug)->first();
          $parr=NULL;
        if($check->status==1 && $check2->status==1 && $check3->status==1){
            
           $parr=Partner::active()->where('country_slug',$admin->country_slug)->where('country_slug',$admin->country_slug)->where('affiliate_partner','cuelinks')->orWhere('affiliate_partner','impact')->orWhere('affiliate_partner','admitad')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
          
          
        }elseif($check->status==1 && $check2->status==1 && $check3->status !=1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','cuelinks')->orWhere('affiliate_partner','impact')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['admitadoffers']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                  $parr=[];
             }
             

        }elseif($check->status==1 && $check2->status!=1 && $check3->status!=1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','cuelinks')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['ads']=[];
             $parss['admitadoffers']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                 $parr=[];
             }
            
        }elseif($check->status==1 && $check2->status==1 && $check3->status!=1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','cuelinks')->orWhere('affiliate_partner','impact')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['admitadoffers']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                 $parr=[];
             }
            
        }elseif($check->status==1 && $check2->status!=1 && $check3->status==1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','cuelinks')->orWhere('affiliate_partner','admitad')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['ads']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                 $parr=[];
             }
            
        }elseif($check->status!=1 && $check2->status==1 && $check3->status!=1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','impact')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parss['admitadoffers']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                 $parr=[];
             }
            
        }elseif($check->status!=1 && $check2->status!=1 && $check3->status==1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','admitad')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parss['ads']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                  $parr=[];
             }
            
        }elseif($check->status!=1 && $check2->status==1 && $check3->status==1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','impact')->orWhere('affiliate_partner','admitad')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                 $parr=[];
             }
            
        }
        else{
             $parr=[];
        }
        
        if($parr==NULL){
             $parr=[];
        }
        $rls=$parr;
        return view('admin.partner.offer.add-new', compact('rls','categories'));
    }


  public function get_categories(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
       
        $cat = Category::where('country_slug',$admin->country_slug)->where(['parent_id' => $request->parent_id])->get();
        $res = '<option value="' . 0 . '" disabled selected>---Select---</option>';
        foreach ($cat as $row) {
            if ($row->id == $request->sub_category) {
                $res .= '<option value="' . $row->id . '" selected >' . $row->name . '</option>';
            } else {
                $res .= '<option value="' . $row->id . '">' . $row->name . '</option>';
            }
        }
        return response()->json([
            'options' => $res,
        ]);
    }


    public function store(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
        $request->validate([
            'name'=>'required',
            'description' => 'required',
            'button_text' => 'required',
            'button_url' => 'required',
            'partner_id' => 'required',
            'image' => 'required',
            'category_id' => 'required',

        ], [
            'name.required' => 'name is required',
            'description.required' => 'description is required',
            'button_text.required' => 'button_text is required',
            'partner_id.required' => 'Select Partner',
            'category_id.required' => 'category required',

        ]);

  


        DB::table('offers')->insert([
            'name'=>$request->name,
            'description' => $request->description,
            'category_id'=>$request->category_id,
            'country_slug' => $admin->country_slug,
            'button_text' => $request->button_text,
            'tracking_link' => $request->button_url,
			'landing_page' => $request->button_url,
            'partner_id' => $request->partner_id,
            'image' => Helpers::upload('offer/', 'png', $request->file('image')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
		return redirect()->route('admin.ads.list')->withSuccess('Ads Added Successfully');
       
    }

    function list(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
		DB::table('offers')->update([
            'notify' => 1,
        ]);
        $key = [];
        if($request->search)
        {
            $key = explode(' ', $request['search']);
        }
        $em = Offer::where('country_slug',$admin->country_slug)->when(count($key) > 0, function($query)use($key){
            foreach ($key as $value) {
                $query->orWhere('name', 'like', "%{$value}%");
            };
        })->with(['partner'])->where('affiliate_partner','manual')->orWhere('affiliate_partner','other')->orderBy('id','desc')->paginate(15);
        return view('admin.partner.offer.list', compact('em'));
    }

    public function edit($id)
    {
         $admin = Admin::find(auth('admin')->id());
        $e = Offer::where(['id' => $id])->first();
          $check=DB::table('cuelink')->where('country_slug',$admin->country_slug)->first();
       $check2=DB::table('impact')->where('country_slug',$admin->country_slug)->first();
       $check3=DB::table('admitad')->where('country_slug',$admin->country_slug)->first();
          $parr=NULL;
        if($check->status==1 && $check2->status==1 && $check3->status==1){
            
           $parr=Partner::active()->where('country_slug',$admin->country_slug)->where('country_slug',$admin->country_slug)->where('affiliate_partner','cuelinks')->orWhere('affiliate_partner','impact')->orWhere('affiliate_partner','admitad')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
          
          
        }elseif($check->status==1 && $check2->status==1 && $check3->status !=1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','cuelinks')->orWhere('affiliate_partner','impact')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['admitadoffers']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                  $parr=[];
             }
             

        }elseif($check->status==1 && $check2->status!=1 && $check3->status!=1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','cuelinks')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['ads']=[];
             $parss['admitadoffers']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                 $parr=[];
             }
            
        }elseif($check->status==1 && $check2->status==1 && $check3->status!=1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','cuelinks')->orWhere('affiliate_partner','impact')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['admitadoffers']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                 $parr=[];
             }
            
        }elseif($check->status==1 && $check2->status!=1 && $check3->status==1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','cuelinks')->orWhere('affiliate_partner','admitad')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['ads']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                 $parr=[];
             }
            
        }elseif($check->status!=1 && $check2->status==1 && $check3->status!=1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','impact')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parss['admitadoffers']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                 $parr=[];
             }
            
        }elseif($check->status!=1 && $check2->status!=1 && $check3->status==1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','admitad')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parss['ads']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                  $parr=[];
             }
            
        }elseif($check->status!=1 && $check2->status==1 && $check3->status==1){
            $pars=Partner::active()->where('country_slug',$admin->country_slug)->where('affiliate_partner','impact')->orWhere('affiliate_partner','admitad')->orWhere('affiliate_partner','manual')->orWhere('affiliate_partner','others')->get();
            foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parr[]=$parss;
             }
             if($parr==NULL){
                 $parr=[];
             }
            
        }
        else{
             $parr=[];
        }
        
        if($parr==NULL){
             $parr=[];
        }
        $rls=$parr;
        $product_category = json_decode($e->category_ids);
        $categories = Category::where('country_slug',$admin->country_slug)->where(['parent_id' => 0])->get();
        return view('admin.partner.offer.edit', compact('rls', 'e','product_category','categories'));
    }

    public function update(Request $request, $id)
    {
         $admin = Admin::find(auth('admin')->id());
        $request->validate([
            'name'=>'required',
            'description' => 'required',
            'button_text' => 'required',
            'button_url' => 'required',
            'partner_id' => 'required',
            'image' => 'required',
             'category_id' => 'required',
        ], [
            'name.required' => 'name is required',
            'description.required' => 'description is required',
            'button_text.required' => 'button_text is required',
            'partner_id.required' => 'Select Partner',
            'category_id.required' => 'category required',
        ]);

       

        if ($request->has('image')) {
            $e['image'] = Helpers::update('offer/', $e->image, 'png', $request->file('image'));
        }
         

          DB::table('offers')->where(['id' => $id])->update([
            'name'=>$request->name,
            'description' => $request->description,
            'category_id'=>$request->category_id,
            'country_slug' => $admin->country_slug,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'partner_id' => $request->partner_id,
             'tracking_link' => $request->button_url,
			'landing_page' => $request->button_url,
            'image' => Helpers::upload('offer/', 'png', $request->file('image')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
       
        
		return redirect()->route('admin.ads.list')->withSuccess('Offer Updated Successfully');
       
    }

    public function distroy($id)
    {
        $role=Offer::where(['id'=>$id])->delete();
		return redirect()->back()->withSuccess('Offer Deleted Successfully');
       
    }
	 public function searchads(Request $request){
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
  

   public function exportads(Request $request){
     $admin = Admin::find(auth('admin')->id());
        $ads = Offer::where('country_slug',$admin->country_slug)->get();
        $storage = [];
        if(count($ads)>0){
         foreach($ads as $item)
        {
           
            $storage[] = [
                'id'=>$item->id,
                'name'=>$item->name,
                'image'=>$item->image,
                'affiliate_partner'=>$item->affiliate_partner,
                'ad_id'=>$item->ad_id,
                'campaign_id'=>$item->c_id,
                'advertiser'=>$item->adv_name,
                'button_text'=>$item->button_text,
                'url'=>$item->landing_page,
                'created_at'=>date('F jS, Y', strtotime($item->created_at)),
            ];
        }
        return (new FastExcel($storage))->download('allads.xlsx');
    }else{
        return redirect()->back()->withErrors('No Ads found');
    }
    }
   
}
