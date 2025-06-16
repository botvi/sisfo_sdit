<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
 public function index(){
    return view('pageadmin.dashboard.index');
 }
}
