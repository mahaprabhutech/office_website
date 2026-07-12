<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $fillable = ['name','company','email','mobile','project_type','platforms','description','budget','expected_date','attachment','contact_method','status','estimated_amount','proposal','internal_notes'];
    protected function casts(): array { return ['platforms'=>'array','expected_date'=>'date','estimated_amount'=>'decimal:2']; }
}
