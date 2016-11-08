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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function processText($message,$sender_name,$pageId){
//        $shortCodes = [
//            '{{sender}}'=> $sender_name,
//            '{{page_name}}' => FacebookPages::where('pageId',$pageId)->value('pageName')
//        ];
        $shortCodes['{{sender}}'] = $sender_name;
        $shortCodes['{{page_name}}'] =FacebookPages::where('pageId',$pageId)->value('pageName');
        foreach(ShortCode::all() as $short){
            $shortCodes[$short->code] = $short->value;
        }

        return strtr($message,$shortCodes);

    }
}
