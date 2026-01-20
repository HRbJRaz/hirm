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
        Schema::create('hazards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('hazard_ref')->unique();
            $table->date('date_registered');
            $table->foreignUuid('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();
            $table->string('fir');
            $table->string('source');
            $table->string('scope');
            $table->text('generic_hazard');
            $table->text('specific_hazard');
            $table->date('occurrence_date')->nullable();
            $table->text('description');
            $table->text('consequence');
            $table->foreignUuid('initial_severity_id')
                ->constrained('risk_severities')
                ->restrictOnDelete();

            $table->foreignUuid('initial_probability_id')
                ->constrained('risk_probabilities')
                ->restrictOnDelete();

            $table->string('initial_risk_index');        // e.g. 4B
            $table->string('initial_tolerability');      // Acceptable / Tolerable / Intolerable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazards');
    }
};
