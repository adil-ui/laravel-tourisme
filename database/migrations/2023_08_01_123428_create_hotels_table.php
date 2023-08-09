<?php

use App\Models\City;
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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('address',255);
            $table->string('phone',10);
            $table->string('description');
            $table->double('price')->nullable();
            $table->double('star');
            $table->string('link')->nullable();
            $table->string('email',50)->unique();
            $table->string('password',255);
            $table->string('picture',255);
            $table->enum("status", ["Bloquer", "Débloquer"]);
            $table->foreignIdFor(City::class);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
