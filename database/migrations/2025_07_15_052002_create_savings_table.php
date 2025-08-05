<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('transaction_code')->unique();
            $table->enum('type', ['deposit', 'withdrawal']);
            $table->decimal('amount', 15, 2);
            $table->decimal('balance', 15, 2);
            $table->date('transaction_date');
            $table->text('description')->nullable();
            $table->string('created_by');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('savings');
    }
};
