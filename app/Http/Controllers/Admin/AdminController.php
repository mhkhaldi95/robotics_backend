<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller ;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
class AdminController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }


    public function index(){
        if(!$this->user->hasPermission('read-admins')){
            return response()->json([
                'error' =>[
                    'en' =>'User does not have any of the necessary access rights.',
                    'ar' => 'المستخدم ليس لديه أي من حقوق الوصول الضرورية.'
                ],
            ],403);

        }
        $admins = Admin::whereRoleIs('admin')->get();
        return response()->json($admins,200);


    }
    public function store(Request $request)
    {
        if(!$this->user->hasPermission('create-admins')){
            return response()->json([
                'error' =>[
                    'en' =>'User does not have any of the necessary access rights.',
                    'ar' => 'المستخدم ليس لديه أي من حقوق الوصول الضرورية.'
                ],
            ],403);
        }

            $valditor = Validator::make($request->all(), Admin::$rule,Admin::$messages);
        if($valditor->fails()){
            return response()->json($valditor->errors(),401);
        }

        $data = $request->except($request->permissions);
        $data['password'] = bcrypt($data['password']);
        $admin = Admin::create($data);

        if($request->image){
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/admins'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $admin->image()->save($image);
        }else{
            $image = Image::create([]);
            $admin->image()->save($image);
        }
        $admin->attachRole('admin');
        $admin->attachPermissions($request->permissions);



        return response()->json([
            'admin' => $admin,
            'success' =>[
                'en' =>'add done',
                'ar' => 'تمت الاضافة بنجاح'
            ],
        ],200);

    }

    public function update(Request $request,Admin $admin)
    {
        if(!$this->user->hasPermission('update-admins')){
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
            'user_name' => 'required|string|max:255|unique:fathers,user_name,'.$admin->id.'||unique:students,user_name,'.$admin->id.'|
                            |unique:trainers,user_name,'.$admin->id.'|unique:owners,user_name,'.$admin->id.'|unique:organizers,user_name,'.$admin->id.'|
                            |unique:sellers,user_name,'.$admin->id.'|unique:admins,user_name,'.$admin->id.'',
            'email' => 'required|string|max:255|unique:fathers,email,'.$admin->id.'||unique:students,email,'.$admin->id.'|
                            |unique:trainers,email,'.$admin->id.'|unique:owners,email,'.$admin->id.'|unique:organizers,email,'.$admin->id.'|
                            |unique:sellers,email,'.$admin->id.'|unique:admins,email,'.$admin->id.'',


            'password' => 'required|string|max:255',

        ];

        $valditor = Validator::make($request->all(), $rulesUpdate);
        if($valditor->fails()){
            return response()->json($valditor->errors(),401);
        }

        $data = $request->except($request->permissions);
        $data['password'] = bcrypt($data['password']);

        if($request->image){
            if($request->image->getClientOriginalName()!='default.png'&&$request->image!=null){
                Storage::disk('public_uploads')->delete('/image_user/admins/'.$admin->image->dsec_url );
                $admin->image()->delete();
            }
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/admins'), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $admin->image()->save($image);
        }

        $admin->update($data);
        if($request->permissions)
            $admin->syncPermissions($request->permissions);
        else{
            $admin->detachPermissions($admin->allPermissions());
        }


        return response()->json([
            'admin' => $admin,
            'success' =>[
                'en' =>'update done',
                'ar' => 'تمت التعديل بنجاح'
            ],
        ],200);
    }

    public function show(Admin $admin){
        if(!$this->user->hasPermission('read-admins')){
            return response()->json([
                'error' =>[
                    'en' =>'User does not have any of the necessary access rights.',
                    'ar' => 'المستخدم ليس لديه أي من حقوق الوصول الضرورية.'
                ],
            ],403);
        }
        return response()->json($admin,200);
    }
    public function destroy(Admin $admin){
        if(!$this->user->hasPermission('delete-admins')){
            return response()->json([
                'error' =>[
                    'en' =>'User does not have any of the necessary access rights.',
                    'ar' => 'المستخدم ليس لديه أي من حقوق الوصول الضرورية.'
                ],
            ],403);
        }
        if($admin->image->dsec_url!='default.png')
            Storage::disk('public_uploads')->delete('/image_user/admins/'.$admin->image->dsec_url );
        $admin->image->delete();

        $admin->delete();
        return response()->json([
            'success' =>[
                'en' =>'delete done',
                'ar' => 'تمت الحذف بنجاح'
            ],
        ],200);
    }
}
