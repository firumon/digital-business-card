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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->unique();
            $table->unsignedBigInteger('v_card_property_id')->nullable()->index();
            $table->text('value')->nullable();
            $table->text('params')->nullable();
            $table->text('description')->nullable();
            $table->text('example')->nullable();
            $table->timestamps();
        });

        $this->PreFill();
    }

    public $model = \Firumon\DigitalBusinessCard\Models\Property::class;
    public $prefill = "id	name	v_card_property_id	value	params	description	example	created_at	updated_at
1	company_name	22		{}	Name of the company		2025-09-08 15:33:45	2025-09-08 15:33:45
2	job_title	19		{}	Job Title in the Company	Software Engineer	2025-09-08 15:34:24	2025-09-08 15:34:24";
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
        Schema::dropIfExists('property_masters');
    }
};
