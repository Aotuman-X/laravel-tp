<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //建表
        Schema::create('profession',function($table){
            $table -> increments('id');
            $table -> string('pro_name',20) -> notNull();
            $table -> tinyInteger('protype_id') -> notNull();
            $table -> string('teachers_ids') -> notNull();
            $table -> string('description');
            $table -> string('cover_img');
            $table -> integer('view_count') -> notNull() -> default('500');
            $table -> timestamps();
            $table -> tinyinteger('sort') -> notNull() -> default('0');
            $table -> tinyinteger('duration');
            $table -> decimal('price',7,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删表
        Schema::dropIfExists('profession');
    }
}
