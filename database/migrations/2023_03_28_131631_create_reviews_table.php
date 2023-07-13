<?php

use App\Enums\Reviews\Sources;
use App\Enums\Reviews\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('author')->nullable();
            $table->string('email')->nullable();
            $table->unsignedSmallInteger('grade');
            $table->text('text');
            $table->enum('status', Status::getReviewStatuses());
            $table->enum('source', Sources::getReviewSources());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableForeignKeys('reviews');

            $indexesToCheck = [
                'reviews_school_id_foreign',
                'reviews_course_id_foreign',
                'reviews_user_id_foreign',
            ];

            foreach ($indexesToCheck as $item) {
                if (array_key_exists($item, $indexes)) {
                    DB::statement("ALTER TABLE `". $table->getTable() ."` DROP FOREIGN KEY `". $item ."`;");
                }
            }
        });

        Schema::dropIfExists('reviews');
    }
};
