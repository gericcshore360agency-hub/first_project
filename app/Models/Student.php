<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = [
        "first_name",
        "last_name",
        "user_id",
        "student_number",
    ];


    public function teacher(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
