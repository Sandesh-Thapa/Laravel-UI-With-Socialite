<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'name')){
                $table->dropColumn('name');
            }
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->date('dob')->nullable()->after('last_name');
            $table->string('phone')->nullable()->after('dob');
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
            if (!Schema::hasColumn('users', 'name')){
                $table->string('name');
            }
            $table->dropColumn(['first_name',  'last_name', 'dob', 'phone']); 
        });
    }
}
