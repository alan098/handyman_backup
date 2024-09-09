<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class PerfilController extends Controller
{


    public function index()
    {

        Log::info(__FILE__.'/'.__FUNCTION__);
        return view('perfil');
    }
}
