<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            if (! Schema::hasColumn('instansi', 'verified_by')) {
                $table->foreignId('verified_by')
                    ->nullable()
                    ->after('longitude')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('instansi', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }

            if (! Schema::hasColumn('instansi', 'verification_note')) {
                $table->text('verification_note')->nullable()->after('verified_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            if (Schema::hasColumn('instansi', 'verified_by')) {
                $table->dropForeign(['verified_by']);
            }

            $columns = array_filter([
                Schema::hasColumn('instansi', 'verification_note') ? 'verification_note' : null,
                Schema::hasColumn('instansi', 'verified_at') ? 'verified_at' : null,
                Schema::hasColumn('instansi', 'verified_by') ? 'verified_by' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
