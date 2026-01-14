<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeNilaiVisibleDefaultToFalse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Change default value to false (hidden by default) using raw SQL
        DB::statement('ALTER TABLE ujians ALTER COLUMN nilai_visible SET DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE ujians ALTER COLUMN nilai_visible SET DEFAULT 1');
    }
}
