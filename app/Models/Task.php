<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
