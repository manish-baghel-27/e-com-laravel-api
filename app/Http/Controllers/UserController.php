<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// use App\Models\Role;

class UserController extends Controller
{
    public function create_user_api(Request $request){
        $validator = Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|max:191|unique:users,email',
            'password'=>'required|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else{
            $user = new User;
            $user->password = bcrypt($request->password);
            $user->email = $request->email;
            $user->name = $request->first_name.$request->last_name;
            $user->is_active = 1;
            $user->save();

            $token = $user->createToken($user->email.'_Token')->plainTextToken;
            return response()->json([
                'status'=>200,
                'username'=>$user->name,
                'token'=>$token,
                'message'=>'Regestered Successfully'
            ]);
        }
        // $user->roles()->attach([3]);
    }

    protected function user_login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>'required|max:191',
            'password'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'validation_error'=>$validator->messages(),
            ]);
        }
        else{
            $user = User::where('email', $request->email)->first();
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'=>'401',
                    'message'=>'Invalid credentials'
                ]);
            }
            else{
                if( ($user->roles->contains('role','Admin')) ){
                    $role= 'admin';
                    $token = $user->createToken($user->email.'_AdminToken',['server:admin'])->plainTextToken; 
                }
                else{
                    $role='';
                    $token = $user->createToken($user->email.'_Token')->plainTextToken;
                }
                return response()->json([
                    'status'=>200,
                    'username'=>$user->name,
                    'token'=>$token,
                    'message'=>'Loggedin Successfully',
                    'roles'=>$role
                ]);
            }
        }
    }

    protected function logout_user(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Logged Out Successfully.'
        ]);
    }
}
