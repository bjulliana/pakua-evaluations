<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'students';
    public $timestamps = false;

    const EVALUATION_OPTIONS = [
        'Belt and Patch',
        'Patch Only',
        'Stripes Only',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'evaluation_id',
        'name',
        'receipt_number',
        'instructor_id',
        'current_belt_id',
        'has_stripes',
        'months_practice',
        'age',
        'is_paid',
        'evaluating_for',
        'activity_1',
        'activity_2',
        'activity_3',
        'activity_4',
        'activity_5',
        'activity_6',
        'received_belt_id',
        'received_stripes',
        'notes',
        'order'
    ];

    public function evaluation(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Evaluation::class);
    }

    public function receivedBelt(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Belt::class, 'received_belt_id');
    }

    public function currentBelt(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Belt::class, 'current_belt_id');
    }

    public function instructor(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Instructor::class);
    }

    public static function getLastStudentCreatedForEvaluation($evaluation_id) {
        return self::where('evaluation_id', $evaluation_id)->orderBy('id', 'DESC')->first();
    }
}
