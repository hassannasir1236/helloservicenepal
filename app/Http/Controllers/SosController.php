<?php

namespace App\Http\Controllers;


class SosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sos()
    {
        return view('sos_goride.index');
    }

    public function sosEdit($id)
    {
        return view('sos_goride.edit')->with('id', $id);

    }


}
