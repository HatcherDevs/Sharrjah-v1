<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 'letter',
        'letter_ar',
        'order',
        'order_ar',
        'post_id',**/

        Schema::create('contributors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('letter');
            $table->string('letter_ar');
            $table->tinyInteger('order');
            $table->tinyInteger('order_ar');
            $table->integer('post_id')->unsigned()->index();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contributors');
    }
}
