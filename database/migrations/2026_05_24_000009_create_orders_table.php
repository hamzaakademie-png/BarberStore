<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('address_id')->nullable()->constrained();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('balance_used', 10, 2)->default(0);
            $table->decimal('card_amount', 10, 2)->default(0);
            $table->enum('status', [
                'pending', 'approved', 'supplying', 'packing',
                'shipped', 'on_the_way', 'delivered', 'completed', 'cancelled'
            ])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
