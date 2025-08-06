<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index()
    {
        $users = User::all();

        // Verifica que compact esté correcto
        return view('users.index', compact('users'));

        // O alternativamente:
        // return view('users.index', ['users' => $users]);
    }
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
