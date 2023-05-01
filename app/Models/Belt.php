<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Belt extends Model
{

    protected $table = 'belts';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    public function studentsCurrentBelt(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany('Student', 'current_belt_id');
    }

    public function studentReceivedBelt(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany('Belt', 'received_belt_id');
    }

}
