<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tweet_id')->nullable();
            $table->boolean('premium')->default(0);
            $table->integer('customer_id')->unsigned();
            $table->integer('status')->default(0);
            $table->integer('opened_by')->unsigned();
            $table->integer('assigned_to')->unsigned();
            $table->integer('urgency')->default(0);
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
            $table->foreign('opened_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('assigned_to')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')->nullable();
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
        Schema::drop('tickets');
    }
}
