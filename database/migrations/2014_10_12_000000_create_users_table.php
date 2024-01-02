<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile_no')->nullable();
			$table->string('address1', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->string('city_town', 150)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->string('country', 30)->nullable();
            $table->date('dob')->nullable();
			$table->enum('gender', ['male', 'female'])->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('parent_email', 255)->nullable();
			$table->enum('is_question_verify', ['0', '1'])->default(1)->comment('0 = not verify, 1 = verify');
            $table->enum('is_role', ['1', '2'])->default(2)->comment('1 = Admin, 2 = Student');
            $table->enum('status', ['0', '1'])->default(1)->comment('0 = Inactive, 1 = Active');
            $table->rememberToken();
            $table->timestamps();
			$table->timestamp('expires_at')->nullable();
			$table->timestamp('question_expires_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
