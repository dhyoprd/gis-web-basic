<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('polygons', function (Blueprint $table) {
            if (!Schema::hasColumn('polygons', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('polygons', 'coordinates')) {
                $table->text('coordinates')->after('name');
            }
        });
    }

    public function down()
    {
        Schema::table('polygons', function (Blueprint $table) {
            $table->dropColumn(['name', 'coordinates']);
        });
    }
}; 