<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('products')->insert(
            [
                [
                    'name' => 'Товар 1',
                    'price' => '100'
                ],
                [
                    'name' => 'Товар 2',
                    'price' => '200'
                ],
                [
                    'name' => 'Товар 3',
                    'price' => '300'
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
