<?php
/**
 * Created by 迹忆.
 * User: onmpw
 * Home: https://www.onmpw.com
 * Date: 2018/12/10
 * Time: 17:48
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJiyilogApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jiyilog_api', function (Blueprint $table) {
            $table->increments('id');
            $table->string('api_name',100)->default('')->comment('调用接口api名称');
            $table->string('client_ip',50)->nullable()->comment('请求ip');
            $table->string('access_time')->nullable()->comment('访问时间');
            $table->text('access_param')->nullable()->comment('接口请求参数');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('update_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jiyilog_api');
    }
}