<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Models\AdmobAd;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\CentralLogics\Helpers;
use Illuminate\Support\Str;
use App\Models\Api_Advcampaign;
use App\Models\Category;
use App\Models\Country;
use App\Models\Partner;
use App\Models\Coupon;
use App\Models\Admin;

class AdmitadController extends Controller
{
    public function __construct()
    {
        $this->scope =
            "coupons coupons_for_website advcampaigns_for_website deeplink_generator advcampaigns banners websites manage_opt_codes";
    }

    public function index()
    {
        $admin = Admin::find(auth("admin")->id());
        $admitad = DB::table("admitad")
            ->where("country_slug", $admin->country_slug)
            ->first();
        $this->client_id = $admitad->client_id;
        $this->client_secret = $admitad->client_secret;
        $this->base64code = $admitad->base64code;
        $this->website_id = $admitad->website_id;
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.admitad.com/token/",
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => http_build_query([
                "client_id" => $this->client_id,
                "client_secret" => $this->client_secret,
                "grant_type" => "client_credentials",
                "scope" => $this->scope,
            ]),
        ]);

        $headers = [
            "Accept: application/json",
            "Authorization: Basic " . $this->base64code,
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $re = json_decode($resp);
        $token = $re->access_token;
        if ($token) {
            $url ="https://api.admitad.com/advcampaigns/website/" .$this->website_id ."/?language=en&limit=500&offset=2";
            $curl1 = curl_init($url);
            curl_setopt($curl1, CURLOPT_URL, $url);
            curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
            $headers = [
                "Accept: application/json",
                "Authorization: Bearer $token",
            ];
            curl_setopt($curl1, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);

            $resp1 = curl_exec($curl1);
            curl_close($curl1);
            $res = json_decode($resp1);

            $get_id = null;

            if (property_exists($res, "error")) {
                return redirect()
                    ->back()
                    ->withErrors("Check your admitad account credentials! Data Not Found.");
            }

            foreach ($res->results as $data) {
                $get_id[] = $data->id;
            }
            if ($get_id == null) {
                $get_id = [];
            }


            $getjoinoffers = Api_Advcampaign::where(
                "country_slug",
                $admin->country_slug
            )->get();
            foreach ($getjoinoffers as $offers) {
                $key = array_search($offers->ad_id, $get_id);
                if ($key == false) {
                    $getjoinoffers = Api_Advcampaign::FindorFail($offers->id);
                    $getjoinoffers->status = 0;
                    $getjoinoffers->save();
                }
            }

            $new_ad_id = [];

            foreach ($res->results as $data) {
                if ($data->status != "active") {
                    $checkoffers = Api_Advcampaign::where("ad_id", $data->id)
                        ->where("country_slug", $admin->country_slug)
                        ->first();

                    if ($checkoffers) {
                        $new_ad_id = $data->id;
                        $checkoffers = Api_Advcampaign::where(
                            "ad_id",
                            $data->id
                        )
                            ->where("country_slug", $admin->country_slug)
                            ->update(["status" => "0"]);
                    }
                }

                if ($data->gotolink != "" && $data->gotolink != null) {
                    $admin = Admin::find(auth("admin")->id());

                    $check = Country::where("slug",$admin->country_slug)->first();
                    $flag = $check->country_code;
                    // $resources[] = array_filter(
                    //     $data->action_countries,
                    //     function ($var) use ($flag, $data, $admin) {
                        if (is_array($data->action_countries)) {
                            $resources[] = array_filter($data->action_countries, function ($var) use ($flag, $data, $admin) {

                            if ($var == $flag) {
                                $checkoffers = Api_Advcampaign::where("ad_id",$data->id)
                                    ->where("country_slug",$admin->country_slug)
                                    ->first();
                                $image_name = Str::random(10) . ".png";
                                if (!$checkoffers) {
                                    $url = $data->image;
                                    $dir = "offer/";
                                    $dir2 = "partner/";
                                    if ( !Storage::disk("public")->exists($dir) ) 
                                    {
                                        Storage::disk("public")->makeDirectory( $dir );
                                    }
                                    if ( !Storage::disk("public")->exists($dir2) ) 
                                    {
                                        Storage::disk("public")->makeDirectory($dir2);
                                    }

                                    $image = file_get_contents($url);
                                    file_put_contents( storage_path( "app/public/offer/" . $image_name ), $image );
                                    file_put_contents( storage_path( "app/public/partner/" . $image_name ), $image );
                                }
                                $nammmmme = $data->categories[0]->name ?? null;
                                if ($nammmmme != null) {
                                    $checkcategory = Category::where( "name", $nammmmme )
                                                            ->where( "country_slug", $admin->country_slug )
                                                            ->first();
                                    if (!$checkcategory) {
                                        $categor = new Category();
                                        $categor->name = $data->categories[0]->name;
                                        $categor->admitad_cat_id = $data->categories[0]->id;
                                        $categor->language = $data->categories[0]->language;
                                        $categor->country_slug = $admin->country_slug;
                                        $categor->save();
                                    } else {
                                        $categor = $checkcategory;
                                    }

                                    $partner_name = str_replace( "https://", "", $data->site_url );
                                    $partner_name = str_replace( "/", "", $partner_name );
                                    $partner_name = str_replace( "http:", "", $partner_name );
                                    $partner_name = str_replace("www.", "", $partner_name );
                                    $paar = "." . $partner_name;
                                    $partner2 = Partner::where("name", $paar)
                                        ->where("affiliate_partner", "admitad")
                                        ->where( "country_slug", $admin->country_slug )
                                        ->first();
                                    if ($partner2) {
                                        $adv = Partner::Find($partner2->id);
                                        $adv->name = $partner_name;
                                        $adv->updated_at = now();
                                        $adv->save();
                                        $pp_id = $adv->id;
                                    }

                                    $partner1 = Partner::where( "name",  $partner_name )
                                                        ->where("affiliate_partner", "admitad")
                                                        ->where( "country_slug", $admin->country_slug )
                                                        ->first();
                                    if (!$partner1) {
                                        $adv = new Partner();
                                        $adv->name = $partner_name;
                                        $adv->status = 1;
                                        $adv->regions = json_encode( $data->action_countries );
                                        $adv->affiliate_partner = "admitad";
                                        $adv->status = 0;
                                        $adv->country_slug = $admin->country_slug;
                                        $adv->image = $image_name;
                                        $adv->created_at = now();
                                        $adv->updated_at = now();
                                        $adv->save();
                                        $pp_id = $adv->id;
                                    } else {
                                        $pp_id = $partner1->id;
                                    }
                                    $checkoffers = Api_Advcampaign::where( "ad_id", $data->id ) 
                                                                    ->where( "country_slug", $admin->country_slug ) 
                                                                    ->first();
                                    if (!$checkoffers) {
                                        $data_insert = Api_Advcampaign::create([
                                            "ad_id" => $data->id,
                                            "name" => $data->name,
                                            "cat_id" => $categor->id,
                                            "adv_id" => $pp_id,
                                            "name_aliases" =>  $data->name_aliases,
                                            "site_url" => $data->site_url,
                                            "gotourl" => $data->gotolink == "" ? $data->site_url : $data->gotolink,
                                            "description" => $data->description,
                                            "raw_description" => $data->raw_description,
                                            "currency" => $data->currency,
                                            "cr" => $data->cr,
                                            "ecpc" => $data->ecpc,
                                            "epc" => $data->epc,
                                            "rating" => $data->rating,
                                            "image" => $image_name,
                                            "cr_trend" => $data->cr_trend,
                                            "epc_trend" => $data->epc_trend,
                                            "ecpc_trend" => $data->ecpc_trend,
                                            "country" => json_encode( $data->action_countries ),
                                            "exclusive" => $data->exclusive,
                                            "activation_date" => $data->activation_date,
                                            "modified_date" => $data->modified_date,
                                            "denynewwms" => $data->denynewwms,
                                            "goto_cookie_lifetime" => $data->goto_cookie_lifetime,
                                            "retag" => $data->retag,
                                            "show_products_links" => $data->show_products_links,
                                            "landing_code" => $data->landing_code,
                                            "landing_title" => $data->landing_title,
                                            "geotargeting" => $data->geotargeting,
                                            "country_slug" => $admin->country_slug,
                                            "max_hold_time" => $data->max_hold_time,
                                            "avg_hold_time" => $data->avg_hold_time,
                                            "avg_money_transfer_time" =>  $data->avg_money_transfer_time,
                                            "allow_deeplink" => $data->allow_deeplink,
                                            "coupon_iframe_denied" => $data->coupon_iframe_denied,
                                            "action_testing_limit" => $data->action_testing_limit,
                                            "mobile_device_type" => $data->mobile_device_type,
                                            "mobile_os" => $data->mobile_os,
                                            "status" => 0,
                                            "mobile_os_type" => $data->mobile_os_type,
                                            "allow_actions_all_countries" => $data->allow_actions_all_countries,
                                            "connected" => $data->connected,
                                        ]);
                                    }
                                }
                            }
                        });
                    }
                        //}
                    //);
                }
            }

            // dd($new_ad_id);
        }
        return redirect()
            ->back()
            ->withSuccess("Admitad Campaigns list has been Updated");
    }

    public function couponfetch()
    {
        $admin = Admin::find(auth("admin")->id());
        $admitad = DB::table("admitad")
            ->where("country_slug", $admin->country_slug)
            ->first();
        $this->client_id = $admitad->client_id;
        $this->client_secret = $admitad->client_secret;
        $this->base64code = $admitad->base64code;
        $this->website_id = $admitad->website_id;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.admitad.com/token/",
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => http_build_query([
                "client_id" => $this->client_id,
                "client_secret" => $this->client_secret,
                "grant_type" => "client_credentials",
                "scope" => $this->scope,
            ]),
        ]);

        $headers = [
            "Accept: application/json",
            "Authorization: Basic " . $this->base64code,
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $re = json_decode($resp);
        $token = $re->access_token;

        if ($token) {
            $url =
                "https://api.admitad.com/coupons/website/" .
                $this->website_id .
                "/?limit=1000";

            $curl1 = curl_init($url);
            curl_setopt($curl1, CURLOPT_URL, $url);
            curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
            $headers = [
                "Accept: application/json",
                "Authorization: Bearer $token",
            ];
            curl_setopt($curl1, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);

            $resp1 = curl_exec($curl1);
            curl_close($curl1);
            $res = json_decode($resp1);

            foreach ($res->results as $data) {
                if ($data->status != "active") {
                    $checkoffers = Coupon::where("admi_coupon_id", $data->id)
                        ->where("country_slug", $admin->country_slug)
                        ->first();
                    if ($checkoffers) {
                        $checkoffers = Coupon::where(
                            "admi_coupon_id",
                            $data->id
                        )
                            ->where("country_slug", $admin->country_slug)
                            ->where("status", "0")
                            ->first();
                    }
                }

                $admin = Admin::find(auth("admin")->id());
                $check = Country::where("slug", $admin->country_slug)->first();
                $flag = $check->country_code;

                $resources[] = array_filter($data->regions, function (
                    $var
                ) use ($flag, $data, $admin) {
                    if ($var == $flag) {
                        $checkoffers = Coupon::where(
                            "admi_coupon_id",
                            $data->id
                        )->first();
                        $image_name = Str::random(10) . ".png";
                        if (!$checkoffers) {
                            $url = $data->image;
                            $dir = "coupon/";
                            $dir2 = "partner/";

                            if (!Storage::disk("public")->exists($dir)) {
                                Storage::disk("public")->makeDirectory($dir);
                            }

                            if (!Storage::disk("public")->exists($dir2)) {
                                Storage::disk("public")->makeDirectory($dir2);
                            }

                            $check1111 = Api_Advcampaign::where(
                                "ad_id",
                                $data->campaign->id
                            )
                                ->where("country_slug", $admin->country_slug)
                                ->first();
                            if ($check1111) {
                                $image = file_get_contents($url);
                                file_put_contents(
                                    storage_path(
                                        "app/public/coupon/" . $image_name
                                    ),
                                    $image
                                );
                                file_put_contents(
                                    storage_path(
                                        "app/public/partner/" . $image_name
                                    ),
                                    $image
                                );
                                $data_insert = Coupon::create([
                                    "name" => $data->short_name,
                                    "admi_coupon_id" => $data->id,
                                    "code" =>
                                        $data->promocode == "NOT REQUIRED"
                                            ? null
                                            : $data->promocode,
                                    "adv_id" => $check1111->adv_id,
                                    "status" => 1,
                                    "country_slug" => $admin->country_slug,
                                    "description" => $data->description,
                                    "heading" => $data->short_name,
                                    "c_id" => $data->campaign->id,
                                    "url" => $data->campaign->site_url,
                                    "start_date" => $data->date_start,
                                    "end_date" => $data->date_end,
                                    "affiliate_partner" => "admitad",
                                    "image" => $image_name,
                                    "banner_image" => $image_name,
                                    "button_text" => "Grab Now",
                                    "created_at" => now(),
                                    "updated_at" => now(),
                                ]);
                            }
                        }
                    }
                });
            }
            return redirect()
                ->back()
                ->withSuccess("Coupon list has been Updated");
        }
        return redirect()
            ->back()
            ->withErrors("Unauthorized");
    }
}
