<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wiki_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wiki_header_id');
            $table->string('slug');
            $table->string('judul');
            $table->text('isi');
            $table->timestamps();

            $table->foreign('wiki_header_id')
                ->references('id')
                ->on('wiki_headers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wiki_contents');
    }
};
