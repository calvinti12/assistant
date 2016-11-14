<?php

namespace App\Http\Controllers;

use App\ShortCode;
use Illuminate\Http\Request;

use App\Http\Requests;

class ShortCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = ShortCode::all();
        return view('shortcodelist',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas = ShortCode::paginate(5);
        return view('addcode',compact('datas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = $request->code;
        $value = $request->value;
        if($code == '{{sender}}' || $code == '{{page_name}}' || $code == '{{message}}'){
            return "You can't use {{sender}} , {{page_name}} and {{message}} keywords because those are being used by system";
        }
        if($code == ""){
            return "Code field can't be empty";
        }
        if($value == ""){
            return "Value can't be empty";
        }
        try{
            $shortCode = new ShortCode();
            $shortCode->code = $code;
            $shortCode->value = $value;
            $shortCode->save();
            return "success";
        }
        catch (\Exception $exception){
            return $exception->getMessage();
        }
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
        try{
            ShortCode::where('id',$id)->update([
               'code'=>$request->code,
                'value'=>$request->value
            ]);
            return "success";
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            ShortCode::where('id',$id)->delete();
            return "success";
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
