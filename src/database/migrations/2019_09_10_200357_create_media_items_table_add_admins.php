<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaItemsTableAddAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('submitted_users_name')->nullable(); //keeping an actual field so that way it can be edited via the back end if need be
            $table->string('phone_number')->nullable();
            $table->string('original_creator')->nullable();
            $table->boolean('own_rights')->nullable();
            $table->longText('credit')->nullable();
            $table->string('copyright')->default(true);
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('original_date')->nullable();
            $table->string('original_location')->nullable();
            $table->boolean('authorization')->default(false);
            $table->string('status')->nullable();
            $table->string('reviewed_by')->nullable();
            $table->dateTime('reviewed_at')->nullable();
            $table->longText('comment')->nullable();
            $table->string('user_session_id');
            $table->string('user_email')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });

        Schema::dropIfExists('media_items');
    }
}