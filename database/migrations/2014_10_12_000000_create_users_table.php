<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->String('name')->comment('姓名');
            $table->integer('sex')->comment('1为男，2为女');
            $table->String('college')->nullable()->comment('学院');
            $table->String('major_grade')->nullable()->comment('专业班级');
            $table->String('student_number')->comment('学号');
            $table->String('wx_id')->default('')->comment('微信ID');
            $table->String('wx_nickname')->default('')->comment('微信昵称');
            $table->String('wx_name')->default('')->comment('微信号');
            $table->String('wx_emial')->default('')->comment('微信邮箱');
            $table->string('wx_avatar')->default('')->comment('微信头像');
            $table->integer('jwc_id')->nullable()->comment('教务处id');
            $table->String('jwc_password')->nullable()->comment('教务处密码');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
