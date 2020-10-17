<?php

namespace App\Http\Controllers\Admin;

use App\Document;
use App\Http\Controllers\Controller;
use App\Identifier;
use App\Image;
use App\Student;
use App\Trainer;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class TrainerController extends Controller
{
    public function register(Request $request)
    {
        $valditor = Validator::make($request->all(), Trainer::$rule,Trainer::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $trainer = Trainer::create($data);

        if($request->image){
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/trainers'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $trainer->image()->save($image);
        }else{
            $image = Image::create([]);
            $trainer->image()->save($image);
        }
        $documentName = $request->document->getClientOriginalName();
        $request->document->move(public_path('/uploads/document_user/trainers'), $documentName);
        $document = Document::create(['dsec_url'=>$documentName]);
        $identifier = Identifier::create([]);
        $identifier->document()->save($document);
        $trainer->document()->save($document);
        $trainer->approved_at = Carbon::now(new DateTimeZone('Asia/riyadh'));
        $trainer->save();
        return response()->json($trainer,200);

    }

    public function show(Trainer $trainer){
        return response()->json($trainer,200);
    }

    public function update(Request $request,Trainer $trainer)
    {
        $rulesUpdate = [
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:fathers,user_name,'.$trainer->id.'||unique:students,user_name,'.$trainer->id.'|
                            |unique:trainers,user_name,'.$trainer->id.'|unique:owners,user_name,'.$trainer->id.'|unique:organizers,user_name,'.$trainer->id.'|
                            |unique:sellers,user_name,'.$trainer->id.'|unique:admins,user_name,'.$trainer->id.'',
            'email' => 'required|string|max:255|unique:fathers,email,'.$trainer->id.'||unique:students,email,'.$trainer->id.'|
                            |unique:trainers,email,'.$trainer->id.'|unique:owners,email,'.$trainer->id.'|unique:organizers,email,'.$trainer->id.'|
                            |unique:sellers,email,'.$trainer->id.'|unique:admins,email,'.$trainer->id.'',


            'password' => 'required|string|max:255',
            'age'=>'required|numeric',
            'address'=>'required',
            'document'=>'required|mimes:pdf,doc,docx,jpeg,jpg,png|max:10000'

        ];


        $valditor = Validator::make($request->all(), $rulesUpdate,Trainer::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
         }
        if($request->image){
            if($request->image->getClientOriginalName()!='default.png'&&$request->image!=null){
                Storage::disk('public_uploads')->delete('/image_user/trainers/'.$trainer->image->dsec_url );
                $trainer->image()->delete();
            }
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/trainers'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $trainer->image()->save($image);
        }
        $identifier  = $trainer->document->identifier;
        $documentName = $request->document->getClientOriginalName();

        Storage::disk('public_uploads')->delete('/document_user/trainers/'.$trainer->document->dsec_url );
        $identifier->delete();
        $trainer->document()->delete();
        $request->document->move(public_path('/uploads/document_user/trainers'), $documentName);
        $document = Document::create(['dsec_url'=>$documentName]);
        $identifier = Identifier::create([]);
        $identifier->document()->save($document);
        $trainer->document()->save($document);
        $trainer->update($request->all());

        return response()->json($trainer,200);
    }
}
