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
            if (Schema::hasColumn('schools', 'legal_type')) {
                $table->dropColumn('legal_type');
            }

            if (Schema::hasColumn('schools', 'legal_name')) {
                $table->dropColumn('legal_name');
            }

            if (Schema::hasColumn('schools', 'owner_name')) {
                $table->dropColumn('owner_name');
            }

            if (Schema::hasColumn('schools', 'orgn')) {
                $table->dropColumn('orgn');
            }

            if (Schema::hasColumn('schools', 'kpp')) {
                $table->dropColumn('kpp');
            }

            if (Schema::hasColumn('schools', 'bank_account')) {
                $table->dropColumn('bank_account');
            }

            if (Schema::hasColumn('schools', 'bik')) {
                $table->dropColumn('bik');
            }

            if (Schema::hasColumn('schools', 'legal_type')) {
                $table->dropColumn('bank');
            }

            if (Schema::hasColumn('schools', 'cor_account')) {
                $table->dropColumn('cor_account');
            }

            if (Schema::hasColumn('schools', 'legal_address')) {
                $table->dropColumn('legal_address');
            }

            if (Schema::hasColumn('schools', 'social_links')) {
                $table->dropColumn('social_links');
            }

            if (Schema::hasColumn('schools', 'contact_person')) {
                $table->dropColumn('contact_person');
            }

            if (Schema::hasColumn('schools', 'passport')) {
                $table->dropColumn('passport');
            }

            if (Schema::hasColumn('schools', 'license')) {
                $table->dropColumn('license');
            }

            if (Schema::hasColumn('schools', 'license')) {
                $table->dropColumn('snils');
            }

            if (!Schema::hasColumn('schools', 'url')) {
                $table->string('url')->index('schools_url_uuu')->nullable();
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
        Schema::table('schools', function (Blueprint $table) {
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
            $table->string('social_links')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('passport')->unique()->nullable();
            $table->string('license')->nullable();
            $table->string('snils')->nullable();

            if (Schema::hasColumn('schools', 'url')) {
                $table->dropColumn('url');
                $table->dropIndex('schools_url_uuu');
            }
        });
    }
};
