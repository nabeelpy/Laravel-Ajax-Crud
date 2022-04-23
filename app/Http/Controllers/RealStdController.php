<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class RealStdController extends Controller
{

    public function std(Request $request)
    {
        $students =Student::get();
        return view('students',compact(['students']));
    }

    public function send(Request $request)
    {
        $std = Student::updateOrCreate(
            ['id'=>$request->id],
            ['name'=>$request->name],
            ['email'=>$request->email]
        );
        return response()->json($std);
    }


    public function destroy(Request $request,$id)
    {
        Student::where('id',$id)->delete();
        return response()->json("Success");
    }

    public function edit(Request $request,$id)
    {
        $students =Student::where('id',$id)->first();
        return response()->json($students);
    }

}
