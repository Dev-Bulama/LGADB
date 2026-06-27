<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->index('status');
            $table->index('verification_status');
            $table->index('department_id');
            $table->index('unit_id');
            $table->index('office_id');
            $table->index('lga_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['verification_status']);
            $table->dropIndex(['department_id']);
            $table->dropIndex(['unit_id']);
            $table->dropIndex(['office_id']);
            $table->dropIndex(['lga_id']);
            $table->dropIndex(['created_at']);
        });
    }
};
