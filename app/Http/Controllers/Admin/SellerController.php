<?php

namespace App\Http\Controllers\Admin;

use App\Document;
use App\Http\Controllers\Controller;
use App\Identifier;
use App\Image;
use App\Seller;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
class SellerController extends Controller
{
    public function register(Request $request)
    {
        $valditor = Validator::make($request->all(), Seller::$rule,Seller::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $seller = Seller::create($data);
        if($request->image){
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/sellers'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $seller->image()->save($image);
        }else{
            $image = Image::create([]);
            $seller->image()->save($image);
        }
        $documentName = $request->document->getClientOriginalName();
        $request->document->move(public_path('/uploads/document_user/sellers'), $documentName);
        $document = Document::create(['dsec_url'=>$documentName]);
        $identifier = Identifier::create([]);
        $identifier->document()->save($document);
        $seller->document()->save($document);
        $seller->approved_at = Carbon::now(new DateTimeZone('Asia/riyadh'));
        $seller->save();
        return response()->json($seller,200);
    }

    public function update(Request $request,Seller $seller)
    {
        $rulesUpdate = [
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:fathers,user_name,'.$seller->id.'||unique:Sellers,user_name,'.$seller->id.'|
                            |unique:trainers,user_name,'.$seller->id.'|unique:owners,user_name,'.$seller->id.'|unique:organizers,user_name,'.$seller->id.'|
                            |unique:sellers,user_name,'.$seller->id.'|unique:admins,user_name,'.$seller->id.'',
            'email' => 'required|string|max:255|unique:fathers,email,'.$seller->id.'||unique:Sellers,email,'.$seller->id.'|
                            |unique:trainers,email,'.$seller->id.'|unique:owners,email,'.$seller->id.'|unique:organizers,email,'.$seller->id.'|
                            |unique:sellers,email,'.$seller->id.'|unique:admins,email,'.$seller->id.'',


            'password' => 'required|string|max:255',
            'age'=>'required|numeric',
            'address'=>'required',
            'document'=>'required|mimes:pdf,doc,docx,jpeg,jpg,png|max:10000'

        ];


        $valditor = Validator::make($request->all(), $rulesUpdate,Seller::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }
        if($request->image){
            if($request->image->getClientOriginalName()!='default.png'&&$request->image!=null){
                Storage::disk('public_uploads')->delete('/image_user/sellers/'.$seller->image->dsec_url );
                $seller->image()->delete();
            }
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/sellers'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $seller->image()->save($image);
        }
        $identifier  = $seller->document->identifier;
        $documentName = $request->document->getClientOriginalName();
        Storage::disk('public_uploads')->delete('/document_user/sellers/'.$seller->document->dsec_url );
        $identifier->delete();
        $seller->document()->delete();
        $request->document->move(public_path('/uploads/document_user/sellers'), $documentName);
        $document = Document::create(['dsec_url'=>$documentName]);
        $identifier = Identifier::create([]);
        $identifier->document()->save($document);
        $seller->document()->save($document);
        $seller->update($request->all());

        return response()->json($seller,200);
    }

    public function show(Seller $seller){
        return response()->json($seller,200);
    }
}
