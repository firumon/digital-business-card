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
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role',['Administrator','Developer','Reseller','Manager','Individual']);
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
        });

        $this->addDeveloper();
        $this->PreFill();
    }

    public function addDeveloper(): void {
        \Firumon\DigitalBusinessCard\Models\User::create(['name' => 'Firose Hussain','role' => 'Developer','email' => 'me@firumon.com', 'password' => 123456]);
    }
    public $model = \Firumon\DigitalBusinessCard\Models\User::class;
    public $prefill = 'id	name	email	password	role	created_by	created_at	updated_at
2	Nishad Manayat	nishad@xnture.com	$2y$12$MmP6xYiTA6fcz96f54WHGuX4QnYiVqo/18me48mprLRdh2H.LqhPS	Administrator		2025-09-11 08:49:01	2025-09-14 07:43:15
3	Mujeeb Rahman	muju@xnture.com	$2y$12$UVfNdYf./t.dTN96bEuol.QLve1uOzvdVQqezcF4T7be0.40Li4Q6	Reseller	2	2025-09-13 11:51:10	2025-09-13 11:51:45
4	Firose	admin@firumon.com	$2y$12$J6PBc1/LR.EvsCwBLU4oxeBsObOvfym5aNHxzHFb0aeygUzHcKcU2	Administrator		2025-09-13 23:50:09	2025-09-13 23:50:09
5	Suhu	suhu@xnture.com	$2y$12$UVfNdYf./t.dTN96bEuol.QLve1uOzvdVQqezcF4T7be0.40Li4Q6	Manager	3	2025-09-13 11:51:10	2025-09-13 11:51:45
6	Ali	ali@xnture.com	$2y$12$gLwHZiCr7FlrJyIk5nwa7ut/0JMb8fCRBPBSKS6FdT69LgHPlOyPG	Administrator	1	2025-09-14 07:43:47	2025-09-14 07:43:47
7	Farish Tahani	fari@xnture.com	$2y$12$tXPfIWaFMHLyY7ZLUr8Hluyip5ma0IeVHsGi1JCIjSARXruHHHHH2	Reseller	2	2025-09-14 07:44:35	2025-09-14 07:45:10
8	Ali CM	cm@xnture.com	$2y$12$tXPfIWaFMHLyY7ZLUr8Hluyip5ma0IeVHsGi1JCIjSARXruHHHHH2	Reseller	6	2025-09-14 07:44:35	2025-09-14 07:45:10';
    public function PreFill(){
        $Head = array_map("trim",explode("\t",trim(explode("\n",$this->prefill)[0])));
        $Records = array_map(fn($line) => array_combine($Head,array_map(fn($value) => trim($value) === "" ? null : trim($value),explode("\t",trim($line)))),array_slice(explode("\n",$this->prefill),1));
        (new $this->model)::insert($Records);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }
};
