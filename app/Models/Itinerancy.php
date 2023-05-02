<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerancy extends Model
{

    protected $table = 'itinerancies';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    public function evaluations(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Evaluation::class);
    }

}
