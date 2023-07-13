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
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('study_duration_key')->nullable()->after('study_duration');
            $table->string('sale_key')->nullable()->after('sale');

            $table->foreign('study_duration_key')->references('id')->on('study_durations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['study_duration_key']);

            $table->dropColumn('study_duration_key');
        });
    }
};
