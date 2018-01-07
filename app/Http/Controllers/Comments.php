<?php

namespace App\Http\Controllers;

use App\FacebookPages;
use Illuminate\Http\Request;

use App\Http\Requests;

class Comments extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = \App\Comments::all();
        return view('commentlist', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = FacebookPages::all();
        return view('addcomment', compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (\App\Comments::where('question', $request->question)->where('pageId',$request->pageId)->exists()) {
            return "This question is already exists for this page";
        }
        try {
            $comment = new \App\Comments();
            $comment->pageId = $request->pageId;
            $comment->question = $request->question;
            $comment->answer = $request->answer;
            $comment->specified = $request->specified;
            $comment->postId = $request->postId;
            $comment->type = $request->type;
            if ($request->link != "") {
                $comment->link = $request->link;
            } else {
                $comment->link = "no";
            }
            $comment->save();

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
        try {
            \App\Comments::where('id', $id)->update([
                'question' => $request->question,
                'answer' => $request->answer
            ]);
            return "success";
        } catch (\Exception $exception) {
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
            \App\Comments::where('id', $id)->delete();
            return "success";
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
