<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('book_user', function (Blueprint $table) {
            $table->date('ngaymuon')->change();
            $table->date('ngaytra')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // To revert the changes, you may need to specify the original data type
        Schema::table('book_user', function (Blueprint $table) {
            $table->string('ngaymuon')->change();
            $table->string('ngaytra')->change();
        });
    }
};