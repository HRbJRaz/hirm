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
        Schema::create('units', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID PK

            $table->string('designator')->unique();
            $table->string('name');

            // optional – if divisions table exists later
            $table->foreignUuid('div_id')
                ->nullable()
                ->constrained('divisions')
                ->nullOnDelete();

            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('afs')->nullable();

            // UUID FK → users.id
            $table->foreignUuid('manager_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignUuid('unit_id')
                ->nullable()
                ->constrained('units')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
