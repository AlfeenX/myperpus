<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained(
                table:'members', indexName: 'borrowings_member_id'
            );
            $table->foreignId('book_id')->constrained(
                table:'books', indexName: 'borrowings_book_id'
            );
            $table->foreignId('user_id')->constrained(
                table:'users', indexName: 'borrowings_user_id'
            );
            $table->date('borrow_date');
            $table->date('due_date');
            $table->date('return_at')->nullable();
            $table->enum('status',['Dipinjam','Selesai', 'Terlambat'])->default('Dipinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
