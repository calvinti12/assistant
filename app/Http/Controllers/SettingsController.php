<?php

namespace App\Http\Controllers;

use App\FacebookPages;
use App\Settings;
use DateTime;
use Facebook\Facebook;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public static function getPageToken($pageId)
    {
        return FacebookPages::where('pageId', $pageId)->value('pageToken');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check()){
            return redirect()->to('/login');
        }
        session_start();

        try {
            $facebook = new Facebook([
                'app_id' => SettingsController::get('fbAppId'),
                'app_secret' => SettingsController::get('fbAppSec'),
                'default_graph_version' => 'v2.6'
            ]);;
            $fb = $facebook;
            $permissions = ['pages_messaging', 'manage_pages', 'publish_pages','read_page_mailboxes'];
            $helper = $fb->getRedirectLoginHelper();
            $loginUrl = $helper->getLoginUrl(url('') . '/facebook/connect', $permissions);
            $_SESSION['FBRLH_' . 'state'];
        } catch (\Exception $e) {
            $loginUrl = url('/');
        }
        return view('settings', compact('loginUrl'));
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
        try {
            Settings::where('key', 'fbAppId')->update(['value' => $request->fbAppId]);
            Settings::where('key', 'fbAppSec')->update(['value' => $request->fbAppSec]);
            Settings::where('key', 'live')->update(['value' => $request->live]);
            Settings::where('key', 'match')->update(['value' => $request->match]);
            FacebookPages::where('pageId',$request->pageId)->update(['exceptionMessage'=>$request->exMsg]);
            return "success";

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        if($id=='spam'){
            try{
                Settings::where('key','autoDelete')->update(['value'=>$request->autoDelete]);
                Settings::where('key','words')->update(['value'=>$request->blackList]);
                Settings::where('key','urls')->update(['value'=>$request->whiteList]);
                Settings::where('key','spamDefender')->update(['value'=>$request->spamDefender]);
                return "success";
            }
            catch (\Exception $exception){
                return $exception->getMessage();
            }
        }
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

    public static function get($field)
    {
        return Settings::where('key', $field)->value('value');
    }

    public static function convertTime($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function getPageName($pageID){
        return FacebookPages::where('pageId',$pageID)->value('pageName');
    }

    public function getExMessage(Request $request){
        return FacebookPages::where('pageId',$request->pageId)->value('exceptionMessage');
    }
}
