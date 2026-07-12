<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','title','slug','category','excerpt','content','featured_image','tags','status','published_at','seo_title','seo_description'];
    protected function casts(): array { return ['tags'=>'array','published_at'=>'datetime']; }
    public function author() { return $this->belongsTo(User::class, 'user_id'); }
}
