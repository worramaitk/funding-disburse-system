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
            $table->string('route')->nullable();
            $table->string('action')->nullable();
            $table->boolean('loggedin');
            $table->string('username')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('activitylogs');
    }
}
