<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = ['title','slug','department','employment_type','location','experience','qualification','skills','responsibilities','description','salary_range','openings','deadline','active'];
    protected function casts(): array { return ['skills'=>'array','responsibilities'=>'array','deadline'=>'date','active'=>'boolean']; }
    public function applications() { return $this->hasMany(JobApplication::class); }
}
