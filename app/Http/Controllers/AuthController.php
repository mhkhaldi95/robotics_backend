<?php

namespace App\Http\Controllers;
use App\Document;
use App\Father;
use App\Identifier;
use App\Image;
use App\Organizer;
use App\Seller;
use App\Student;
use App\Trainer;
use Dotenv\Result\Success;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public $guard_name;
    public function __construct(Request $request)
    {
        $this->guard_name = $request->attributes->get("guard");
    }

    public function register(Request $request)
    {
        $rule = [
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:students,user_name|unique:fathers,user_name|
                            |unique:trainers,user_name|unique:owners,user_name|unique:organizers,user_name|
                            |unique:sellers,user_name|unique:admins,user_name',
            'email' => 'required|string|max:255|unique:students,email|unique:fathers,email|
                            |unique:trainers,email|unique:owners,email|unique:organizers,email|
                            |unique:sellers,email|unique:admins,email',
            'password' => 'required|string|max:255',
            'image' => 'mimes:jpeg,jpg,png|max:10000',
            // 'document'=>'required|mimes:pdf,doc,docx,jpeg,jpg,png|max:10000'
        ];

        $messages = [
            'first_name.required'=>'First name is required',
            'first_name.string'=>'First name must be string',
            'first_name.max'=>'First name must be long',

            'second_name.required'=>'Seconde name is required',
            'second_name.string'=>'Seconde name must be string',
            'second_name.max'=>'Seconde name must be long',

            'last_name.required'=>'Last name is required',
            'last_name.string'=>'Last name must be string',
            'last_name.max'=>'Last name must be long',

            'user_name.required'=>'User name is required',
            'user_name.string'=>'User name must be string',
            'user_name.max'=>'User name must be long',
            'user_name.unique'=>'User name must be unique',

            'email.required'=>'Email is required',
            'email.email'=>'Email must be email',
            'email.string'=>'Email must be string',
            'email.max'=>'Email must be long',
            'email.unique'=>'Email must be unique',

            'password.required'=>'Password is required',
            'password.string'=>'Password must be string',
            'password.max'=>'Password must be long',
            'password.confirmed'=>'Password must be confirmed',

        ];

        $father = null;

        if($request->role == 5){
            $rule += [
                'age'=>'required|numeric',
            ];
            $messages += [
                'age.required'=>'Age must be required',
                'age.numeric'=>'Age must be numeric'
            ];
        }

        $valditor = Validator::make($request->all(), $rule,$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $data = $request->all();
        $role_id = $data['role'];

        if($request->role != 5){ // الطالب 5
            $data= $request->except(['role','age','father_email']);
        }else{
            $data = $request->except(['role','father_email']);
            $father = Father::where('email',$request->father_email)->first();
            if($father == null){
                // نبعت لولي الامر على الإميل
                return response()->json([
                    'success' => false,
                    'message' => 'والدك غير مسجل في الموقع ، يجب عليه التسجيل'
                ]);
            }
        }


        $data['password'] = bcrypt($data['password']);
        $user_type = '';
        switch($role_id){
            case 1: $user = Trainer::create($data);$user_type='trainers';break;
            case 2: $user = Organizer::create($data);$user_type='organizers';break;
            case 3: $user = Seller::create($data);$user_type='sellers';break;
            case 4: $user = Father::create($data);$user_type='fathers';break;
            case 5: $user = Student::create($data);$user_type='students';
            if($father != null) $father->children()->save($user) ;break;
        }

        if($request->image){
            $imageName = time().'.'.$request->image->getClientOriginalName();
            $request->image->move(public_path('/uploads/image_user/'.$user_type), $imageName);
            $image = new \App\Image();
            $image->dsec_url =$imageName;
            $image->save();
            $user->image()->save($image);
        }else{
            $image = Image::create([]);
            $user->image()->save($image);
        }
        if($request->document){
            $documentName = $request->document->getClientOriginalName();
            $request->document->move(public_path('/uploads/document_user/'.$user_type), $documentName);
            $document = Document::create(['dsec_url'=>$documentName]);
            $identifier = Identifier::create([]);
            $identifier->document()->save($document);
            $user->document()->save($document);
        }


        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60
      ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $guards = ['owners','admins','fathers','trainers','sellers','organizers','students'];
        $this->token = null;
        $guard_name = "";
        foreach($guards as $guard){
            $token = $this->guard($guard)->attempt($credentials);
            if($token != null){
                $this->token = $token;
                $guard_name = $guard;
                break;
            }
        }

        if($this->token != null){
            return $this->respondWithToken([$this->token,$guard_name]);
        }
        else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function guard($guard_name=null)
    {
        if($guard_name==null){
            $guard_name = $this->guard_name;
        }
        return Auth::guard($guard_name);
    }
}
