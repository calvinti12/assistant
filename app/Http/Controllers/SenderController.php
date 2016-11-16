<?php

namespace App\Http\Controllers;

use App\FacebookPages;
use App\ShortCode;
use Illuminate\Http\Request;

use App\Http\Requests;

class SenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public static function processText($message, $sender_name, $pageId, $question)
    {

        foreach (ShortCode::all() as $short) {
            $shortCodes[$short->code] = $short->value;
        }
        $shortCodes['{{sender}}'] = $sender_name;
        $shortCodes['{{message}}'] = $question;
        $shortCodes['{{page_name}}'] = FacebookPages::where('pageId', $pageId)->value('pageName');

        return strtr($message, $shortCodes);

    }

    /**
     * @param $id
     * @return string
     */
    public static function convertId($id)
    {
        if (is_int($id)) {
            return (string)$id;
        } else {
            return $id;
        }
    }

    /**
     * @param $userId
     * @param $message
     * @return string
     */


    public static function sendMessage($userId, $message)
    {

        $data = [
            "recipient" => [
                "id" => self::convertId($userId)
            ],
            "message" => [
                "text" => $message
            ]
        ];
        return json_encode($data);
    }

    /**
     * @param $userId
     * @param $imageUrl
     * @return string
     */
    public static function sendImage($userId, $imageUrl)
    {

        $data = '{
                    "recipient":{
                    "id":"' . $userId . '"
                 },
                   "message":{
                   "attachment":{
                   "type":"image",
                   "payload":{
                   "url":"' . $imageUrl . '"
                    }
                   }
                }
                }';
        return $data;

    }

    /**
     * @param $userId
     * @param $fileLink
     * @return string
     */
    public static function sendFile($userId, $fileLink)
    {

        $data = [
            "recipient" => [
                "id" => self::convertId($userId)
            ],
            "message" => [
                "attachment" => [
                    "type" => "file",
                    "payload" => [
                        "url" => $fileLink
                    ]
                ]

            ]
        ];
        return json_encode($data);
    }

    public static function sendAudio($userId, $fileLink)
    {

        $data = [
            "recipient" => [
                "id" => self::convertId($userId)
            ],
            "message" => [
                "attachment" => [
                    "type" => "audio",
                    "payload" => [
                        "url" => $fileLink
                    ]
                ]

            ]
        ];
        return json_encode($data);
    }

    public static function sendVideo($userId, $fileLink)
    {

        $data = [
            "recipient" => [
                "id" => self::convertId($userId)
            ],
            "message" => [
                "attachment" => [
                    "type" => "video",
                    "payload" => [
                        "url" => $fileLink
                    ]
                ]

            ]
        ];
        return json_encode($data);
    }

}
