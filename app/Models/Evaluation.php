<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{

    protected $table = 'evaluations';
    public $timestamps = true;

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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
    ];

    public function students(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Student::class);
    }

    public function itinerancy(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Itinerancy::class);
    }

    public function discipline(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Discipline::class);
    }
}
