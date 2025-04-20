<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAddColumnsRecipientstable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('recipients', function (Blueprint $table) {
	        $table->dropColumn(['doc_id', 'place_holder']);
	    });

	    Schema::table('recipients', function (Blueprint $table) {
	        $table->integer('request_id');
	        $table->string('order_queue');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('recipients', function(Blueprint $table)
		{
			
		});
	}

}
