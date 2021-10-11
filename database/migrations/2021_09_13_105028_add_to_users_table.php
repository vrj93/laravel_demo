<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->date('birthday')->after('password');
            // $table->enum('gender', ['Male', 'Female'])->after('birthday');
            // $table->integer('phone')->after('gender');
            // $table->enum('is_admin', ['1', '0'])->after('phone');
            $table->string('profile_pic')->after('phone');
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
            //
        });
    }
}
