<?php

namespace App\Http\Controllers\Admin;

use App\Document;
use App\Http\Controllers\Controller ;
use App\Identifier;
use App\Student;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Validator;

class StudentController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }
    public function index(){
        if(!$this->user->hasPermission('read-students')){
            return response()->json([
                'error' =>[
                    'en' =>'User does not have any of the necessary access rights.',
                    'ar' => 'المستخدم ليس لديه أي من حقوق الوصول الضرورية.'
                ],
            ],403);

        }
        return response()->json(Student::all(),200);


    }
    public function store(Request $request)
    {
        if(!$this->user->hasPermission('create-students')){
            return response()->json([
                'error' =>[
                    'en' =>'User does not have any of the necessary access rights.',
                    'ar' => 'المستخدم ليس لديه أي من حقوق الوصول الضرورية.'
                ],
            ],403);
        }
        $valditor = Validator::make($request->all(), Student::$rule,Student::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $student = Student::create($data);

        if($request->image){
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/students'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $student->image()->save($image);
        }else{
            $image = Image::create([]);
            $student->image()->save($image);
        }
        $documentName = $request->document->getClientOriginalName();
        $request->document->move(public_path('/uploads/document_user/students'), $documentName);
        $document = Document::create(['dsec_url'=>$documentName]);
        $identifier = Identifier::create([]);
        $identifier->document()->save($document);
        $student->document()->save($document);


        return response()->json([
            'admin' => $student,
            'success' =>[
                'en' =>'add done',
                'ar' => 'تمت الاضافة بنجاح'
            ],
        ],200);

    }

    public function update(Request $request,Student $student)
    {
        if(!$this->user->hasPermission('update-students')){
            return response()->json([
                'error' =>[
                    'en' =>'User does not have any of the necessary access rights.',
                    'ar' => 'المستخدم ليس لديه أي من حقوق الوصول الضرورية.'
                ],
            ],403);
        }
         $rulesUpdate = [
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:fathers,user_name,'.$student->id.'||unique:students,user_name,'.$student->id.'|
                            |unique:trainers,user_name,'.$student->id.'|unique:owners,user_name,'.$student->id.'|unique:organizers,user_name,'.$student->id.'|
                            |unique:sellers,user_name,'.$student->id.'|unique:admins,user_name,'.$student->id.'',
            'email' => 'required|string|max:255|unique:fathers,email,'.$student->id.'||unique:students,email,'.$student->id.'|
                            |unique:trainers,email,'.$student->id.'|unique:owners,email,'.$student->id.'|unique:organizers,email,'.$student->id.'|
                            |unique:sellers,email,'.$student->id.'|unique:admins,email,'.$student->id.'',


            'password' => 'required|string|max:255',
            'age'=>'required|numeric',
             'document'=>'required|mimes:pdf,doc,docx,jpeg,jpg,png|max:10000'

         ];


        $valditor = Validator::make($request->all(), $rulesUpdate,Student::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),401);
        }



        if($request->image){
            if($request->image->getClientOriginalName()!='default.png'&&$request->image!=null){
                Storage::disk('public_uploads')->delete('/image_user/students/'.$student->image->dsec_url );
                $student->image()->delete();
                }
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/students'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $student->image()->save($image);
        }
        $identifier  = $student->document->identifier;
        $documentName = $request->document->getClientOriginalName();
        Storage::disk('public_uploads')->delete('/document_user/students/'.$student->document->dsec_url );
        $identifier->delete();
        $student->document()->delete();
        $request->document->move(public_path('/uploads/document_user/students'), $documentName);
        $document = Document::create(['dsec_url'=>$documentName]);
        $identifier = Identifier::create([]);
        $identifier->document()->save($document);
        $student->document()->save($document);
        $student->update($request->all());

        return response()->json([
            'admin' => $student,
            'success' =>[
                'en' =>'update done',
                'ar' => 'تمت التعديل بنجاح'
            ],
        ],200);
    }

    public function show(Student $student){
        if(!$this->user->hasPermission('read-students')){
            return response()->json([
                'error' =>[
                    'en' =>'User does not have any of the necessary access rights.',
                    'ar' => 'المستخدم ليس لديه أي من حقوق الوصول الضرورية.'
                ],
            ],403);
        }
        return response()->json($student,200);
    }
    public function destroy(Student $student){
        if(!$this->user->hasPermission('delete-students')){
            return response()->json([
                'error' =>[
                    'en' =>'User does not have any of the necessary access rights.',
                    'ar' => 'المستخدم ليس لديه أي من حقوق الوصول الضرورية.'
                ],
            ],403);
        }
        if($student->image->dsec_url!='default.png')
            Storage::disk('public_uploads')->delete('/image_user/students/'.$student->image->dsec_url );
        $student->image->delete();
        $student->document->delete();
        $student->courses()->detach();
        $student->leaded_teams()->delete();

//        $student->certifications()->delete();
        $student->evaluations()->delete();

        $student->attendances()->delete();
        $student->teams()->detach();

        $student->invitations()->detach();
        $student->joinRequests()->detach();
        $student->orders()->delete();

        $student->purchases()->delete();

        $student->packageSubscriptions()->detach();
        $student->terms()->detach();
        $student->delete();
        return response()->json([
            'success' =>[
                'en' =>'delete done',
                'ar' => 'تمت الحذف بنجاح'
            ],
        ],200);
    }
}
