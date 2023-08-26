<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatterHelper;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->component = "Component User";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $User = User::orderBy('id', 'asc')->get();

            $User_list = array("component" => $this->component, "data_component" => $User);

            if ($User == null)
                return ResponseFormatterHelper::successResponse(null, 'Data null');
            else if ($User)
                return ResponseFormatterHelper::successResponse($User_list, 'Success Get All Data');
            else
                return ResponseFormatterHelper::errorResponse(null, 'Data null');
        } catch (\Throwable $th) {
            return ResponseFormatterHelper::errorResponse(null, $th);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $User = [
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'email' => $request->email,
                'nrp' => $request->nrp,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'age' => $request->age,
                'gender' => $request->gender,
                'password' => $request->password,
                'role' => $request->role,
            ];

		    User::create($User);

            return ResponseFormatterHelper::successResponse($User, 'Create User Success');
        } catch (\Throwable $th) {
            return ResponseFormatterHelper::errorResponse(null, $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $User = User::find($id);

            $User_list = array("component" => $this->component, "data_component" => $User);

            if ($User == null)
                return ResponseFormatterHelper::successResponse(null, 'Data null');
            else if ($User)
                return ResponseFormatterHelper::successResponse($User_list, 'Success Get by ID User');
            else
                return ResponseFormatterHelper::errorResponse(null, 'Data null');
        } catch (\Throwable $th) {
            return ResponseFormatterHelper::errorResponse(null, $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByUser()
    {
        try {
            $User = User::where('user_id', Auth::user()->id)->get();

            $User_list = array("component" => $this->component, "data_component" => $User);

            if ($User == null)
                return ResponseFormatterHelper::successResponse(null, 'Data null');
            else if ($User)
                return ResponseFormatterHelper::successResponse($User_list, 'Success Get by ID User');
            else
                return ResponseFormatterHelper::errorResponse(null, 'Data null');
        } catch (\Throwable $th) {
            return ResponseFormatterHelper::errorResponse(null, $th);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // try {
            $User = User::find($id);

            $Userx = [
                'user_id' => Auth::user()->id,
                'User_number' => $request->User_number,
                'lattitude' => $request->lattitude,
                'longitude' => $request->longitude,
                'picture' => $request->picture,
            ];

            $User->update($Userx);

            return ResponseFormatterHelper::successResponse($Userx, 'Update Users Success');
        // } catch (\Throwable $th) {
        //     return ResponseFormatterHelper::errorResponse(null, $th);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::destroy($id);

            return ResponseFormatterHelper::successResponse('Users', 'Delete User Success');
        } catch (\Throwable $th) {
            return ResponseFormatterHelper::errorResponse(null, $th);
        }
    }
}