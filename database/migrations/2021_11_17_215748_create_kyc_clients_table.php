<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKycClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kyc_clients', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('image');
            $table->string('selfie_image');
            $table->boolean('status')->nullable();
            $table->longText('comment')->nullable();
            $table->integer('no');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('type_id');
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('kyc_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kyc_clients');
    }
}
