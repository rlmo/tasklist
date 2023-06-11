<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'name',
        'filepath',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
