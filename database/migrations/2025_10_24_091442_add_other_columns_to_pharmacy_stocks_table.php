<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pharmacy_stocks', function (Blueprint $table) {
            $table->integer('pills_per_strip')->after('unit_type')->default(1); // عدد الحبوب في الشريط
            $table->integer('strips_per_box')->after('pills_per_strip')->default(1); // عدد الشرائط في العلبة
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pharmacy_stocks', function (Blueprint $table) {
            $table->dropColumn(['pills_per_strip', 'strips_per_box']);
        });
    }
};
