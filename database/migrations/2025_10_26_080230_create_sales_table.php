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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('code'); // medicine code
            $table->string('name')->nullable(); // medicine name (optional for easier display)
            $table->integer('quantity'); // sold quantity (user entered)
            $table->string('unit_type'); // علبة - شريط - حبة
            $table->decimal('price', 10, 2); // price per sale or per unit
            $table->decimal('total', 12, 2)->nullable(); // optional total amount
            $table->date('date');
            $table->decimal('shipping_price', 10, 2)->nullable();
            $table->string('note')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // who processed the sale
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
