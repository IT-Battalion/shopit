<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('name');
            $table->string('employeeType');
            $table->string('class')->nullable();
            $table->string('lang')->default('de-AT');
            $table->boolean('isAdmin')->default(false);
            $table->boolean('enabled')->default(true);
            $table->string('reason_for_disabling')->nullable();
            $table->timestamp('disabled_at')->nullable();
            $table->foreignId('disabled_by_id')->nullable()->constrained('users');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
