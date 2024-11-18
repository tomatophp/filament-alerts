<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications_templates', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('body')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications_templates', function (Blueprint $table) {
            $table->string('title')->change();
            $table->string('body')->nullable()->change();
        });
    }
};
