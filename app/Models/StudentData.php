<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentData extends Model {
    protected $table      = 'students_data';
    public    $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'photo'
    ];

    public function students(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Student::class, 'student_id');
    }
}
