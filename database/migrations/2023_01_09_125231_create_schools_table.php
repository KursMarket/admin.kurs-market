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
        Schema::create('schools', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('short_title')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('partner_suffix')->nullable();
            $table->string('partner_postfix')->nullable();
            $table->longText('description')->nullable();
            $table->string('legal_type')->nullable();
            $table->string('legal_name')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('orgn')->nullable();
            $table->string('kpp')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bik')->nullable();
            $table->string('bank')->nullable();
            $table->string('cor_account')->nullable();
            $table->string('legal_address')->nullable();
            $table->string('site_link')->nullable();
            $table->string('site_link_text')->nullable();
            $table->string('social_links')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('passport')->unique()->nullable();
            $table->string('license')->nullable();
            $table->string('snils')->nullable();
            $table->tinyInteger('confirm_status')->nullable();
            $table->text('confirm_status_message')->nullable();
            $table->string('meta_point')->nullable();
            $table->integer('review_count')->default(0);
            $table->integer('rating')->default(0);
            $table->string('meta_h1')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('rating_image')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
};
