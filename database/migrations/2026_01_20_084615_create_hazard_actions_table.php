<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hazard_actions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('hazard_id')
                ->constrained('hazards')
                ->cascadeOnDelete();

            // 1) Corrective Action (Yes/No)
            $table->boolean('is_corrective_action')->default(false);

            // 2) Safety Risk Mitigation Action (Yes/No)
            $table->boolean('is_mitigation_action')->default(false);

            // 3) Register Safety Risk Assessment / Safety Review no.
            $table->string('sra_sr_ref')->nullable();

            // 4) Upload SRA/SR
            $table->string('sra_sr_file_path')->nullable();

            // 5) Action Priority
            $table->enum('priority', ['High', 'Medium', 'Low']);

            // Useful extras (recommended)
            $table->date('due_date')->nullable(); // derived from priority if you want
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hazard_actions');
    }
};