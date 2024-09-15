<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('company')->nullable();
            $table->string('location')->nullable();
            $table->string('job_type')->nullable();
            $table->string('remote_work')->nullable();
            $table->string('position')->nullable();
            $table->integer('experience')->unsigned()->nullable();
            $table->string('qualification')->nullable();
            $table->string('salary_currency')->nullable();
            $table->integer('salary_min')->unsigned()->nullable();
            $table->integer('salary_max')->unsigned()->nullable();
            $table->string('salary_rate')->nullable();
            $table->boolean('hide_salary')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('posted_at')->nullable();
            $table->dateTime('expiry_at')->nullable();
            $table->string('status')->nullable();
            $table->boolean('whatsapp_apply')->nullable();
            $table->string('employer_phonecode', 30)->nullable();
            $table->string('employer_contact', 50)->nullable();
            $table->boolean('email_apply')->nullable();
            $table->string('employer_email', 255)->nullable();
            $table->boolean('website_apply')->nullable();
            $table->string('job_website', 255)->nullable();
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
        Schema::dropIfExists('job_post');
    }
}
