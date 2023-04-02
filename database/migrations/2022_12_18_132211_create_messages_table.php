<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('usernamesender')->nullable();
            $table->string('usernamerecipient')->nullable();
            $table->string('title')->nullable();
            $table->string('text')->nullable();
            $table->string('idfile')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
