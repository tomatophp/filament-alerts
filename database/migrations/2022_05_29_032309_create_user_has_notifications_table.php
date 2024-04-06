<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_notifications', function (Blueprint $table) {
            $table->id();

            //If Selected Record On the model
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            $table->string('provider')->default('pusher')->nullable();
            $table->string('provider_token')->nullable();

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
        Schema::dropIfExists('user_has_notifications');
    }
};
