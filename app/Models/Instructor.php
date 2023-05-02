<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{

    protected $table = 'instructors';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    public function studentsInstructors(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Student::class, 'instructor_id');
    }

}
