<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_results', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_id');
            $table->integer('user_id');
            $table->string('yes_ans', 255);
            $table->string('no_ans', 255);
            $table->json('result_json');
            $table->integer('total_question')->default(0);
            $table->decimal('question_percentage', 10, 2)->default(0);
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
        Schema::dropIfExists('courses_results');
    }
}
