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
        Schema::create('individual_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_individual_id')->index();
            $table->string('property_name')->nullable()->index();
            $table->text('value')->nullable();
            $table->timestamps();
        });
        $this->PreFill();
    }

    public $model = \Firumon\DigitalBusinessCard\Models\IndividualProperty::class;
    public $prefill = 'id	company_individual_id	property_name	value	created_at	updated_at
9	1	company_name_2	Okk	2025-09-19 10:09:00	2025-09-19 10:10:08';
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
        Schema::dropIfExists('attrs');
    }
};
