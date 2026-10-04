<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'product_type',
        'tagline',
        'summary',
        'description',
        'problem_statement',
        'solution_overview',
        'project_plan',
        'cover_image',
        'logo_image',
        'features',
        'technologies',
        'audiences',
        'workflow',
        'roadmap',
        'security_features',
        'impact_points',
        'project_status',
        'website_url',
        'android_url',
        'ios_url',
        'brochure',
        'featured',
        'active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'technologies' => 'array',
            'audiences' => 'array',
            'workflow' => 'array',
            'roadmap' => 'array',
            'security_features' => 'array',
            'impact_points' => 'array',
            'featured' => 'boolean',
            'active' => 'boolean',
        ];
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }
}
