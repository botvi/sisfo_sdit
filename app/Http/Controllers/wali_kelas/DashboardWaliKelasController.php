<?php

namespace App\Http\Controllers\wali_kelas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DashboardWaliKelasController extends Controller
{
 public function index(){
    return view('pagewalikelas.dashboard.index');
 }
}
