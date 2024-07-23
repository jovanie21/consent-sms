<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDetail;
use App\Models\Sms;
use Illuminate\Http\Request;
use Auth;
use DB;
use Mail;
class HomeController extends Controller
{
    public function index(){
        $employee=EmployeeDetail::where('user_id', Auth::user()->id)->count();
        return view('company.home',compact('employee'));
    }

	public function smscommpanycheck(){
	$company_id=Auth::user()->company_id;
	$sms=Sms::join('users','users.id','sms.user_id')->join('companies','companies.id' ,'sms.company_id')->where('sms.company_id',$company_id)->select([
    DB::raw('sms.email as email'),
    DB::raw('sms.id as id'),
    DB::raw('sms.created_at as created_at'),
    DB::raw('sms.updated_at as updated_at'),
     'users.name',
     'submition_status',
     'sms.firstname',
     'sms.lastname',
     'sms.message',
     'sms.wphone',
     'sms.hphone',
     'sms.address',
     'sms.zipcode',
     'sms.city',
     'companies.status',
     ])->get();
	return view('company.smscompany',compact('sms'));
	}
	
	public function resendsms(Request $request, $id)
    {

        // dd($request->all());
        $sms = Sms::where('id', $id)->first();
        $fname=$sms->firstname;
        $lname=$sms->lastname;
        $email=$sms->email;
        $wphone=$sms->wphone;
        $hphone=$sms->hphone;
        $address=$sms->address;
        $city=$sms->city;
        $state=$sms->state;
        $zipcode=$sms->zipcode;
        $message = $sms->message;
        $attempt_new = $sms->attempt + 1;


        $url = "https://consentform.com?firstname=" . urlencode($fname) . "&lastname=" . urlencode($lname) . "&emailaddress=" . urlencode($email) . "&ext=+1&wnumber=" . urlencode($wphone) . "&ext2=+1&hnumber=" . urlencode($hphone) . "&address=" . urlencode($address) . "&zipcode=" . urlencode($zipcode) . "&city=" . urlencode($city) . "&state=" . urlencode($state) . "&message=" . urlencode($message) . "&response=SMS";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.rebrandly.com/v1/links/?apikey=2a7b2b7269854529862f21c0ae8d19c4',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "destination": "' . $url . '",
            "domain": {
            "fullName": "consentform.cc"
                                    }
                                    }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;exit;
        $json_url = json_decode($response, true);
        //          print_r($json_url["shortUrl"]);exit;
        $short_url = $json_url["shortUrl"];
        $result = $short_url;




        if ($request->submit == "Send Sms") {
            Sms::where('id', $id)->update(array('resend_type' => 'SMS'));
            Sms::where('id', $id)->update(array('attempt' => $attempt_new));
            //require_once '/consentsms/vendor/autoload.php';
            //require_once '/opt/lampp/htdocs/newconsentsms/vendor/autoload.php';
            require_once '/var/www/html/consentsms/vendor/autoload.php';

            $from = '+12135347986';
            $destination_number = '+1' . $wphone . '';
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://messaging.bandwidth.com/api/v2/users/5007441/messages",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n    \"to\": [\"$destination_number\"],\n    \"from\": \"$from\",\n    \"text\"          : \"$message - $result\",\n    \"applicationId\" : \"cff5a3a2-c946-489e-94f8-f02babd8f8b7\",\n    \"tag\"           : \"test message\"\n}",
                CURLOPT_HTTPHEADER => array(
                    "authorization: Basic MWJjZjAyM2E4ZTUxYjg0ZjJmMjY5MWFlZTdiODU2NTVmYzcwY2MxYzNjNGNkYTFiOjA1MzlmZTFiYjY2NDA1YzBjZWRiNzIwNzBlMjM5YzE1YzY1ODFlZGNiNzZlNjFiOA==",
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "postman-token: 4cb71e44-68c3-a7cc-bc6d-70ed2aa3df3b"
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            session()->flash('success_msg', 'SMS has been sent successfully');
            return redirect('company/companysms');
        } else if ($request->submit == "Send Email") {
            Sms::where('id', $id)->update(array('resend_type' => 'Email'));
            Sms::where('id', $id)->update(array('attempt' => $attempt_new));
            //$result = $json['url']['shortLink'];
            $maildata = array(
                'name' => $fname,
                'email' => $email,
                'msg' => $message,
                'result' => $result,
            );
            Mail::send('employee.email.sentemail', $maildata, function ($message) use ($email) {
                $message->from('anishchittora93@gmail.com', 'Contact Consent');
                $message->subject('Lets Get Your Consent To Be Contacted Verified - Contact Consent');
                $message->to($email);
            });
            session()->flash('success_msg', 'Email has been sent successfully');
            return redirect('company/companysms');
        } else {
            Sms::where('id', $id)->update(array('resend_type' => 'Both'));
            Sms::where('id', $id)->update(array('attempt' => $attempt_new));
            $from = '+12135347986';
            $destination_number = '+1' . $wphone . '';
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://messaging.bandwidth.com/api/v2/users/5007441/messages",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n    \"to\": [\"$destination_number\"],\n    \"from\": \"$from\",\n    \"text\"          : \"$message - $result\",\n    \"applicationId\" : \"cff5a3a2-c946-489e-94f8-f02babd8f8b7\",\n    \"tag\": \"test message\"\n}",
                CURLOPT_HTTPHEADER => array(
                    "authorization: Basic MWJjZjAyM2E4ZTUxYjg0ZjJmMjY5MWFlZTdiODU2NTVmYzcwY2MxYzNjNGNkYTFiOjA1MzlmZTFiYjY2NDA1YzBjZWRiNzIwNzBlMjM5YzE1YzY1ODFlZGNiNzZlNjFiOA==",
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "postman-token: 4cb71e44-68c3-a7cc-bc6d-70ed2aa3df3b"
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            //send mail=====================
            $maildata = array(
                'name' => $fname,
                'email' => $email,
                'msg' => $message,
                'result' => $result,
            );
            Mail::send('employee.email.sentemail', $maildata, function ($message) use ($email) {
                $message->from('anishchittora93@gmail.com', 'Contact Consent');
                $message->subject('Consent Form Details - Contact Consent');
                $message->to($email);
            });
            session()->flash('success_msg', 'Email and Sms has been sent successfully');
            return redirect('company/companysms');
        }
    }

}
