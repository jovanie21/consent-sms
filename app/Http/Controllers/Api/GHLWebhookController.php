<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Validator;
use Mail;

class GHLWebhookController extends Controller
{
    public function process(Request $request): Response
    {
        Log::info('***GHL DATA START***');
        Log::info($request->all());
        Log::info('***GHL DATA END***');

        $data = [
            'firstname' => $request->first_name,
            'lastname' =>  $request->last_name,
            'email' => $request->email,
            'wphone' => $request->phone,
            'hphone' => $request->phone,
            'address' => $request->address1,
            'zipcode' => $request->postal_code,
            'city' =>  $request->city,
            'state' => $request->state,
            'message' => "Please click here to confirm the information is correct and you give the Consent to Contact"
        ];

        $validator = Validator::make($data, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'wphone' => 'required|unique:sms',
            'hphone' => 'required',
            'address' => 'required',
            'zipcode' => 'required',
            'city' => 'required',
            'state' => 'required',
            'message' => 'required',
        ]);
   
        if ($validator->fails()) {        
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }    

        $phone_data = $this->get_phone_and_code($data['wphone']);

        $fname = $data['firstname'];
        $lname = $data['lastname'];
        $email = $data['email'];
        $wphone = $hphone = $phone_data['number'];
        $address = $data['address'];
        $zipcode = $data['zipcode'];
        $city = $data['city'];
        $state = $data['state'];
        $message = $data['message'];
        $senderip = $request->ip();     

        // Email-verification - IP quality Api
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

        $valid = $json["valid"];

        if ($valid == null) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email-Address'
            ]);
        }

        // DNC BLOCKER API
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
            // echo "cURL Error #:" . $err; 
        } else $dncstatus = $response;

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
            // echo "cURL Error #:" . $err;
        } else $consentstatus = $result;

        if ($dncstatus == 'no' && $consentstatus == 'yes') {
            return response()->json([
                'success' => false,
                'message' => 'The number already exist in Consent Form'
            ]);
        } else {
            $url = "https://consentform.com?firstname=" . urlencode($fname) . "&lastname=" . urlencode($lname) . "&emailaddress=" . urlencode($email) . "&ext=" . $phone_data['code'] . "&wnumber=" . urlencode($wphone) . "&ext2=" . $phone_data['code'] . "&hnumber=" . urlencode($hphone) . "&address=" . urlencode($address) . "&zipcode=" . urlencode($zipcode) . "&city=" . urlencode($city) . "&state=" . urlencode($state) . "&message=" . urlencode($message) . "&response=Both";

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
            $json_url = json_decode($response, true);
            $short_url = $json_url["shortUrl"];
            $result = $short_url;

            $maildata = array(
                'name' => $fname,
                'email' => $email,
                'msg' => $message,
                'result' => $result,
            );

            try {
                Mail::send('employee.email.sentemail', $maildata, function ($message) use ($email) {
                    $message->from('anishchittora93@gmail.com', 'Contact Consent');
                    $message->subject('Confirm Your Consent - Important Verification Steps');
                    $message->to($email);
                });

                $from = '+12135347986';

                $destination_number = $phone_data['code'] . $wphone . '';

                $sms_text = "Hi, We appreciate staying connected! To keep receiving our updates, tap the link below to confirm your contact details and agree to our communications: $result. If you'd rather not receive messages, tap https://consentform.com/optout.php. Thank you for staying connected with us!";

                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://messaging.bandwidth.com/api/v2/users/5007441/messages",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "{\n    \"to\": [\"$destination_number\"],\n    \"from\": \"$from\",\n    \"text\"          : \"$sms_text\",\n    \"applicationId\" : \"cff5a3a2-c946-489e-94f8-f02babd8f8b7\",\n    \"tag\"           : \"test message\"\n}",
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

                $sms = new Sms();
                $sms->user_id = 233; // Live Solar Lead Form
                $sms->company_id = 49; // Live Solar
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
                $sms->sender_ip = $senderip;
                $sms->submition_status = '1';
                $sms->consentform_url = $result;
                $sms->resend_type = 'Both';
                $sms->attempt = '0';
                $sms->save();
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Process has been completed successfully!'
            ]);
        }        
    }

    public function get_phone_and_code($phone_number): array
    {
        $regex = '/^([0|\+[0-9]{1,5})?([0-9][0-9]{9})$/';

        preg_match_all($regex, $phone_number, $matches);
        
        return [
            'number' => $matches[2][0] ?? '',
            'code' => $matches[1][0] ?? ''
        ];
    }
}

