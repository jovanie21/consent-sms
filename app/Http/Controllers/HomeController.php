<?php

namespace App\Http\Controllers;
use App\Models\Sms;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }

	public function checkformstatus($token, $phone)
    {
        if (is_null($phone) && strlen($phone) <9) {
            return  'Number must be equal or greater than 10';
        } else {
            if ($token == '12345678900987654321123456789009') {
                $status='2';
                $data = SMS::where('wphone', $phone)->update(['submition_status' => $status]);
		 session()->flash('success_msg', ''.$phone.' has been successfully submitted consentform');
                return 'success';
            } 
            else {
                return 'Token Mismatch';
            }
        }
    }

	public function privacypolicy(){
	return view('privacypolicy');
}

    public function contact(Request $request)
    {
        $this->validate($request, [
            'fName' => 'required',
            'lName' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        $fName = $request->fName;
        $lName = $request->lName;
        $email = $request->email;
        $phone = $request->phone;


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://eagportal.com/rest/6/1u4vedry50my5shh/crm.lead.add",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n    \"fields\":{\r\n    \"NAME\" :\"$fName\",\r\n    \"LAST_NAME\":\"$lName\",\r\n    \"EMAIL\": [ { \"VALUE\": \"$email\"} ], \r\n    \"PHONE\": [ { \"VALUE\": \"$phone\"} ],\r\n    \"SOURCE_ID\" : 7\r\n    }\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Cookie: PHPSESSID=ckZJ2n9JKr29Vxk00ITzqsJEYwnEgurB; qmb=.; BITRIX_SM_SALE_UID=0"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return back();
    }

    public function getip($phone, $ip)
    {
	$smsip=SMS::where('wphone', $phone)->first();
        if ($ip==$smsip->sender_ip) {
            $data = SMS::where('wphone', $phone)->update(['ipstatus' => 'not match']);
            return "not match";
        } else {
            $data = SMS::where('wphone', $phone)->update(['ipstatus' => 'match']);
            return "match";
        }
    }

    public function verify($email)
    {
        
    }
}
