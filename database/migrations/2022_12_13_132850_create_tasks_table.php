<?php

use App\Enums\Priorities;
use App\Enums\TaskStatus;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default(TaskStatus::TO_DO->value);
            $table->unsignedSmallInteger('progression')->comment('In %')->default(0);
            $table->string('priority')->comment('Low, medium, high')->default(Priorities::MEDIUM->value);
            $table->unsignedInteger('estimated_duration')->nullable();
            $table->string('estimation_type')->comment('Minuts, hours, days...')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->foreignIdFor(Project::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
