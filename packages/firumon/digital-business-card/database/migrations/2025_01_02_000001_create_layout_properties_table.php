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
        Schema::create('layout_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layout_id')->index();
            $table->string('name')->nullable();
            $table->enum('type',['layout','vcard'])->default('vcard');
            $table->binary('image',1)->default(0);
            $table->binary('mandatory',1)->default(0);
            $table->string('property_name')->nullable()->index();
            $table->text('value')->nullable();
            $table->text('params')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        $this->PreFill();
    }

    public $model = \Firumon\DigitalBusinessCard\Models\LayoutProperty::class;
    public $prefill = 'id	layout_id	name	type	image	mandatory	property_name	value	params	description	created_at	updated_at
1	1	company_name	vcard	0	0	company_name				2025-09-10 07:26:33	2025-09-10 07:26:33
2	1	job_title	vcard	0	1	job_title	Sotfware Developer	{"LANGUAGE":"en_US"}	WOOW	2025-09-10 07:29:31	2025-09-10 07:29:31
3	1	company_name_2	vcard	0	0	company_name		{"TYPE":"ABC","LANGUAGE":"en_GB"}		2025-09-10 07:30:28	2025-09-10 07:30:28';
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
        Schema::dropIfExists('layout_property_masters');
    }
};
