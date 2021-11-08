<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periodic_id');
            $table->string('volume')->nullable()->default(NULL);
            $table->unsignedSmallInteger('from')->nullable();
            $table->unsignedSmallInteger('to')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->unsignedSmallInteger('quality_id');
            $table->unsignedBigInteger('user_id');
            $table->string('status', 20)->default('draft');
            $table->timestamps();
            
            $table->foreign('periodic_id')->references('id')->on('periodics')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications');
    }
}
