<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug','category','summary','description','cover_image','features','technologies','project_status','website_url','android_url','ios_url','brochure','featured','active','sort_order'];

    protected function casts(): array
    {
        return ['features'=>'array','technologies'=>'array','featured'=>'boolean','active'=>'boolean'];
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }
}
