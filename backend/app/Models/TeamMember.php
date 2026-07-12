<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;
    protected $fillable = ['name','designation','department','bio','photo','skills','linkedin_url','email','active','sort_order'];
    protected function casts(): array { return ['skills'=>'array','active'=>'boolean']; }
}
