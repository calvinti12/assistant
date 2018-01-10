<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

use App\Http\Requests;

class NotificationController extends Controller
{
    public static function process($verb, $item)
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Notification::all()->count() == 0) {
            return "No notification";
        } else {
            $notify = Notification::orderBy('id', 'desc')->first();
            $icon = "";
            if($notify->item == "message"){
                $icon = "<i class='fa fa-envelope'></i>";
            }elseif ($notify->item == "comment"){
                $icon = "<i class='fa fa-comment'></i>";
            }
            return $icon." ".$notify->content . " <i class='fa fa-clock-o'></i><b> Time : " . $notify->created_at . "</b>";
        }


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

    public static function notify($type, $content, $item)
    {
        $notify = new Notification();
        $notify->type = $type;
        $notify->content = $content;
        $notify->item = $item;
        $notify->save();
    }
}
