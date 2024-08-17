<?php

namespace App\Http\Controllers;

use App\Models\Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function usersList(){
        if(Auth::user()->role == 0){
            $users_list = User::where('id','!=',Auth::user()->id)->paginate(10);
        }else{
            $users_list = User::where('id','!=',Auth::user()->id)->where('role','!=',0)->paginate(10);
        }
        return view('frontend.users_list',[
            'users_list'=>$users_list,
        ]);
    }
    function UserDelete(Request $request){
        $UserId = $request->input('id');

        $User = User::find($UserId);

        if ($User) {
            $User->delete();
            return response()->json(['success' => 'User deleted successfully']);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
    function EmailDelete(Request $request){
        $EmailID = $request->input('id');

        $email = Mail::find($EmailID);

        if ($email) {
            $email->delete();
            return response()->json(['success' => 'User deleted successfully']);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
}
