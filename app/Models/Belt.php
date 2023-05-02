<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Belt extends Model
{

    protected $table = 'belts';
    public $timestamps = false;

    const WHITE = 'White';
    const YELLOW = 'Yellow';
    const ORANGE = 'Orange';
    const GREEN = 'Green';
    const GREY = 'Grey';
    const BLUE = 'Blue';
    const RED = 'Red';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    public function studentsCurrentBelt(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Student::class, 'current_belt_id');
    }

    public function studentReceivedBelt(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Belt::class, 'received_belt_id');
    }

    public function badgeClass() {
        $colorMapping = [
            self::WHITE => 'white',
            self::YELLOW => 'warning',
            self::ORANGE => 'orange',
            self::GREEN => 'success',
            self::GREY => 'secondary',
            self::BLUE => 'primary',
            self::RED => 'danger',
        ];

        return $colorMapping[$this->name];
    }
}
