<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('activity-logger.table_name'), function (Blueprint $table) {
            $table->text('user_agent')->nullable()->after('ip');
            $table->string('accept_language')->nullable()->after('user_agent');
            $table->json('query_parameters')->nullable()->after('accept_language');
            $table->string('request_method')->nullable()->after('query_parameters');
            $table->json('headers')->nullable()->after('request_method');
        });
    }

    public function down(): void
    {
        Schema::table(config('activity-logger.table_name'), function (Blueprint $table) {
            $table->dropColumn('user_agent');
            $table->dropColumn('accept_language');
            $table->dropColumn('query_parameters');
            $table->dropColumn('request_method');
            $table->dropColumn('headers');
        });
    }
};
