<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{

    protected $table = 'disciplines';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    public function evaluations(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany('Evaluation');
    }

}
