<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'students';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'itinerancy_id',
        'discipline_id',
        'date'
    ];

    public function evaluations(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo('Evaluation');
    }

    public function receivedBelt(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo('Belt', 'received_belt_id');
    }

    public function currentBelt(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo('Belt', 'current_belt_id');
    }

}
