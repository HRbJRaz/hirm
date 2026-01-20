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
        Schema::create('srm_records', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Core linkage
            $table->foreignUuid('hazard_action_id')
                ->constrained('hazard_actions')
                ->cascadeOnDelete()
                ->unique(); // 1 SRM per action

            // Responsibility
            $table->string('responsible_type'); // 'division' or 'unit'
            $table->uuid('responsible_id');     // division.id or unit.id

            // Implementation tracking
            $table->date('estimated_implementation_date')->nullable();
            $table->text('implementation_details')->nullable();
            $table->string('evidence_path')->nullable();
            $table->date('actual_completion_date')->nullable();

            // Risk assessment
            $table->foreignUuid('severity_id')
                ->constrained('risk_severities')
                ->restrictOnDelete();

            $table->foreignUuid('probability_id')
                ->constrained('risk_probabilities')
                ->restrictOnDelete();

            $table->string('risk_index'); // e.g. 4B (computed)

            // Workflow
            $table->enum('status', ['Active', 'Review', 'Approval', 'Closed'])
                ->default('Active');

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('srm_records');
    }
};
