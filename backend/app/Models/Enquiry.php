<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    protected $fillable = ['name','email','mobile','company','service','budget_range','message','attachment','status','assigned_to','follow_up_at','internal_notes'];
    protected function casts(): array { return ['follow_up_at'=>'datetime']; }
    public function assignee() { return $this->belongsTo(User::class, 'assigned_to'); }
}
