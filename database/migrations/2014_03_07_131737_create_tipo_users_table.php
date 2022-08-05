<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipoUsers', function (Blueprint $table) {
            $table->Increments('idTipoUser');
            $table->string('Nome',30)->unique();
            $table->string('Descricao',30)->nullable();
            $table->timestamps();
        });

        DB::table('tipoUsers')->insert([
            [
                'nome' => 'User',
                'descricao'=> 'User',
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
                
            ],

            [
                'nome' => 'Promotor',
                'descricao'=> 'Promotor',
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
                
            ],

            [
                'nome' => 'Admin',
                'descricao'=> 'Admin',
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipoUsers');
    }
}
