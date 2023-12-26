<?php

namespace App\Models;

use App\Enums\TaskOwnerEnum;
use App\Enums\TaskPeriodEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => TaskPeriodEnum::class,
        'owner' => TaskOwnerEnum::class
    ];

    public function task()
    {
        return $this->belongsTo(Task::class,'task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
