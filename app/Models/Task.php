<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'completed',
        'completed_at',
        'deleted',
        'deleted_at',
        'username',
    ];

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'task_id');
    }
}
