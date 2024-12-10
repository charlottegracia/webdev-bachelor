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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id('incident_id');
            $table->string('title');
            $table->text('message');
            $table->integer('critical')->nullable();
            $table->string('country');
            $table->string('type');
            $table->enum('status', ['active', 'expired']);
            $table->timestamp('expected_resolved_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('failure_logs', function (Blueprint $table) {
            $table->id('failure_log_id');
            $table->unsignedBigInteger('loggable_id'); // ID for den relaterede model
            $table->string('loggable_type'); // Type af model (Service eller Carrier)
            $table->string('uuid')->unique();
            $table->string('connection');
            $table->text('reason');
            $table->timestamp('failed_at');
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id('service_id');
            $table->string('title');
            $table->string('type');
            $table->enum('status', ['green', 'yellow', 'red'])->default('green');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('carriers', function (Blueprint $table) {
            $table->id('carrier_id');
            $table->text('slug');
            $table->text('title');
            $table->string('type');
            $table->text('description')->nullable();
            $table->enum('status', ['green', 'yellow', 'red'])->default('green');
            $table->text('peak_up_charge')->nullable();
            $table->timestamps();
        });

        Schema::create('incident_carriers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')->constrained('incidents', 'incident_id')->cascadeOnDelete();
            $table->foreignId('carrier_id')->constrained('carriers', 'carrier_id')->cascadeOnDelete();
        });

        Schema::create('incident_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_id')->constrained('incidents', 'incident_id')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services', 'service_id')->cascadeOnDelete();
        });

        Schema::create('carrier_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrier_id')->constrained('carriers', 'carrier_id')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services', 'service_id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrier_services');
        Schema::dropIfExists('incident_services');
        Schema::dropIfExists('incident_carriers');
        Schema::dropIfExists('carriers');
        Schema::dropIfExists('services');
        Schema::dropIfExists('failure_logs');
        Schema::dropIfExists('incidents');
    }
};
