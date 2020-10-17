<?php

namespace Modules\Accounts\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use App\Student;
use Illuminate\Support\Facades\Hash;
use Validator;

class UpdateStudentPasswordController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index()
    {
        return view('accounts::index');
    }

    public function create()
    {
        return view('accounts::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('accounts::show');
    }

    public function edit($id)
    {
        return view('accounts::edit');
    }

    public function update(Request $request, Student $student)
    {
        $valditor = Validator::make($request->all(),
            [
                'old_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required',
            ],
            [
                'old_password.required' => 'old password is required',
                'new_password.required' => 'new password is required',
                'confirm_password.required' => 'confirm password is required',
            ]
        );

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $result =  Hash::check($request->input('old_password'), $student->password);
        if($result){
            if($request->input('new_password') == $request->input('confirm_password')) {

                $student->password = Hash::make($request->input('new_password'));
            }else {
                return response()->json([
                    'success' => false,
                    'error' =>[
                        'en' =>'password does not match',
                        'ar' => 'تأكيد كلمة المرور غير صحيحة'
                    ],
                ],401);
            }
            }else {
                return response()->json([
                    'success' => false,
                    'error' =>[
                        'en' =>'password old not true',
                        'ar' => 'كلمة السر القديمة خاطئة'
                    ],
                ],401);
            }
        $student->save();
        return \response()->json([
            'success' => true,
            'message' => [
                'en' => 'password was changed',
                'ar' => 'تمت عملية تغيير كلمة المرور بنجاح'
            ],
            'data' => $student
        ]);

    }

    public function destroy($id)
    {
        //
    }
}
