<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug','summary','description','icon','image','benefits','process','featured','active','sort_order','seo_title','seo_description'];

    protected function casts(): array
    {
        return ['benefits'=>'array','process'=>'array','featured'=>'boolean','active'=>'boolean'];
    }
}
