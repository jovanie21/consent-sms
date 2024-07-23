<?php
namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use Auth;
use Illuminate\Http\Request;
use Mail;

class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $email)
    {
        if (!empty($email->email)) {
            $getEmail = Sms::where('email', $email->email)->update(['submition_status'=> '2']);
        }
  
        //
        $sms = Sms::where('user_id', Auth::user()->id)->get();
        // return $sms;
        return view('employee.sms.index', compact('sms'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.sms.create');
    }

    /** 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->ip());
        //dd($request->all());
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'wphone' => 'required|unique:sms',
            'address' => 'required',
            'zipcode' => 'required',
            'city' => 'required',
            'state' => 'required',
            'message' => 'required',
        ]);

        $fname = $request->firstname;
        $lname = $request->lastname;
        $email = $request->email;
        $wphone = $request->wphone;
        $hphone = $request->hphone;
        $address = $request->address;
        $zipcode = $request->zipcode;
        $city = $request->city;
        $state = $request->state;
        $message = $request->message;
        $senderip=$request->ip();

        //Email-verification - IP quality Api
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://ipqualityscore.com/api/json/email/AYB8eFcYXqiYIn8uEvfQeoj38aUDC0HE/" . $email . "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"phone_number\"\r\n\r\n82\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
                "postman-token: 6c5f8e39-5d71-d4a2-3bd6-275608c9d3dc",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $json = json_decode($response, true);
        // print_r($json);exit;
        $valid = $json["valid"];
        //echo $valid;

        //-----------------------------------DNC BLOCKER API-----------------------------------------------------
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://dncblocker.com/checknumber/5778195c3c38e8248e62f20a5d695681?phone=" . $wphone . "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 85eb6153-0a41-eb85-578f-05432adb699b",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

        $dncstatus = $response;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://consentform.com/api/consentsms/?token=xyz1234&wnumber=" . $wphone . "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: c6941acb-9c3f-19cd-408e-89cfce16ad44",
            ),
        ));

        $result = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $result;
        }
        $consentstatus = $result;
        if ($dncstatus == 'no' && $consentstatus == 'yes') {
            session()->flash('danger_msg', 'The number already exist in Consent Form');
            return back();
        } else {

            $url = "http://consentform.com?firstname=" . urlencode($fname) . "&lastname=" . urlencode($lname) . "&emailaddress=" . urlencode($email) . "&ext=+1&wnumber=" . urlencode($wphone) . "&ext2=+1&hnumber=" . urlencode($hphone) . "&address=" . urlencode($address) . "&zipcode=" . urlencode($zipcode) . "&city=" . urlencode($city) . "&state=" . urlencode($state) . "&message=" . urlencode($message) . "&response=SMS";
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


            if ($request->submit == "Send SMS") {
                //dd("sms sent");
                //require_once '/consentsms/vendor/autoload.php';
                // require_once '/opt/lampp/htdocs/newconsentsms/vendor/autoload.php';
                // require_once '/var/www/html/consentsms/vendor/autoload.php';
                require_once '/var/www/html/vendor/autoload.php';

                try {
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
                    $sms = new Sms;
                    $sms->user_id = Auth::user()->id;
                    $sms->company_id = Auth::user()->company_id;
                    $sms->firstname = $fname;
                    $sms->lastname = $lname;
                    $sms->email = $email;
                    $sms->wphone = $wphone;
                    $sms->hphone = $hphone;
                    $sms->address = $address;
                    $sms->zipcode = $zipcode;
                    $sms->city = $city;
                    $sms->state = $state;
                    $sms->dnc_status = $dncstatus;
                    $sms->consentform_status = $consentstatus;
                    $sms->message = $message;
                    $sms->sender_ip =$senderip;
                    $sms->submition_status = '1';
                    $sms->consentform_url = $result;
                    $sms->attempt = '0';
                    $sms->resend_type = 'SMS';
                    $sms->save();
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
                session()->flash('success_msg', 'SMS has been sent successfully');
                return redirect()->route('sms.index');
            } elseif ($request->submit == "Send Email") {

                if ($valid == null) {
                    session()->flash('danger_msg', 'Invalid Email-Address');
                    return back();
                }

                $url = "http://consentform.com?firstname=" . urlencode($fname) . "&lastname=" . urlencode($lname) . "&emailaddress=" . urlencode($email) . "&ext=+1&wnumber=" . urlencode($wphone) . "&ext2=+1&hnumber=" . urlencode($hphone) . "&address=" . urlencode($address) . "&zipcode=" . urlencode($zipcode) . "&city=" . urlencode($city) . "&state=" . urlencode($state) . "&message=" . urlencode($message) . "&response=Email";
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
                //echo $response;
                $json_url = json_decode($response, true);
                //print_r($json["shortUrl"]);
                $short_url = $json_url["shortUrl"];
                $result = $short_url;

                $sms = new Sms;
                $sms->user_id = Auth::user()->id;
                $sms->company_id = Auth::user()->company_id;
                $sms->firstname = $fname;
                $sms->lastname = $lname;
                $sms->email = $email;
                $sms->wphone = $wphone;
                $sms->hphone = $hphone;
                $sms->address = $address;
                $sms->zipcode = $zipcode;
                $sms->city = $city;
                $sms->state = $state;
                $sms->dnc_status = $dncstatus;
                $sms->consentform_status = $consentstatus;
                $sms->message = $message;
                $sms->sender_ip =$senderip;
                $sms->submition_status = '1';
                $sms->consentform_url = $result;
                $sms->resend_type = 'Email';
                $sms->save();

                //dd("email sent");
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
                return redirect()->route('sms.index');
            } else {
                if ($valid == null) {
                    session()->flash('danger_msg', 'Invalid Email-Address');
                    return back();
                }

                $url = "http://consentform.com?firstname=" . urlencode($fname) . "&lastname=" . urlencode($lname) . "&emailaddress=" . urlencode($email) . "&ext=+1&wnumber=" . urlencode($wphone) . "&ext2=+1&hnumber=" . urlencode($hphone) . "&address=" . urlencode($address) . "&zipcode=" . urlencode($zipcode) . "&city=" . urlencode($city) . "&state=" . urlencode($state) . "&message=" . urlencode($message) . "&response=Both";
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
                //echo $response;
                $json_url = json_decode($response, true);
                //print_r($json["shortUrl"]);
                $short_url = $json_url["shortUrl"];
                $result = $short_url;
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
                //require_once 'C:\xampp\htdocs\consentsms\consentsms\vendor';
                // require_once '/opt/lampp/htdocs/newconsentsms/vendor/autoload.php';
                require_once '/var/www/html/vendor/autoload.php';


                try {
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
                    $sms = new Sms;
                    $sms->user_id = Auth::user()->id;
                    $sms->company_id = Auth::user()->company_id;
                    $sms->firstname = $fname;
                    $sms->lastname = $lname;
                    $sms->email = $email;
                    $sms->wphone = $wphone;
                    $sms->hphone = $hphone;
                    $sms->address = $address;
                    $sms->zipcode = $zipcode;
                    $sms->city = $city;
                    $sms->state = $state;
                    $sms->dnc_status = $dncstatus;
                    $sms->consentform_status = $consentstatus;
                    $sms->message = $message;
                    $sms->sender_ip =$senderip;
                    $sms->submition_status = '1';
                    $sms->consentform_url = $result;
                    $sms->resend_type = 'Both';
                    $sms->attempt = '0';
                    $sms->save();
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
                session()->flash('success_msg', 'SMS and Email has been sent successfully');
                return redirect()->route('sms.index');
            }
        }
    }

    //Resend sms email - both

    public function resend(Request $request, $id)
    {
        //dd($request->all());
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

        $url = "http://consentform.com?firstname=" . urlencode($fname) . "&lastname=" . urlencode($lname) . "&emailaddress=" . urlencode($email) . "&ext=+1&wnumber=" . urlencode($wphone) . "&ext2=+1&hnumber=" . urlencode($hphone) . "&address=" . urlencode($address) . "&zipcode=" . urlencode($zipcode) . "&city=" . urlencode($city) . "&state=" . urlencode($state) . "&message=" . urlencode($message) . "&response=SMS";
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
        if ($request->submit == "Send SMS") {
            //dd("sms sent");
            Sms::where('id', $id)->update(array('resend_type' => 'SMS'));
            Sms::where('id', $id)->update(array('attempt' => $attempt_new));
            //require_once '/consentsms/vendor/autoload.php';
            // require_once '/opt/lampp/htdocs/newconsentsms/vendor/autoload.php';
            require_once '/var/www/html/vendor/autoload.php';

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
            return redirect()->route('sms.index');
        } else if ($request->submit == "Send Email") {
            //dd("email sent");
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
            return redirect()->route('sms.index');
        } else {
            //dd("send both");
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
            return redirect()->route('sms.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = SMS::find($id);
        // dd($row);
        return view('employee.sms.edit', compact("row"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        // dd($request->all());
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'wphone' => 'required',
            'address' => 'required',
            'zipcode' => 'required',
            'city' => 'required',
            'state' => 'required',
            'message' => 'required',
        ]);

        $fname = $request->firstname;
        $lname = $request->lastname;
        $email = $request->email;
        $wphone = $request->wphone;
        $hphone = $request->hphone;
        $address = $request->address;
        $zipcode = $request->zipcode;
        $city = $request->city;
        $state = $request->state;
        $message = $request->message;
	$senderip=$request->ip();
        //Email-verification - IP quality Api
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://ipqualityscore.com/api/json/email/AYB8eFcYXqiYIn8uEvfQeoj38aUDC0HE/" . $email . "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"phone_number\"\r\n\r\n82\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
                "postman-token: 6c5f8e39-5d71-d4a2-3bd6-275608c9d3dc",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $json = json_decode($response, true);
        // print_r($json);exit;
        $valid = $json["valid"];
        //echo $valid;

        //-----------------------------------DNC BLOCKER API-----------------------------------------------------
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://dncblocker.com/checknumber/5778195c3c38e8248e62f20a5d695681?phone=" . $wphone . "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 85eb6153-0a41-eb85-578f-05432adb699b",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

        $dncstatus = $response;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://consentform.com/api/consentsms/?token=xyz1234&wnumber=" . $wphone . "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: c6941acb-9c3f-19cd-408e-89cfce16ad44",
            ),
        ));

        $result = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $result;
        }
        $consentstatus = $result;
        if ($dncstatus == 'no' && $consentstatus == 'yes') {
            session()->flash('danger_msg', 'The number already exist in Consent Form');
            return back();
        } else {

            $url = "http://consentform.com?firstname=" . urlencode($fname) . "&lastname=" . urlencode($lname) . "&emailaddress=" . urlencode($email) . "&ext=+1&wnumber=" . urlencode($wphone) . "&ext2=+1&hnumber=" . urlencode($hphone) . "&address=" . urlencode($address) . "&zipcode=" . urlencode($zipcode) . "&city=" . urlencode($city) . "&state=" . urlencode($state) . "&message=" . urlencode($message) . "&response=SMS";
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
            //echo $response;
            $json_url = json_decode($response, true);
            //print_r($json["shortUrl"]);
            $short_url = $json_url["shortUrl"];
            $result = $short_url;


            if ($request->submit == "Send SMS") {
                //dd("sms sent");
                //require_once '/consentsms/vendor/autoload.php';
                //require_once '/opt/lampp/htdocs/newconsentsms/vendor/autoload.php';
		require_once '/var/www/html/vendor/autoload.php';

                try {
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
                    $sms = Sms::find($id);
                    $sms->user_id = Auth::user()->id;
                    $sms->company_id = Auth::user()->company_id;
                    $sms->firstname = $fname;
                    $sms->lastname = $lname;
                    $sms->email = $email;
                    $sms->wphone = $wphone;
                    $sms->hphone = $hphone;
                    $sms->address = $address;
                    $sms->zipcode = $zipcode;
                    $sms->city = $city;
                    $sms->state = $state;
                    $sms->dnc_status = $dncstatus;
                    $sms->consentform_status = $consentstatus;
                    $sms->message = $message;
                    $sms->sender_ip =$senderip;
                    $sms->submition_status = '1';
                    $sms->consentform_url = $result;
                    $sms->attempt = '0';
                    $sms->resend_type = 'SMS';
                    $sms->save();
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
                session()->flash('success_msg', 'SMS has been sent successfully');
                return redirect()->route('sms.index');
            } elseif ($request->submit == "Send Email") {

                if ($valid == null) {
                    session()->flash('danger_msg', 'Invalid Email-Address');
                    return back();
                }

                $url = "http://consentform.com?firstname=" . urlencode($fname) . "&lastname=" . urlencode($lname) . "&emailaddress=" . urlencode($email) . "&ext=+1&wnumber=" . urlencode($wphone) . "&ext2=+1&hnumber=" . urlencode($hphone) . "&address=" . urlencode($address) . "&zipcode=" . urlencode($zipcode) . "&city=" . urlencode($city) . "&state=" . urlencode($state) . "&message=" . urlencode($message) . "&response=Email";
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
                //echo $response;
                $json_url = json_decode($response, true);
                //print_r($json["shortUrl"]);
                $short_url = $json_url["shortUrl"];
                $result = $short_url;

                $sms = Sms::find($id);
                $sms->user_id = Auth::user()->id;
                $sms->company_id = Auth::user()->company_id;
                $sms->firstname = $fname;
                $sms->lastname = $lname;
                $sms->email = $email;
                $sms->wphone = $wphone;
                $sms->hphone = $hphone;
                $sms->address = $address;
                $sms->zipcode = $zipcode;
                $sms->city = $city;
                $sms->state = $state;
                $sms->dnc_status = $dncstatus;
                $sms->consentform_status = $consentstatus;
                $sms->message = $message;
                $sms->sender_ip =$senderip;
                $sms->submition_status = '1';
                $sms->consentform_url = $result;
                $sms->resend_type = 'Email';
                $sms->save();

                //dd("email sent");
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
                return redirect()->route('sms.index');
            } else {
                if ($valid == null) {
                    session()->flash('danger_msg', 'Invalid Email-Address');
                    return back();
                }

                $url = "http://consentform.com?firstname=" . urlencode($fname) . "&lastname=" . urlencode($lname) . "&emailaddress=" . urlencode($email) . "&ext=+1&wnumber=" . urlencode($wphone) . "&ext2=+1&hnumber=" . urlencode($hphone) . "&address=" . urlencode($address) . "&zipcode=" . urlencode($zipcode) . "&city=" . urlencode($city) . "&state=" . urlencode($state) . "&message=" . urlencode($message) . "&response=Both";
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
                //echo $response;
                $json_url = json_decode($response, true);
                //print_r($json["shortUrl"]);
                $short_url = $json_url["shortUrl"];
                $result = $short_url;

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
                //require_once 'C:\xampp\htdocs\consentsms\consentsms\vendor';
                // require_once '/opt/lampp/htdocs/newconsentsms/vendor/autoload.php';
                require_once '/var/www/html/consentsms/vendor/autoload.php';


                try {

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

                    $sms = Sms::find($id);
                    $sms->user_id = Auth::user()->id;
                    $sms->company_id = Auth::user()->company_id;
                    $sms->firstname = $fname;
                    $sms->lastname = $lname;
                    $sms->email = $email;
                    $sms->wphone = $wphone;
                    $sms->hphone = $hphone;
                    $sms->address = $address;
                    $sms->zipcode = $zipcode;
                    $sms->city = $city;
                    $sms->state = $state;
                    $sms->dnc_status = $dncstatus;
                    $sms->consentform_status = $consentstatus;
                    $sms->message = $message;
                    $sms->sender_ip =$senderip;
                    $sms->submition_status = '1';
                    $sms->consentform_url = $result;
                    $sms->resend_type = 'Both';
                    $sms->attempt = '0';
                    $sms->save();
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
                session()->flash('success_msg', 'SMS and Email has been sent successfully');
                return redirect()->route('sms.index');
            }
        }
    }

    public function destroy($id)
    {
        //
    }

    
}

