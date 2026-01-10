<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')->constrained('users');
            $table->foreignId('staff_id')->constrained('users');

            $table->date('loan_date');
            $table->date('due_date'); // +7 hari
            $table->timestamp('returned_at')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['member_id', 'due_date']);
            $table->index('returned_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
