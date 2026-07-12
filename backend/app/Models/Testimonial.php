<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $fillable = ['name','organisation','designation','photo','review','rating','active','sort_order'];
    protected function casts(): array { return ['active'=>'boolean']; }
}
