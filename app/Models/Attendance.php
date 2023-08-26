<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = ['id','user_id', 'attendance_number', 'lattitude', 'longitude', 'picture', 'created_at', 'updated_at'];
}