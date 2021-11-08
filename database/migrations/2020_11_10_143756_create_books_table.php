<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('sub_title')->nullable()->default(NULL);
            $table->text('body')->nullable()->default(NULL);
            $table->unsignedSmallInteger('acquisition_year')->nullable();
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('format_id');
            $table->string('isbn')->nullable();
            $table->smallInteger('quality_id');
            $table->smallInteger('language_id');
            $table->string('shelf_code')->nullable();
            $table->unsignedSmallInteger('publishing_year')->nullable();
            $table->string('publishing_location')->nullable();
            $table->unsignedSmallInteger('topic_id')->nullable();
            $table->unsignedSmallInteger('subtopic_id')->nullable();
            $table->unsignedBigInteger('series_id')->nullable()->default(NULL);
            $table->text('details')->nullable()->default(NULL);
            $table->boolean('is_chosen')->default(false);
            $table->boolean('is_owned')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->string('status', 20)->default('draft');
            $table->timestamps();
            
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('set null');
            $table->foreign('subtopic_id')->references('id')->on('subtopics')->onDelete('set null');
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
        Schema::dropIfExists('books');
    }
}
