<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_modules', function (Blueprint $table) {
            $table->id();
            $table->integer('courses_id');
            $table->string('name', 255);
            $table->integer('sort')->default(0);
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
        Schema::dropIfExists('courses_modules');
    }
}
