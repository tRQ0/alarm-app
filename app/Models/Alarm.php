<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\AlarmSoundService;

class Alarm extends Model
{
    use HasFactory;

     /**
     * Timestamp attributes enable/disable
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['alarm_time', 'screen_pause_duration', 'sound'];

}
