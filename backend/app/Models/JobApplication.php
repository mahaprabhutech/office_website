<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    protected $fillable = ['job_id','name','email','mobile','location','qualification','experience','skills','portfolio_url','cover_letter','resume','status','internal_notes'];
    public function job() { return $this->belongsTo(Job::class); }
}
