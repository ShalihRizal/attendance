<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatterHelper;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class AttendanceController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->component = "Component Attendance";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $Attendance = Attendance::orderBy('id', 'desc')->get();

            $Attendance_list = array("component" => $this->component, "data_component" => $Attendance);

            if ($Attendance == null)
                return ResponseFormatterHelper::successResponse(null, 'Data null');
            else if ($Attendance)
                return ResponseFormatterHelper::successResponse($Attendance_list, 'Success Get All Data');
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
            $Attendance = [
                'user_id' => Auth::user()->id,
                'attendance_number' => $request->attendance_number,
                'lattitude' => $request->lattitude,
                'longitude' => $request->longitude,
                'picture' => $request->picture,
            ];

		    Attendance::create($Attendance);

            return ResponseFormatterHelper::successResponse($Attendance, 'Create Attendance Success');
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
            $Attendance = Attendance::find($id);

            $Attendance_list = array("component" => $this->component, "data_component" => $Attendance);

            if ($Attendance == null)
                return ResponseFormatterHelper::successResponse(null, 'Data null');
            else if ($Attendance)
                return ResponseFormatterHelper::successResponse($Attendance_list, 'Success Get by ID Attendance');
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
            $Attendance = Attendance::where('user_id', Auth::user()->id)->get();

            $Attendance_list = array("component" => $this->component, "data_component" => $Attendance);

            if ($Attendance == null)
                return ResponseFormatterHelper::successResponse(null, 'Data null');
            else if ($Attendance)
                return ResponseFormatterHelper::successResponse($Attendance_list, 'Success Get by ID User');
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
            $Attendance = Attendance::find($id);

            $Attendancex = [
                'user_id' => Auth::user()->id,
                'attendance_number' => $request->attendance_number,
                'lattitude' => $request->lattitude,
                'longitude' => $request->longitude,
                'picture' => $request->picture,
            ];

            $Attendance->update($Attendancex);

            return ResponseFormatterHelper::successResponse($Attendancex, 'Update Attendances Success');
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
            Attendance::destroy($id);

            return ResponseFormatterHelper::successResponse('Attendances', 'Delete Attendance Success');
        } catch (\Throwable $th) {
            return ResponseFormatterHelper::errorResponse(null, $th);
        }
    }
}