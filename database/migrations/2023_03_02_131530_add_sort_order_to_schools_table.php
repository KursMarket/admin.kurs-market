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
        Schema::table('schools', function (Blueprint $table) {
            if (Schema::hasColumn('schools', 'meta_h1')) {
                $table->dropColumn('meta_h1');
            }

            if (Schema::hasColumn('schools', 'rating')) {
                $table->dropColumn('rating');
            }

            if (Schema::hasColumn('schools', 'review_count')) {
                $table->dropColumn('review_count');
            }

            if (Schema::hasColumn('schools', 'rating_image')) {
                $table->dropColumn('rating_image');
            }

            if (Schema::hasColumn('schools', 'confirm_status_message')) {
                $table->dropColumn('confirm_status_message');
            }

            $table
                ->integer('sort_order')
                ->after('url')
                ->default(0)
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            if (!Schema::hasColumn('schools', 'meta_h1')) {
                $table->string('meta_h1')->after('meta_point');
            }

            if (!Schema::hasColumn('schools', 'rating')) {
                $table->string('rating')->after('meta_point');
            }

            if (!Schema::hasColumn('schools', 'review_count')) {
                $table->string('review_count')->after('meta_point');
            }

            if (!Schema::hasColumn('schools', 'rating_image')) {
                $table->string('rating_image')->after('meta_point');
            }

            if (!Schema::hasColumn('schools', 'confirm_status_message')) {
                $table->string('confirm_status_message')->after('meta_point');
            }

            $table->dropColumn('sort_order');
        });
    }
};
