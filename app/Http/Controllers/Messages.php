<?php

namespace App\Http\Controllers;

use App\FacebookPages;
use Illuminate\Http\Request;

use App\Http\Requests;

class Messages extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = \App\Messages::all();
        return view('messagelist', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = FacebookPages::all();
        return view('addmessage', compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = null;
        $video = null;
        $audio = null;
        if ($request->image != "") {
            $image = $request->image;
        } elseif ($request->video != "") {
            $video = $request->video;
        } elseif ($request->audio == "") {
            $audio = $request->video;

        }

        try {
            $message = new \App\Messages();
            $message->pageId = $request->pageId;
            $message->question = $request->question;
            $message->answer = $request->answer;
            $message->image = $image;
            $message->video = $video;
            $message->audio = $audio;
            $message->save();
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
        try{
            \App\Messages::where('id',$id)->update([
                'question'=>$request->question,
                'answer'=>$request->answer
            ]);
            return "success";
        }catch (\Exception $exception){
            return $exception->getMessage();
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
        try {
            \App\Messages::where('id', $id)->delete();
            return "success";
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
