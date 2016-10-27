<?php

namespace App\Http\Controllers;


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
            $postId = isset($input['entry'][0]['changes'][0]['value']['postId']) ? $input['entry'][0]['changes'][0]['value']['post_id']:"";
            $item = isset($input['entry'][0]['changes'][0]['value']['item']) ? $input['entry'][0]['changes'][0]['value']['item']:"";
            $verb = isset($input['entry'][0]['changes'][0]['value']['verb']) ? $input['entry'][0]['changes'][0]['value']['verb']:"";

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

                    /*
                     * trying to reply
                     * */

                    try {
                        $response = $facebook->post($commentId . '/comments', ['message' => 'Hi ' . $sender_name . "\nYou said " . $message, 'attachment_url' => ''], SettingsController::getPageToken($pageId));
                        print_r($response->getDecodedBody());
                    } catch (\Exception $exception) {

                        /*
                         * If can't reply then try to reply via parent ID
                         *
                         * */

                        try {
                            $response = $facebook->post($parentId . '/comments', ['message' => 'Hi ' . $sender_name . "\nYou said " . $message], SettingsController::getPageToken($pageId));
                            print_r($response->getDecodedBody());
                        } catch (\Exception $e) {
                            return $e->getMessage();
                        }

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


        $date = date('Y-m-d h:i:s','1477595389331');
//        echo "New York ". $date;

        echo SettingsController::convertTime($date, true)."<br>";
    }

    public static function fire($jsonData)
    {
        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=' . SettingsController::getToken();
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
