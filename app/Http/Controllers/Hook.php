<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Hook extends Controller
{
    public function index(Request $request){
        $challenge = $request->hub_challenge;
        $verify_token = $request->hub_verify_token;

        if ($verify_token === 'prappo') {
            return $challenge;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        Run::now($input);
    }
}
