<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\Sms;
use App\Models\EmployeeDetail;
use DB;
use Mail;

class HomeController extends Controller
{
    public function index()
    {
        $company=User::join('companies', 'users.company_id', 'companies.id')->select([DB::raw('companies.id as id')])->whereHas('roles', function ($q) {
                    $q->where('name', 'company');
        })->count();        
        $employee=User::join('employee_details', 'users.id', 'employee_details.user_id')->whereHas('roles', function ($q) {
            $q->where('name', 'employee');
        })->count();
        $sms=Sms::join('users','users.id','sms.user_id')->select([DB::raw('sms.id as id')])->count();
        return view('superadmin.home',compact('company','employee','sms'));
    } 


    public function smscheck()
    {
        $sms=Sms::join('users','users.id','sms.user_id')->select([
       DB::raw('sms.email as email'),
       DB::raw('sms.id as id'),
       DB::raw('sms.created_at as created_at'),
       DB::raw('sms.updated_at as updated_at'),
	'users.name',
	'sms.firstname',
	'sms.lastname',
	'sms.message',
	'sms.wphone',
	'sms.hphone',
	'sms.address',
	'sms.zipcode',
	'sms.city',
	'sms.submition_status',
        ])->get();
        return view('superadmin/superadminsms',compact('sms'));
    }
	
    public function resendsmsadmin(Request $request, $id)
    {
        // dd($request->all());
        $sms = Sms::where('id', $id)->first();
        $fname = $sms->firstname;
        $lname = $sms->lastname;
        $email = $sms->email;
        $wphone = $sms->wphone;
        $hphone = $sms->hphone;
        $address = $sms->address;
        $city = $sms->city;
        $state = $sms->state;
        $zipcode = $sms->zipcode;
        $message = $sms->message;
        $attempt_new = $sms->attempt + 1;


        $url = "https://consentform.com?firstname=" . urlencode($fname) . "&lastname=" . urlencode($lname) . "&emailaddress=" . urlencode($email) . "&ext=+1&wnumber=" . urlencode($wphone) . "&ext2=+1&hnumber=" . urlencode($hphone) . "&address=" . urlencode($address) . "&zipcode=" . urlencode($zipcode) . "&city=" . urlencode($city) . "&state=" . urlencode($state) . "&message=" . urlencode($message) . "&response=SMS";
        // print_r($url);die('');
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
        // print_r($response);exit;
        $json_url = json_decode($response, true);
        // print_r($json_url);exit;
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

            try{ $this->smslog($response); }catch (\Exception $e) {}

            session()->flash('success_msg', 'SMS has been sent successfully');
            return redirect('superadmin/superadminsms');
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
            return redirect('superadmin/superadminsms');
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
            return redirect('superadmin/superadminsms');
        }
    }



	    public function changepdfactive($id)
    {
        $status='2';
        $data=Company::where('id',$id)->update(['status' => $status]);
        session()->flash('success_msg','Consent Form PDF will be shown to Company');
        return back();
    }

    public function changetodeactive($id)
    {
        $status='1';
        $data=Company::where('id',$id)->update(['status' => $status]);
        session()->flash('success_msg','Consent Form PDF will be hidden to Company');
        return back();
    }

    public function companyconsentsms($id)
    {
      $sms=Sms::join('users','users.id','sms.user_id')->select([
     DB::raw('sms.email as email'),
     DB::raw('sms.id as id'),
     DB::raw('sms.created_at as created_at'),
     DB::raw('sms.updated_at as updated_at'),
    'users.name',
    'sms.firstname',
    'sms.lastname',
    'sms.message',
    'sms.wphone',
    'sms.hphone',
    'sms.address',
    'sms.zipcode',
    'sms.city',
    'sms.submition_status',
      ])->where('users.company_id',$id)->get();
      return view('superadmin/superadminsms',compact('sms'));
    }

    public function smslog($message)
    {
        $message = json_encode($message);
        $message = '['.date('Y-m-d H-i-s').'] => '.$message."\n\n";        
        $path = storage_path().'/logs/smsapilog.log';            
        file_put_contents($path,$message,FILE_APPEND);
    }

}
