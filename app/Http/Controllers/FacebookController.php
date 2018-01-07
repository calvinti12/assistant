<?php

namespace App\Http\Controllers;

use App\FacebookPages;
use App\Settings;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;

use App\Http\Requests;

class FacebookController extends Controller
{
    public $facebook;

    public function __construct()
    {
        $this->middleware('auth');

        $this->facebook = new Facebook([
            'app_id' => SettingsController::get('fbAppId'),
            'app_secret' => SettingsController::get('fbAppSec'),
            'default_graph_version' => 'v2.6'
        ]);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = FacebookPages::all();
        return view('facebook', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datas = $this->facebook->get($id . '/feed?limit=100', SettingsController::getPageToken($id))->getDecodedBody();

        $pages = FacebookPages::all();
        return view('facebookSingle', compact('pages', 'id', 'datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function fbConnect()
    {
        session_start();
        $fb = new Facebook([
            'app_id' => SettingsController::get('fbAppId'),
            'app_secret' => SettingsController::get('fbAppSec'),
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $_SESSION['FBRLH_state'] = $_GET['state'];

        try {
            $accessToken = $helper->getAccessToken();
            $_SESSION['token'] = $accessToken;
            Settings::where('key', 'fbAppToken')->update(['value' => $accessToken]); // save user access token to database
            $this->saveFacebookPages(); // save facebook pages and token


        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            $this->saveFacebookPages(); // save facebook pages and token
            return '[a] Graph returned an error: ' . $e->getMessage();

        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            $this->saveFacebookPages(); // save facebook pages and token
            return '[a] Facebook SDK returned an error: ' . $e->getMessage();

        }


        return redirect('settings');


    }

    public function saveFacebookPages()
    {

        $fb = $this->facebook;


        try {

            $response = $fb->get('me/accounts', SettingsController::get('fbAppToken'));
            $body = $response->getBody();
            $data = json_decode($body, true);
            FacebookPages::truncate(); // delete previous saved page info and add new info form facebook for this user
            foreach ($data['data'] as $no => $filed) {

                $facebookPages = new FacebookPages();
                $facebookPages->pageId = $filed['id'];
                $facebookPages->pageName = $filed['name'];
                $facebookPages->pageToken = $filed['access_token'];
                $facebookPages->save();

            }

        } catch (FacebookResponseException $e) {
            return 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

    }

}
