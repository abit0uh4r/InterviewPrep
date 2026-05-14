<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('domains')) {
            return;
        }

        if (Schema::hasColumn('domains', 'users_id') && ! Schema::hasColumn('domains', 'user_id')) {
            Schema::table('domains', function (Blueprint $table) {
                $table->renameColumn('users_id', 'user_id');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('domains')) {
            return;
        }

        if (Schema::hasColumn('domains', 'user_id') && ! Schema::hasColumn('domains', 'users_id')) {
            Schema::table('domains', function (Blueprint $table) {
                $table->renameColumn('user_id', 'users_id');
            });
        }
    }
};
