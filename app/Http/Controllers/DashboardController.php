<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // cek user yang login
        if ($user->hasRole('admin')) {
            return view('admin.dashboard.index');
        } else {
            return view('operator.dashboard.index');
        }
    }
}
