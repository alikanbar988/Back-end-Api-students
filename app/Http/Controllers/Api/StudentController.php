<?php

namespace App\Http\Controllers\Api;

use App\Models\student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        
        $student = student::all();
        if($student->count()>0){
        return response()->json([
            'status' => 200,
            'students'=>$student
        
        ],200);
    
}else{
    return response()->json([
        'status'=>404,
        'message'=>'No data found'
    ],404);
}
    }

    public function store(request $requset){
        $validator =validator::make($requset->all(),[
            'name'=>'required|string|max:191',
            'course'=>'required|string|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|digits:8',
   
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],422);

        }else{
            $student =student::create([
                'name'=>$requset->name,
                'course'=>$requset->course,
                'email'=>$requset->email,
                'phone'=>$requset->phone
                ]);
                if ($student){
                    return response()->json([
                        'status'=>200,
                        'message'=>'Student has been created successfully!'
                    ],200);
                }else {
                    return response()->json([
                        'status'=>404,
                        'message'=>"something worng!"
                    ],404);
                }

        
        }
      

    } 
     public function show($id){
        $student=student::find($id);
        if($student)
        {
            return response()->json([
                'status' => 200,
                'students'=>$student
            
            ],200);
    
        } else{
            return response()->json([
                'status'=>404,
                'message'=>"No data found"
            ],404);
        }
    }

public function edit($id){
 

    $student = Student::find($id);

   if( $student) {
     return response()->json([
            'status'=>200,
            'student'=>$student
     ],200);
     } else{
        return response()->json([
            'status'=>404,
            'message'=>'no data found!'
        ],404);


    } 
}
    public function update (request $requset, int $id){

        $validator =validator::make($requset->all(),[
            'name' => 'required|string|max:191',
            'course'=>'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:8'
            // Add more validation rules as needed
        ]);

       if($validator->fails()){
        return response()->json([
            'status'=>422,
            'errors'=>$validator->messages()
        ],422);
       }else{
        $student=student::find($id);
        $student->update([
            'name'=>$requset->name,
            'course'=>$requset->course,
            'email'=>$requset->email,
            'phone'=>$requset->phone
            ]);
            if($student){
                return response()->json ([
                    'status'=>200,
                    'message'=>"Student updated successfully."
                ],200);
            }else{

        return response()->json([
            'status'=>500,
            'message'=>'no data found!'
        ],500);

    }
       }
    
    }

    public function destroy($id){
        $student= student::find($id);
    if ($student -> delete()) {
        return response () -> json ([
            'status'=>200,
            'message'=>'Record deleted Successfully.'
        ],200);
     } else{
        return response()->json([
            'status'=>500,
            'message'=>'no data found!'
        ],500);

    }
    
    }}