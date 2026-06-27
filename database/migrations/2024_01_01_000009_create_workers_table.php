<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Personal Information
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');

            // Contact
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->unique()->nullable();

            // Identity
            $table->string('national_id')->nullable();
            $table->string('bvn')->nullable();
            $table->string('tax_number')->nullable();

            // Address
            $table->text('residential_address')->nullable();
            $table->foreignId('state_id')->constrained('states');
            $table->foreignId('lga_id')->constrained('lgas');
            $table->foreignId('ward_id')->nullable()->constrained('wards')->nullOnDelete();

            // Employment Assignment
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('office_id')->nullable()->constrained('offices')->nullOnDelete();

            // Employment Details
            $table->string('designation');
            $table->string('grade_level')->nullable();
            $table->string('step')->nullable();
            $table->string('salary_category')->nullable();
            $table->enum('employment_type', ['permanent', 'contract', 'temporary', 'casual'])->default('permanent');
            $table->date('employment_date')->nullable();
            $table->date('confirmation_date')->nullable();
            $table->string('employee_number')->unique()->nullable();
            $table->string('staff_number')->unique();

            // Status
            $table->enum('status', [
                'pending', 'verified', 'active', 'suspended', 'transferred',
                'retired', 'resigned', 'dismissed', 'deceased', 'archived',
            ])->default('pending');
            $table->enum('verification_status', ['pending', 'under_review', 'approved', 'rejected'])->default('pending');
            $table->string('verification_code')->unique()->nullable();
            $table->string('verification_hash')->unique()->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();

            // Supervisor
            $table->unsignedBigInteger('supervisor_id')->nullable();

            // Medical
            $table->string('blood_group')->nullable();

            // ID Card
            $table->timestamp('id_card_generated_at')->nullable();
            $table->date('id_expiry_date')->nullable();

            // Next of Kin
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->string('next_of_kin_relationship')->nullable();
            $table->text('next_of_kin_address')->nullable();

            // Emergency Contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            // JSON fields
            $table->json('qualifications')->nullable();
            $table->json('certifications')->nullable();
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();

            // Notes
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Self-referential FK for supervisor
            $table->foreign('supervisor_id')->references('id')->on('workers')->nullOnDelete();
        });

        // Add deferred FK constraints for head_id fields now that workers table exists
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('head_id')->references('id')->on('workers')->nullOnDelete();
        });

        Schema::table('units', function (Blueprint $table) {
            $table->foreign('head_id')->references('id')->on('workers')->nullOnDelete();
        });

        Schema::table('offices', function (Blueprint $table) {
            $table->foreign('head_id')->references('id')->on('workers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->dropForeign(['head_id']);
        });
        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign(['head_id']);
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['head_id']);
        });
        Schema::dropIfExists('workers');
    }
};
