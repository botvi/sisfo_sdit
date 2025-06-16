<?php

namespace App\Http\Controllers\kepala_sekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DashboardKepalaSekolahController extends Controller
{
 public function index(){
    return view('pagekepalasekolah.dashboard.index');
 }
}
