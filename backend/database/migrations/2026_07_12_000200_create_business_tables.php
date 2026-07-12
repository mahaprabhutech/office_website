<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('department');
            $table->string('employment_type');
            $table->string('location');
            $table->string('experience')->nullable();
            $table->string('qualification');
            $table->json('skills')->nullable();
            $table->json('responsibilities')->nullable();
            $table->longText('description');
            $table->string('salary_range')->nullable();
            $table->unsignedInteger('openings')->default(1);
            $table->date('deadline')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('location')->nullable();
            $table->string('qualification');
            $table->string('experience')->nullable();
            $table->text('skills')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->text('cover_letter')->nullable();
            $table->string('resume');
            $table->string('status')->default('received');
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('company')->nullable();
            $table->string('service')->nullable();
            $table->string('budget_range')->nullable();
            $table->text('message');
            $table->string('attachment')->nullable();
            $table->string('status')->default('new')->index();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('follow_up_at')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('mobile');
            $table->string('project_type');
            $table->json('platforms')->nullable();
            $table->longText('description');
            $table->string('budget')->nullable();
            $table->date('expected_date')->nullable();
            $table->string('attachment')->nullable();
            $table->string('contact_method')->nullable();
            $table->string('status')->default('received')->index();
            $table->decimal('estimated_amount', 14, 2)->nullable();
            $table->string('proposal')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('enquiries');
        Schema::dropIfExists('job_applications');
        Schema::dropIfExists('jobs');
    }
};
