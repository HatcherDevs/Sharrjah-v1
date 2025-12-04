<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            // ['EMAIL','FNAME','LNAME','MMERGE5','MMERGE6'];
            $table->increments('id');
            $table->string('EMAIL');
            $table->string('FNAME');
            $table->string('LNAME');
            $table->string('MMERGE5');
            $table->string('MMERGE6');
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
        Schema::drop('subscribers');
    }
}
