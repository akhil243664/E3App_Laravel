<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use App\CentralLogics\Helpers;
use Session;
use Config;
use Illuminate\Http\Request;

  

class EnvconfigController extends Controller

{

    /**

     * Write code on Method

     *

     * @return response()

     */

     public function smtp(Request $request)
    {

        $g=array();
        $g['smtp_host']=env('MAIL_HOST');
        $g['smtp_port']=env('MAIL_PORT');
        $g['username']=env('MAIL_USERNAME');
        $g['password']=env('MAIL_PASSWORD');
        $g['encryption']=env('MAIL_ENCRYPTION');
        $g['mail_from']=env('MAIL_FROM_ADDRESS');
      return view('admin.settings.smtp', compact('g'));

    }

    public function smtp_update(Request $request)
    {

        $dataArray = array(
            "MAIL_HOST"=>$request->host,
            "MAIL_PORT"=>$request->port,
            "MAIL_USERNAME"=>$request->username,
            "MAIL_PASSWORD"=>$request->password,
            "MAIL_ENCRYPTION"=>$request->encryption,
            "MAIL_FROM_ADDRESS"=>$request->mail_from,           
        );    

        foreach ($dataArray as $key => $value) {
          $check=  Helpers::envUpdate($key, $value);
        }           


      return redirect()->back()->withSuccess('SMTP credentials Updated Successfully');

    }
}