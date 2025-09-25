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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->char('code',4)->index()->unique();
            $table->string('name')->index();
            $table->string('base_url')->nullable();
            $table->text('logo_url')->nullable();
            $table->string('logo_width')->nullable();
            $table->string('logo_height')->nullable();
            $table->text('brand_primary')->nullable();
            $table->text('brand_secondary')->nullable();
            $table->text('color_primary')->nullable();
            $table->text('color_secondary')->nullable();
            $table->text('font_primary')->nullable();
            $table->text('font_secondary')->nullable();
            $table->unsignedBigInteger('layout_id')->index();
            $table->unsignedBigInteger('created_by')->index();
            $table->text('users')->nullable();
            $table->timestamps();
        });
        $this->PreFill();
    }

    public $model = \Firumon\DigitalBusinessCard\Models\Company::class;
    public $prefill = 'id	code	name	base_url	logo_url	logo_width	logo_height	brand_primary	brand_secondary	color_primary	color_secondary	font_primary	font_secondary	layout_id	created_by	users	created_at	updated_at
1	BKTH	Barakat	https://dbc.xnture.com	https://i.postimg.cc/BbLsfhDV/barakat.png	175	80							1	2		2025-09-14 23:55:25	2025-09-18 19:21:25';
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
        Schema::dropIfExists('companies');
    }
};
