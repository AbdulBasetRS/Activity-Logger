<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    public function up()
    {
        Schema::create(config('activity-logger.table_name'), function (Blueprint $table) {
            $table->id();
            $table->string('event')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('model')->nullable();
            $table->integer('model_id')->nullable();
            $table->json('old')->nullable();
            $table->json('new')->nullable();
            $table->string('ip')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->text('referring_url')->nullable();
            $table->text('current_url')->nullable();
            $table->string('device_type')->nullable();
            $table->string('operating_system')->nullable();
            $table->text('description')->nullable();
            $table->json('other_info')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('activity-logger.table_name'));
    }
}
