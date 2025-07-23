<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use function Livewire\Volt\title;

class Task extends Model
{
protected $fillable=[
      'title',
    'is_completed',
    'user_id', 
    'due_date',
     'priority',      
      'description',// 🔐 associate with user
];

protected $casts = [
    'due_date' => 'datetime',
    'is_completed' => 'boolean',
];

// Add user relationship
public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
}
