<?php

use App\Models\Sale;
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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->smallInteger('type')->default(Sale::SALE_TYPE);
            $table->dateTime('date_from')->nullable();
            $table->dateTime('date_to')->nullable();
            $table->decimal('discount')->default(0);
            $table->enum('discount_type', [Sale::PERCENT_DISCOUNT, Sale::FIX_DISCOUNT]);

            $table->foreign('school_id')->references('user_id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });
        Schema::dropIfExists('sales');
    }
};
