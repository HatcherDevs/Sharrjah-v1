<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    //  protected $fillable = ['name','slug','content', 'publish_date'];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->text('content_ar')->nullable();
            $table->date('publish_date')->nullable();
            $table->string('page_type')->default('single');
            $table->longText('additional_content_top')->nullable();
            $table->longText('additional_content_ar_top')->nullable();
            $table->longText('additional_content_bottom')->nullable();
            $table->longText('additional_content_ar_bottom')->nullable();
            $table->longText('additional_content_ar_active')->nullable();
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('pages');
    }
}