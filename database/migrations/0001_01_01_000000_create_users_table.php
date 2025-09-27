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
        // Access table
        if (!Schema::hasTable('t_access')) {
            Schema::create('t_access', function (Blueprint $table) {
                $table->id();
                $table->string('access_name');
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        // User login table
        if (!Schema::hasTable('t_user_login')) {
            Schema::create('t_user_login', function (Blueprint $table) {
                $table->id();
                $table->string('username')->unique();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->foreignId('access')->nullable()->constrained('t_access')->onDelete('set null');
                $table->tinyInteger('status')->default(1); // 1=active, 0=inactive
                $table->timestamps();
            });
        }

        // Password reset tokens table
        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        // Sessions table for database sessions
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->foreign('user_id')->references('id')->on('t_user_login')->onDelete('cascade');
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();

                // Ensure the table uses InnoDB engine
                $table->engine = 'InnoDB';
                $table->charset = 'utf8mb4';
                $table->collation = 'utf8mb4_unicode_ci';
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('t_user_login');
        Schema::dropIfExists('t_access');
    }
};
