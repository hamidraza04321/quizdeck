<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
    	return view('games.index');
    }

    public function menja()
    {
    	return view('games.menja');
    }

    public function colorBlast()
    {
    	return view('games.color-blast');
    }

    public function snake()
    {
    	return view('games.snake');
    }

    public function flipCard()
    {
    	return view('games.flip-card');
    }
}
