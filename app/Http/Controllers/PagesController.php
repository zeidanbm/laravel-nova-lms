<?php

namespace App\Http\Controllers;

use App\Options\Menu;
use App\Options\Social;
use App\Options\FooterMenu;
use Illuminate\Http\Request;
use App\Options\FooterContact;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class PagesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('app');
    }
}
