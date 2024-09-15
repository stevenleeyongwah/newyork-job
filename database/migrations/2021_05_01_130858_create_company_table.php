<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('phonecode', 20)->nullable();
            $table->string('contact_number', 50)->nullable();
            $table->string('contact_email')->nullable();
            $table->string('headline')->nullable();
            $table->string('website')->nullable();
            $table->string('size')->nullable();
            $table->string('type')->nullable();
            $table->date('founded')->nullable();
            $table->string('specialties')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->boolean('verified')->default(false);
            $table->text('overview')->nullable();
            $table->integer('job_post_credit')->unsigned()->default(0);
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

    }
}
