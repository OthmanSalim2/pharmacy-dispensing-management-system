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
        Schema::create('rohta_medicines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // who adds the Rohta
            $table->string('patient_name');
            $table->string('medicine_code'); // foreign key to pharmacy_stock.code
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price');
            $table->timestamps();

            $table->foreign('medicine_code')->references('code')->on('pharmacy_stocks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rohta_medicines');
    }
};
