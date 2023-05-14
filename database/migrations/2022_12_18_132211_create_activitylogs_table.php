<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateActivitylogsTable extends Migration
{
    public function up()
    {
        Schema::create('activitylogs', function (Blueprint $table) {
            $table->id();
            $table->longText('route')->nullable();
            $table->longText('action')->nullable();
            $table->boolean('loggedin');
            $table->longText('username')->nullable();
            $table->longText('comment')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('activitylogs');
    }
}
