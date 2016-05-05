<?php

namespace App\Http\Controllers;

use App\PaypalConfig;
use App\TwitterConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Filesystem\Filesystem;


use Validator;
use Session;
use Redirect;
use App\Http\Requests;
use Redirect;

class AppSettingsController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('isAdmin');
    }

    public function showSettings(Request $request) {

        // Page tite
        $page_title = "App settings";

        // twitter settings
        $twitterConsumerKey = TwitterConfig::getConsumerKey();
        $twitterConsumerKeySecret = TwitterConfig::getConsumerKeySecret();
        $twitterAccessToken = TwitterConfig::getAccessToken();
        $twitterAccessTokenSecret = TwitterConfig::getAccessTokenSecret();

        //paypal settings
        $paypalClientID = PaypalConfig::getClientID();
        $paypalSecretKey = PaypalConfig::getSecretKey();

        return view('app_settings.app_settings', compact('page_title', 'twitterConsumerKey',
            'twitterConsumerKeySecret', 'twitterAccessToken', 'twitterAccessTokenSecret', 'paypalClientID', 'paypalSecretKey'));
    }




    public function changeTwitterConsumerKey(Request $request) {

        $twitterConsumerKey = Input::get('twitter_consumer_key');
        if (TwitterConfig::setConsumerKey($twitterConsumerKey)) {
            $request->session()->flash('status', 'success');
        } else {
            $request->session()->flash('status', 'failure');
        }


        $request->session()->flash('object', 'Twitter Consumer Key');

        return redirect()->action('AppSettingsController@showSettings');
    }

    public function changeTwitterConsumerKeySecret(Request $request) {
        $twitterConsumerKeySecret = Input::get('twitter_consumer_key_secret');
        if(TwitterConfig::setConsumerKeySecret($twitterConsumerKeySecret)) {
            $request->session()->flash('status', 'success');
        } else {
            $request->session()->flash('status', 'failure');
        }

        $request->session()->flash('object', 'Twitter Consumer Key Secret');

        return redirect()->action('AppSettingsController@showSettings');
    }

    public function changeTwitterAccessToken(Request $request) {
        $twitterAccessToken = Input::get('twitter_access_token');
        if(TwitterConfig::setAccessToken($twitterAccessToken)) {
            $request->session()->flash('status', 'success');
        } else {
            $request->session()->flash('status', 'failure');
        }

        $request->session()->flash('object', 'Twitter Access Token');

        return redirect()->action('AppSettingsController@showSettings');
    }

    public function changeTwitterAccessTokenSecret(Request $request) {
        $twitterAccessTokenSecret = Input::get('twitter_access_token_secret');
        if(TwitterConfig::setAccessTokenSecret($twitterAccessTokenSecret)) {
            $request->session()->flash('status', 'success');
        } else {
            $request->session()->flash('status', 'failure');
        }

        $request->session()->flash('object', 'Twitter Access Token Secret');

        return redirect()->action('AppSettingsController@showSettings');
    }

    public function changePaypalClientID(Request $request) {
        $paypalClientID = Input::get('paypal_client_id');
        if(PaypalConfig::setClientID($paypalClientID)){
            $request->session()->flash('status', 'success');
        } else {
            $request->session()->flash('status', 'failure');
        }

        $request->session()->flash('object', 'Paypal Client ID');

        return redirect()->action('AppSettingsController@showSettings');
    }

    public function changePaypalSecretKey(Request $request) {
        $paypalSecretKey = Input::get('paypal_secret_key');
        if(PaypalConfig::setSecretKey($paypalSecretKey)) {
            $request->session()->flash('status', 'success');
        } else {
            $request->session()->flash('status', 'failure');
        }

        $request->session()->flash('object', 'Paypal Secret Key');

        return redirect()->action('AppSettingsController@showSettings');
    }

    public function changeApplicationColor(Request $request) {

        $theme = config('app_theme.appTheme'); //retrive

        $array = config('app_theme');

        $value = Input::get('theme-name');

        $array['appTheme'] = $value; //set  the value

        $data = var_export($array, 1);

        $fileSystem = new Filesystem();

        if($fileSystem->put(app_path() . "/../config/app_theme.php", "<?php\n return $data ;")) {
            return Redirect::back();
        } else {
            return Redirect::back();
        }




    }


    public function changeAppLogo() {
        $file = array('file' => Input::file('file'));
        $rules = array('file' => 'required|image',);
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            return Redirect::to('app_settings')->withInput()->withErrors($validator);
        }
        else {
            if (Input::file('file')->isValid()) {
                $destinationPath = base_path() . '/public';
                $extension = Input::file('file')->getClientOriginalExtension();
                $fileName = 'robusta_logo.png';
                Input::file('file')->move($destinationPath, $fileName);
                Session::flash('success', 'Upload successfully');
                return Redirect::to('app_settings');
            }
            else {
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('app_settings');
            }
        }
    }




}
