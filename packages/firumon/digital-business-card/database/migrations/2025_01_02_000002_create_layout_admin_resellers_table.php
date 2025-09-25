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
        Schema::create('layout_admin_resellers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layout_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->text('resellers')->nullable();
            $table->timestamps();
        });
//        $this->PreFill();
    }

    public $model = \Firumon\DigitalBusinessCard\Models\LayoutAdminReseller::class;
    public $prefill = '';
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
        Schema::dropIfExists('layout_users');
    }
};
