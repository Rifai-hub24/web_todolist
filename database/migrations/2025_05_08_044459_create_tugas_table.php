<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasTable extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('tugas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->enum('priority', ['low', 'medium', 'high']);
        $table->date('due_date');
        $table->boolean('is_done')->default(false);
        $table->timestamps();
    });
}


}
