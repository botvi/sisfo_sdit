<?php

namespace App\Http\Controllers\bendahara;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardBendaharaController extends Controller
{
 public function index(){
    return view('pagebendahara.dashboard.index');
 }
}
