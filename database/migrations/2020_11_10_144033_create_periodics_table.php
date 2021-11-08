<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('body')->nullable()->default(NULL);
            $table->unsignedSmallInteger('acquisition_year')->nullable();
            $table->unsignedSmallInteger('interval_id')->nullable();
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('format_id');
            $table->string('issn')->nullable();
            $table->string('publishing_location')->nullable();
            $table->unsignedSmallInteger('language_id');
            $table->string('shelf_code')->nullable();
            $table->text('details')->nullable()->default(NULL);
            $table->boolean('is_chosen')->default(false);
            $table->boolean('is_owned')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->string('status', 20)->default('draft');
            $table->timestamps();
            
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
        Schema::dropIfExists('periodics');
    }
}
