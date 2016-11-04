<?php

namespace App\Http\Controllers;


use App\Comments;
use App\FacebookPages;
use App\Notification;
use App\Sender;
use DateTime;
use DateTimeZone;
use League\Flysystem\Exception;

class Run extends Controller
{
    /**
     * Main execution point
     *
     * @param $input
     */

    public static function now($input)
    {
        /*
         * Detect Comments and reply to comment
         *
         * */
        if (isset($input['entry'][0]['changes'][0]['value']['comment_id']) && isset($input['entry'][0]['changes'][0]['value']['sender_id'])) {

            $pageId = $input['entry'][0]['id'];
            $message = isset($input['entry'][0]['changes'][0]['value']['message']) ? $input['entry'][0]['changes'][0]['value']['message'] : "";
            $postId = isset($input['entry'][0]['changes'][0]['value']['postId']) ? $input['entry'][0]['changes'][0]['value']['post_id'] : "";
            $item = isset($input['entry'][0]['changes'][0]['value']['item']) ? $input['entry'][0]['changes'][0]['value']['item'] : "";
            $verb = isset($input['entry'][0]['changes'][0]['value']['verb']) ? $input['entry'][0]['changes'][0]['value']['verb'] : "";
            $fbPostId = isset($input['entry'][0]['changes'][0]['value']['parent_id']) ? $input['entry'][0]['changes'][0]['value']['parent_id'] : "";

            if (!FacebookPages::where('pageId', $input['entry'][0]['changes'][0]['value']['sender_id'])->exists()) {
                $sender_name = isset($input['entry'][0]['changes'][0]['value']['sender_name']) ? $input['entry'][0]['changes'][0]['value']['sender_name'] : "";
                $sender_id = isset($input['entry'][0]['changes'][0]['value']['sender_id']) ? $input['entry'][0]['changes'][0]['value']['sender_id'] : "";
                /*
                check if sender already exists otherwise insert sender information
                */
                if (!Sender::where('sender_id', $sender_id)->exists()) {
                    $sender = new Sender();
                    $sender->sender_name = $sender_name;
                    $sender->sender_id = $sender_id;
                    $sender->save();
                }

                /*
                 * check if this is message and reply it
                 *
                 * */
                if (isset($input['entry'][0]['changes'][0]['value']['message'])) {
                    $fbObject = new FacebookController();
                    $facebook = $fbObject->facebook;
                    $commentId = $input['entry'][0]['changes'][0]['value']['comment_id'];
                    $parentId = $input['entry'][0]['changes'][0]['value']['parent_id'];
                    $explodePostId = explode("_", $fbPostId);
                    $pId = $explodePostId[0];


                    try {
                        if (SettingsController::get('spamDefender') == "on") {


                            /*
                             * Detect Black listed words
                             *
                             * */

                            if (SettingsController::get('autoDelete') == "on") {
                                $words = explode(',', SettingsController::get('words'));
                                foreach ($words as $word) {
                                    if (strpos(strtolower($message), strtolower($word)) !== false) {
                                        $facebook->delete($commentId, [], SettingsController::getPageToken($pageId));
                                        exit;
                                    }
                                }


                                /*
                                 * Detect URLs
                                 *
                                 * */

                                if (SpamController::isUrl($message)) {
                                    $urls = explode(',', SettingsController::get('urls'));
                                    foreach ($urls as $url) {
                                        if (strpos(strtolower($message), strtolower($url)) !== false) {

                                        } else {
                                            $facebook->delete($commentId, [], SettingsController::getPageToken($pageId));
                                            exit;
                                        }
                                    }
                                }


                            }

                            /*
                             * Action if comments are not spam
                             *
                             * */

                            foreach (Comments::all() as $comment) {

                                similar_text( strtolower($message),strtolower($comment->question), $match);
                                if ($match >= SettingsController::get('match')) {
                                    echo "Matching ".$match;
                                    /*
                                     * If this is for public comment
                                     *
                                     * */
                                    if($comment->type == "public"){
                                        /*
                                         * trying to reply
                                         *
                                         * */

                                        try {
                                            if($comment->link != null){
                                                echo "comment reply without image";
                                                $facebook->post($commentId . '/comments', ['message' => SenderController::processText($comment->answer,$sender_name,$pageId), 'attachment_url' => $$comment->link], SettingsController::getPageToken($pageId));
                                            }else{
                                                echo "comment reply with image";
                                                $facebook->post($commentId . '/comments', ['message' => SenderController::processText($comment->answer,$sender_name,$pageId)], SettingsController::getPageToken($pageId));
                                            }
                                            exit;

                                        } catch (\Exception $exception) {

                                            /*
                                            * If can't reply then try to reply via parent ID
                                            *
                                            * */

                                                try{
                                                    if($comment->link != null){
                                                        $facebook->post($parentId . '/comments', ['message' => SenderController::processText($comment->answer,$sender_name,$pageId), 'attachment_url' => $$comment->link], SettingsController::getPageToken($pageId));
                                                    }else{
                                                        $facebook->post($parentId . '/comments', ['message' => SenderController::processText($comment->answer,$sender_name,$pageId)], SettingsController::getPageToken($pageId));
                                                    }
                                                    exit;
                                                }catch (\Exception $exception){
                                                    $facebook->post($parentId . '/comments', ['message' => SenderController::processText($comment->answer,$sender_name,$pageId)], SettingsController::getPageToken($pageId));
                                                    exit;
                                                }



                                        }
                                    }

                                }else{

                                    /*
                                     * Exception message
                                     *
                                     * */
                                    $facebook->post($parentId . '/comments', ['message' => "matching $match","attachment_url"=>"http://img.freepik.com/free-vector/company-flyer-with-stripes_1017-3864.jpg"], SettingsController::getPageToken($pageId));

                                }
                            }


                            exit;

                        }


                    } catch (\Exception $exception) {


                    }
                }
            }

        }

//        $sender = $input['entry'][0]['messaging'][0]['sender']['id'];
//        $page = $input['entry'][0]['messaging'][0]['recipient']['id'];
//        $postback = isset($input['entry'][0]['messaging'][0]['postback']['payload']) ? $input['entry'][0]['messaging'][0]['postback']['payload'] : "nothing";
//        $catPostBack = isset($input['entry'][0]['messaging'][0]['message']['quick_reply']['payload']) ? $input['entry'][0]['messaging'][0]['message']['quick_reply']['payload'] : "nothing";
//        $message = isset($input['entry'][0]['messaging'][0]['message']['text']) ? $input['entry'][0]['messaging'][0]['message']['text'] : "nothing";
//        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . Data::getToken();
//        $linking = isset($input['entry'][0]['messaging'][0]['account_linking']['status']) ? $input['entry'][0]['messaging'][0]['account_linking']['status'] : "nothing";
//
//        $location = isset($input['entry'][0]['messaging'][0]['message']['attachments'][0]['payload']['coordinates']) ? $input['entry'][0]['messaging'][0]['message']['attachments'][0]['payload']['coordinates'] : "nothing";


    }


    /**
     * @param $jsonData
     */

    public function test()
    {
        $shortCodes = [
            "{{sender}}"=> "prappo prince",
            "{{page_name}}" => "Sinat's shop"
        ];

        $codes = ["{{sender}}","{{page_name}}"];
        $values = ["Prappo Prince","Sinat's shop"];

        $data['{{email}}'] = 'prappo.prince@gmail.com';
        $data['{{country}}'] = 'Bangladesh';
        $arr = [];
        array_push($arr,$shortCodes,$data);




        $message = "Hi {{sender}} welcome to {{page_name}} {{page_name}}";
        echo strtr($message,$arr);


    }

    public static function fire($jsonData, $pageId)
    {
        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . SettingsController::getPageToken($pageId);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_exec($ch);


    }

    public function notify($content, $class, $type)
    {
        try {
            $notify = new Notification();
            $notify->content = $content;
            $notify->class = $class;
            $notify->type = $type;
            $notify->save();
        } catch (\Exception $exception) {
        }
    }




}
