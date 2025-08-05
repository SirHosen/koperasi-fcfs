<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->string('payment_code')->unique();
            $table->integer('installment_number');
            $table->decimal('amount', 15, 2);
            $table->date('payment_date');
            $table->decimal('penalty', 15, 2)->default(0);
            $table->enum('status', ['paid', 'pending'])->default('pending');
            $table->string('received_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
