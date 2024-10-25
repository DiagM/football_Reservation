<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
{
    // Get the currently logged-in user
    $user = Auth::user();

    // Get the roles of the logged-in user
    $roles  = $user->roles;

    // Pass the roles to the view
    return view('user', compact('roles'));
}
public function getUsers(Request $request)
{
    if ($request->ajax()) {
        $authUserId = auth()->id();

        $users = User::where('id', '!=', $authUserId)->get();

        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $editBtn = '<a id="editEventButton" data-bs-toggle="modal" data-subscription-id="'.$row->id.'" data-bs-target="#editModal" class="icon-pencil-alt green-button"></a>';
                $deleteBtn = '<a id="deleteEventButton" data-bs-toggle="modal" data-subscription-id="'.$row->id.'" data-bs-target="#confirmationModal" class="icon-trash red-button"></a>';

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}


public function submit(Request$request){

    // Validate the form data
$validator = Validator::make($request->all(), [
 'name' => 'required|string|max:255',
 'email'=>'max:191',
 'password' => 'required|string|max:255',
]);

// If validation fails, return the errors
if ($validator->fails()) {
 return response()->json(['errors' => $validator->errors()], 422);
}
// Create a new subscription
$user=User::create([
 'name' => $request->name,
 'email' => $request->email,
 'password' => Hash::make($request->password),

]);
$role=explode(",",$request->roles);
            $user->syncRoles($role);
// Return a success response
return response()->json(['message' => 'Subscription added successfully']);

}

public function fetch($id)
{

    $user = User::find($id);
   $roles= $user->roles;

    return response()->json(['status'=>200,'user'=>$user,'roles'=>$roles]);
}

public function update(Request $request, $id)
{
    // Validate the form data
    $validator = Validator::make($request->all(), [
        'Ename' => 'required|string|max:255',
        'Eemail'=>'max:191',
    ]);

    // If validation fails, return the errors
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Find the subscription by its ID
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'Subscription not found'], 404);
    }

    // Update subscription properties
    $user->name = $request->Ename;
    $user->email = $request->Eemail;


    // Save the updated subscription
    $user->save();
    $role=explode(",",$request->roles);
    $user->syncRoles($role);
    // Return a success response
    return response()->json(['message' => 'Subscription updated successfully']);
}

public function delete(Request $request,$id)
    {

        $user = User::find($id);

        $user->delete();
        return response()->json(['status'=>200,'id'=>$id]);


    }

}
