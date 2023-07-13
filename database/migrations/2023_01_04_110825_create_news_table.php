<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\News;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->enum('type_id', [News::NEWS, News::ARTICLE])->nullable();
            $table->string('title');
            $table->longText('text')->nullable();
            $table->string('url')->unique();
            $table->string('link')->nullable();
            $table->text('visible_for')->nullable();
            $table->string('section')->nullable();
            $table->bigInteger('views')->default(0);
            $table->string('meta_h1')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
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
        Schema::dropIfExists('news');
    }
};
