<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = Schema::getColumnListing('projects');

        Schema::table('projects', function (Blueprint $table) use ($columns) {
            if (!in_array('product_type', $columns, true)) {
                $table->string('product_type', 80)->nullable();
            }
            if (!in_array('tagline', $columns, true)) {
                $table->string('tagline', 320)->nullable();
            }
            if (!in_array('logo_image', $columns, true)) {
                $table->string('logo_image', 500)->nullable();
            }
            if (!in_array('problem_statement', $columns, true)) {
                $table->text('problem_statement')->nullable();
            }
            if (!in_array('solution_overview', $columns, true)) {
                $table->longText('solution_overview')->nullable();
            }
            if (!in_array('project_plan', $columns, true)) {
                $table->longText('project_plan')->nullable();
            }
            if (!in_array('audiences', $columns, true)) {
                $table->json('audiences')->nullable();
            }
            if (!in_array('workflow', $columns, true)) {
                $table->json('workflow')->nullable();
            }
            if (!in_array('roadmap', $columns, true)) {
                $table->json('roadmap')->nullable();
            }
            if (!in_array('security_features', $columns, true)) {
                $table->json('security_features')->nullable();
            }
            if (!in_array('impact_points', $columns, true)) {
                $table->json('impact_points')->nullable();
            }
        });
    }

    public function down(): void
    {
        $columns = Schema::getColumnListing('projects');
        $drop = array_values(array_intersect($columns, [
            'product_type',
            'tagline',
            'logo_image',
            'problem_statement',
            'solution_overview',
            'project_plan',
            'audiences',
            'workflow',
            'roadmap',
            'security_features',
            'impact_points',
        ]));

        if ($drop) {
            Schema::table('projects', function (Blueprint $table) use ($drop) {
                $table->dropColumn($drop);
            });
        }
    }
};
