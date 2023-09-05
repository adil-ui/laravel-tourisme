<?php

use App\Models\City;
use App\Models\User;
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
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('address',255);
            $table->string('phone',10);
            $table->string('description')->nullable();
            $table->string('email',50)->unique();
            $table->string('link')->nullable();
            $table->string('password',255)->nullable();
            $table->string('picture',255);
            $table->string('longitude',50)->nullable();
            $table->string('latitude',50)->nullable();
            $table->string("role", 30);
            $table->foreignIdFor(City::class)->nullable();
            $table->foreignIdFor(User::class)->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
