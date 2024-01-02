<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseModuleHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_module_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('courses_id');
            $table->integer('module_id');
            $table->integer('total_lession');
            $table->longText('complete_lession')->nullable();
            $table->integer('ongoing_lession')->nullable();
            $table->enum('examination_status', ['0', '1'])->default(0)->comment('0 = pending, 1 = completed');
            $table->enum('module_status', ['0', '1'])->default(0)->comment('0 = pending, 1 = completed');
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
        Schema::dropIfExists('course_module_histories');
    }
}
