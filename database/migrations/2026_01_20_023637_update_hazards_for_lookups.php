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
        Schema::table('hazards', function (Blueprint $table) {
            // FIR becomes finite select (store as string still, but validate on form)
            // Ensure column exists: fir (string)

            // Replace source/scope/initial_risk_rating strings with FK
            $table->foreignId('source_id')->nullable()->after('fir')
                ->constrained('hazard_sources')->nullOnDelete();

            $table->foreignId('scope_id')->nullable()->after('source_id')
                ->constrained('hazard_scopes')->nullOnDelete();

            // Optional: if you previously had string columns:
            if (Schema::hasColumn('hazards', 'source')) {
                $table->dropColumn('source');
            }
            if (Schema::hasColumn('hazards', 'scope')) {
                $table->dropColumn('scope');
            }
            
        });
    }

    public function down(): void
    {
        Schema::table('hazards', function (Blueprint $table) {
            $table->dropConstrainedForeignId('source_id');
            $table->dropConstrainedForeignId('scope_id');

            $table->string('source')->nullable();
            $table->string('scope')->nullable();
        });
    }
};
