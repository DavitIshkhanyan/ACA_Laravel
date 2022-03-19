<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        dd('index from api');
    }
    public function show(Request $request, $id = null)
    {
//        dd($request);
//        dd($request->all());
//        dd($request->get('test', 'chka'));
//        dd($request->method());
//        dd($request->isMethod('post'));
//        dd($request->routeIs('show'));
//        $date = $request->date('date');
//        dd($date->format('Y-m-d'));
        dd($id);

    }
}
