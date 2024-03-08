<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.userlist', compact('users'));
    }

    /**
     * Toggle the status (activate/deactivate) of a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->active = !$user->active;
        $user->save();

        return redirect()->back()->with('status', 'User status toggled successfully.');
    }

    /**
     * Show the form for editing the user's role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editRole($id)
    {
        $user = User::findOrFail($id);
        // Retrieve roles from your database or any other source
        $roles = ['Admin', 'User']; // Example roles
        return view('users.editRole', compact('user', 'roles'));
    }

    /**
     * Update the user's role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function changeRole(Request $request)
     {
         try {
             $userId = $request->input('user_id');
             $newRole = $request->input('new_role');
     
             // Find the user by ID
             $user = User::findOrFail($userId);
     
             // Update the user's role
             $user->role_id = $newRole;
             $user->save();
     
             // Optionally, you can redirect back to the user list or return a response
             return redirect()->back()->with('success', 'User role updated successfully.');
         } catch (ModelNotFoundException $e) {
             // Handle the case where the user is not found
             return redirect()->back()->with('error', 'User not found.');
         } catch (\Exception $e) {
             // Handle other exceptions
             return redirect()->back()->with('error', 'An error occurred while updating the user role.');
         }
     }
     

}
