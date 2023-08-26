<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function updateProfile(Request $request, $email)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'nrp' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            'age' => 'required',
            'gender' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $Users = User::where('email', $email)->firstOrFail();

        if ($request->password != null) {
            $password = Hash::make($request->password);
        }else{
            $password = $Users->password;
        }

        $User = [
            'name' => $request->name,
            'email' => $request->email,
            'nrp' => $request->nrp,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'age' => $request->age,
            'gender' => $request->gender,
            'password' => $password
         ];

         $Users->update($User);

        return response()->json($User);
    }

    public function register(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     `'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'nrp' => 'required',
        //     'address' => 'required',
        //     'date_of_birth' => 'required',
        //     'age' => 'required',
        //     'gender' => 'required',
        //     'password' => 'required|string|min:8',
        //     'role' => 'required'`
        // ]);

        // if($validator->fails()){
        //     return response()->json($validator->errors());
        // }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nrp' => $request->nrp,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'age' => $request->age,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'role' => $request->role,
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function getProfile($email)
    {
        $user = User::where('email', $email)->firstOrFail();

        return response()->json($user);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }

    public function logout_user()
    {
        Auth::logout();

        return redirect('login');
    }
}
