<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });
        
        // Заполняем таблицу ролями
        DB::table('roles')->insert([
            ['name' => 'reader', 'description' => 'Читатель - может просматривать новости и добавлять комментарии'],
            ['name' => 'moderator', 'description' => 'Модератор - может выполнять все действия'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};