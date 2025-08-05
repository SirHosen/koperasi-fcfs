<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('loan_number')->unique();
            $table->decimal('amount', 15, 2);
            $table->integer('duration_months');
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('monthly_payment', 15, 2);
            $table->decimal('total_payment', 15, 2);
            $table->decimal('remaining_payment', 15, 2);
            $table->text('purpose');
            $table->enum('status', ['pending', 'approved', 'rejected', 'paid'])->default('pending');
            $table->date('request_date');
            $table->date('approval_date')->nullable();
            $table->string('approved_by')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
