<?php

namespace Modules\Accounts\Http\Controllers\Student;

use App\Student;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Validator;

class UpdateStudentProfileController extends Controller
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
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|max:255|unique:students,email|unique:fathers,email|
                                            |unique:trainers,email|unique:owners,email|unique:organizers,email|
                                            |unique:sellers,email|unique:admins,email',
            ],
            [
                'firstName.required' => 'First Name is required',
                'lastName.required' => 'Last Name is required',
                'userName.required' => 'User Name is required',
                'firstName.string' => 'First Name must be String',
                'lastName.string' => 'Last Name must be String',
                'email.required' => 'Email is required',
            ]
        );

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $student->update($valditor->validated());
        return response()->json([
            'success' => true,
            'data' => $student
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
