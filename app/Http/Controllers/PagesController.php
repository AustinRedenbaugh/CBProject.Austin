<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\CountyAndCitie;

class PagesController extends Controller
{
    public function index(){
        // $countyandcities = CountyAndCitie::all();
        // $states = State::all();
        return view('pages.index');
        // ->with('states', $states)->with('countyandcities', $countyandcities);
    }

    public function about(){
        $data = array(
            'title' => 'About Austin',
            'skills' => ['numchucks',
                        'fighting wildebeasts', 
                        'laravel']
        );
        return view('pages.about')->with($data);
    }
}
