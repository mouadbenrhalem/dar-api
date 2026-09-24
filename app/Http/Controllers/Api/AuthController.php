<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; use App\Models\User; use Illuminate\Http\Request; use Illuminate\Support\Facades\Hash;
class AuthController extends Controller {
 public function login(Request $request){$data=$request->validate(['email'=>'required|email','password'=>'required|string']);$user=User::where('email',$data['email'])->first();if(!$user||!$user->is_admin||!Hash::check($data['password'],$user->password))return response()->json(['message'=>'Identifiants administrateur incorrects.'],422);$user->tokens()->delete();return ['token'=>$user->createToken('admin-dashboard')->plainTextToken,'admin'=>['name'=>$user->name,'email'=>$user->email]];}
 public function logout(Request $request){$request->user()->currentAccessToken()->delete();return response()->noContent();}
}
