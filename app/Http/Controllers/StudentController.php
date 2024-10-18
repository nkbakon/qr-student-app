<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('id', 'desc')->paginate(25);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }
}
