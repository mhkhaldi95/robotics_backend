<?php

namespace App\Http\Controllers\Admin;

use App\Document;
use App\Father;
use App\Http\Controllers\Controller;
use App\Identifier;
use App\Image;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
class FatherController extends Controller
{
    public function register(Request $request)
    {
        $valditor = Validator::make($request->all(), Father::$rule,Father::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $father = Father::create($data);

        if($request->image){
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/fathers'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $father->image()->save($image);
        }else{
            $image = Image::create([]);
            $father->image()->save($image);
        }
        $documentName = $request->document->getClientOriginalName();
        $request->document->move(public_path('/uploads/document_user/fathers'), $documentName);
        $document = Document::create(['dsec_url'=>$documentName]);
        $identifier = Identifier::create([]);
        $identifier->document()->save($document);
        $father->document()->save($document);
        return response()->json($father,200);

    }

    public function show(Father $father){
        return response()->json($father,200);
    }

    public function update(Request $request,Father $father)
    {
        $rulesUpdate = [
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:fathers,user_name,'.$father->id.'||unique:students,user_name,'.$father->id.'|
                            |unique:trainers,user_name,'.$father->id.'|unique:owners,user_name,'.$father->id.'|unique:organizers,user_name,'.$father->id.'|
                            |unique:sellers,user_name,'.$father->id.'|unique:admins,user_name,'.$father->id.'',
            'email' => 'required|string|max:255|unique:fathers,email,'.$father->id.'||unique:students,email,'.$father->id.'|
                            |unique:trainers,email,'.$father->id.'|unique:owners,email,'.$father->id.'|unique:organizers,email,'.$father->id.'|
                            |unique:sellers,email,'.$father->id.'|unique:admins,email,'.$father->id.'',


            'password' => 'required|string|max:255',
            'age'=>'required|numeric',
            'address'=>'required',
            'document'=>'required|mimes:pdf,doc,docx,jpeg,jpg,png|max:10000'

        ];


        $valditor = Validator::make($request->all(), $rulesUpdate,Father::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }
        if($request->image){
            if($request->image->getClientOriginalName()!='default.png'&&$request->image!=null){
                Storage::disk('public_uploads')->delete('/image_user/fathers/'.$father->image->dsec_url );
                $father->image()->delete();

            }
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/fathers'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $father->image()->save($image);
        }
        $identifier  = $father->document->identifier;
        $documentName = $request->document->getClientOriginalName();
        Storage::disk('public_uploads')->delete('/document_user/father/'.$father->document->dsec_url );
        $identifier->delete();
        $father->document()->delete();
        $request->document->move(public_path('/uploads/document_user/students'), $documentName);
        $document = Document::create(['dsec_url'=>$documentName]);
        $identifier = Identifier::create([]);
        $identifier->document()->save($document);
        $father->document()->save($document);
        $father->update($request->all());

        return response()->json($father,200);
    }

}
