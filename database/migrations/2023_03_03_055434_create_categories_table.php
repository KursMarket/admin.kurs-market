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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('meta_h1')->nullable();
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('show_in_catalog')->default(false);
            $table->boolean('show_in_rating')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('text_before_courses_list')->nullable();
            $table->text('text_after_courses_list')->nullable();
            $table->string('url')->unique();
            $table->timestamps();


            $table->foreign('type_id')->references('id')->on('catalog_types')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['type_id']);
        });
        Schema::dropIfExists('categories');
    }
};
