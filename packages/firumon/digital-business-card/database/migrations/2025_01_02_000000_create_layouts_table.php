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
        Schema::create('layouts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->unique();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('font_primary')->nullable();
            $table->string('font_secondary')->nullable();
            $table->text('admins')->nullable();
            $table->timestamps();
        });
        $this->PreFill();
    }
    public $model = \Firumon\DigitalBusinessCard\Models\Layout::class;
    public $prefill = "id	name	image	description	font_primary	font_secondary	created_at	updated_at
1	GraceCard	https://i.postimg.cc/SsSBMyCX/image-2025-09-08-132839116.png		Poppins	Great Vibes	2025-09-08 17:36:26	2025-09-08 21:54:48";
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
        Schema::dropIfExists('layout_masters');
    }
};
