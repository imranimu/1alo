<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddonAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addon_amounts', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('short_title',255)->nullable();
            $table->decimal('amount', 8, 2);
            $table->integer('sort')->default(0);
            $table->enum('is_type', ['1', '2'])->default(1)->comment('1 = Addons, 1 = Certificate');
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
        Schema::dropIfExists('addon_amounts');
    }
}
