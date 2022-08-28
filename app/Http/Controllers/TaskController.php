<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class TaskController extends Controller
{
    public function index()
    {
        return "hello, world";
    }

    public function db()
    {
      $student=Student::firstOrCreate(['name'=>'wandera moses'],['contact'=>'0781983636','course_id'=>'5']);
      return $student;
       
    }
}
