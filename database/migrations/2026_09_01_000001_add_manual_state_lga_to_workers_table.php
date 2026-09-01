<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            // Allow null when worker enters state/LGA manually
            $table->string('state_name', 150)->nullable()->after('residential_address');
            $table->string('lga_name', 150)->nullable()->after('state_name');

            // Make FK columns nullable so manual-entry records are valid
            $table->foreignId('state_id')->nullable()->change();
            $table->foreignId('lga_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->dropColumn(['state_name', 'lga_name']);
            $table->foreignId('state_id')->nullable(false)->change();
            $table->foreignId('lga_id')->nullable(false)->change();
        });
    }
};
