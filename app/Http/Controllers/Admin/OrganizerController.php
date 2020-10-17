<?php

namespace App\Http\Controllers\Admin;

use App\Document;
use App\Http\Controllers\Controller;
use App\Identifier;
use App\Image;
use App\Organizer;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
class OrganizerController extends Controller
{

    public function register(Request $request)
    {
        $valditor = Validator::make($request->all(), Organizer::$rule,Organizer::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $organizer = Organizer::create($data);
        if($request->image){
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/organizers'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $organizer->image()->save($image);
        }else{
            $image = Image::create([]);
            $organizer->image()->save($image);
        }
        $documentName = $request->document->getClientOriginalName();
        $request->document->move(public_path('/uploads/document_user/organizers'), $documentName);
        $document = Document::create(['dsec_url'=>$documentName]);
        $identifier = Identifier::create([]);
        $identifier->document()->save($document);
        $organizer->document()->save($document);
        $organizer->approved_at = Carbon::now(new DateTimeZone('Asia/riyadh'));
        $organizer->save();
        return response()->json($organizer,200);
    }

    public function update(Request $request,Organizer $organizer)
    {
        $rulesUpdate = [
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:fathers,user_name,'.$organizer->id.'||unique:students,user_name,'.$organizer->id.'|
                            |unique:Organizers,user_name,'.$organizer->id.'|unique:owners,user_name,'.$organizer->id.'|unique:organizers,user_name,'.$organizer->id.'|
                            |unique:sellers,user_name,'.$organizer->id.'|unique:admins,user_name,'.$organizer->id.'',
            'email' => 'required|string|max:255|unique:fathers,email,'.$organizer->id.'||unique:students,email,'.$organizer->id.'|
                            |unique:Organizers,email,'.$organizer->id.'|unique:owners,email,'.$organizer->id.'|unique:organizers,email,'.$organizer->id.'|
                            |unique:sellers,email,'.$organizer->id.'|unique:admins,email,'.$organizer->id.'',


            'password' => 'required|string|max:255',
            'age'=>'required|numeric',
            'address'=>'required',
            'document'=>'required|mimes:pdf,doc,docx,jpeg,jpg,png|max:10000'

        ];


        $valditor = Validator::make($request->all(), $rulesUpdate,Organizer::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }
        if($request->image){
            if($request->image->getClientOriginalName()!='default.png'&&$request->image!=null){
                Storage::disk('public_uploads')->delete('/image_user/organizers/'.$organizer->image->dsec_url );
                $organizer->image()->delete();
            }
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/organizers'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $organizer->image()->save($image);
        }
        $identifier  = $organizer->document->identifier;
        $documentName = $request->document->getClientOriginalName();
        Storage::disk('public_uploads')->delete('/document_user/organizers/'.$organizer->document->dsec_url );
        $identifier->delete();
        $organizer->document()->delete();
        $request->document->move(public_path('/uploads/document_user/organizers'), $documentName);
        $document = Document::create(['dsec_url'=>$documentName]);
        $identifier = Identifier::create([]);
        $identifier->document()->save($document);
        $organizer->document()->save($document);
        $organizer->update($valditor->validated());

        return response()->json($organizer,200);
    }

    public function show(Organizer $organizer){
        return response()->json($organizer,200);
    }

}
