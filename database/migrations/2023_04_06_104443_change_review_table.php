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
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'author')) {
                $table->dropColumn('author');
            }
            if (Schema::hasColumn('reviews', 'email')) {
                $table->dropColumn('email');
            }
            if (!Schema::hasColumn('reviews', 'user_id')) {
                $table->bigInteger('user_id')->nullable()->after('course_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->string('author')->nullable();
            $table->string('email')->nullable();

            $table->dropColumn('user_id');
        });
    }
};
