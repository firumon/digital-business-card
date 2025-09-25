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
        Schema::create('company_individuals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->index();
            $table->char('code',8)->index()->unique();
            $table->string('name')->nullable();
            $table->text('users')->nullable();
            $table->timestamps();
        });
        $this->PreFill();
    }

    public $model = \Firumon\DigitalBusinessCard\Models\CompanyIndividual::class;
    public $prefill = 'id	company_id	code	name	users	created_at	updated_at
1	1	BRK0001	Firose Hussain		2025-09-18 18:56:48	2025-09-18 18:56:48
2	1	BRK0002	Ghazen Asad Hussain		2025-09-18 18:58:05	2025-09-18 18:58:05
3	1	BRK0003	Hadiya Ziwa Hussain		2025-09-18 18:58:28	2025-09-18 18:58:28
4	1	BKTH0001	Talish Rayn Hussain		2025-09-18 19:03:18	2025-09-18 19:03:18';
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
        Schema::dropIfExists('individuals');
    }
};
