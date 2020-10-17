<?php

namespace Modules\Store\Http\Controllers\Admin;

use App\Student;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Store\Entities\Purchase;
use Modules\Store\Http\Controllers\Student\PackageStudentController;

class AcceptPurchasePackageController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }

    public function index()
    {
        return view('store::index');
    }

    public function create()
    {
        return view('store::create');
    }

    public function store(Request $request , Purchase $purchase)
    {
        $purchase->update([
            'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
        ]);

        $packageItem = $purchase->item->details;
        $student = $purchase->student;
        $result =  PackageStudentController::store($request,$packageItem,$student);
        return response()->json($result);

    }

    public function show($id)
    {
        return view('store::show');
    }

    public function edit($id)
    {
        return view('store::edit');
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
