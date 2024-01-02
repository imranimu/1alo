<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAddonPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_addon_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('course_purchase_id');
            $table->integer('addon_id');
            $table->string('name', 150);
            $table->decimal('amount', 8, 2);
            $table->enum('status', ['0', '1'])->default(1)->comment('0 = Inactive, 1 = Active');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_addon_purchases');
    }
}
