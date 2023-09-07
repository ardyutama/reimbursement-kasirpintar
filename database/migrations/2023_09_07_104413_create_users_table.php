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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('NIP')->unique();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('password');
            $table->timestamps();
        });

        // Insert the provided data
        DB::table('users')->insert([
            ['NIP' => '1234', 'nama' => 'DONI', 'jabatan' => 'DIREKTUR', 'password' => bcrypt('123456')],
            ['NIP' => '1235', 'nama' => 'DONO', 'jabatan' => 'FINANCE', 'password' => bcrypt('123456')],
            ['NIP' => '1236', 'nama' => 'DONA', 'jabatan' => 'STAFF', 'password' => bcrypt('123456')],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
