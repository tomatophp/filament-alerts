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
        Schema::create('notifications_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique();
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('url')->nullable();
            $table->string('icon')->default('heroicon-o-check-circle')->nullable();
            $table->string('type')->default('success')->nullable();
            $table->json('providers')->nullable();
            $table->string('action')->default('manual')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifiactions_templates');
        Schema::table('user_notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifiactions_templates', 'template_id')) {
                $table->dropColumn('template_id');
            }
        });
    }
};
