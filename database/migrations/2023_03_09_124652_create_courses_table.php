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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('prefix')->nullable();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->text('source_link')->nullable();
            $table->boolean('show_in_rating')->default(false);
            $table->unsignedBigInteger('study_duration')->nullable();
            $table->decimal('price');
            $table->decimal('sale')->nullable();
            $table->integer('credit_price')->nullable();
            $table->integer('credit_month')->nullable();
            $table->text('additional_description')->nullable();
            $table->integer('feed_id')->nullable();
            $table->integer('sort_order_in_schools')->default(0);
            $table->integer('sort_order_in_categories')->default(0);
            $table->string('url')->unique();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
