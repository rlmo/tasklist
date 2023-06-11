<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'completed',
        'deleted',
        'username',
    ];

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'task_id');
    }
}
