<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('contributors')) {
            return;
        }

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
        if (! Schema::hasTable('contributors')) {
            return;
        }

        Schema::drop('contributors');
    }
}
