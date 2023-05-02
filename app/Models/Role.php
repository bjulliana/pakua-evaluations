<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = 'roles';
    public $timestamps = false;

    const ADMIN = 'Admin';
    const INSTRUCTOR = 'Instructor';
    const ITINERANT = 'Itinerant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];
}
