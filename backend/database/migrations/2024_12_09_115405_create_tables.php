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
        Schema::create('incident', function (Blueprint $table) {
            $table->id('incident_id');
            $table->string('title');
            $table->text('message');
            $table->integer('critical')->nullable();
            $table->string('country');
            $table->string('type');
            $table->enum('status', ['active', 'expired']);
            $table->timestamp('expected_resolved_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at');
        });

        Schema::create('failure_log', function (Blueprint $table) {
            $table->id('failure_log_id');
            $table->unsignedBigInteger('loggable_id'); // ID for den relaterede model
            $table->string('loggable_type'); // Type af model (Service eller Carrier)
            $table->string('uuid')->unique();
            $table->string('connection');
            $table->text('reason');
            $table->timestamp('failed_at');
        });

        Schema::create('service', function (Blueprint $table) {
            $table->id('service_id');
            $table->string('title');
            $table->string('type');
            $table->enum('status', ['green', 'yellow', 'red'])->default('green');
            $table->text('description')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at');
        });

        Schema::create('carrier', function (Blueprint $table) {
            $table->id('carrier_id');
            $table->text('slug');
            $table->text('title');
            $table->string('type');
            $table->text('description')->nullable();
            $table->enum('status', ['green', 'yellow', 'red'])->default('green');
            $table->text('peak_up_charge')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at');
        });

        Schema::create('incident_carrier', function (Blueprint $table) {
            $table->foreignId('incident_id')->constrained('incident');
            $table->foreignId('carrier_id')->constrained('carrier');
        });

        Schema::create('incident_service', function (Blueprint $table) {
            $table->foreignId('incident_id')->constrained('incident');
            $table->foreignId('service_id')->constrained('service');
        });

        Schema::create('carrier_service', function (Blueprint $table) {
            $table->foreignId('carrier_id')->constrained('carrier');
            $table->foreignId('service_id')->constrained('service');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrier_service');
        Schema::dropIfExists('incident_service');
        Schema::dropIfExists('incident_carrier');
        Schema::dropIfExists('carrier');
        Schema::dropIfExists('service');
        Schema::dropIfExists('failure_log');
        Schema::dropIfExists('incident');
    }
};
