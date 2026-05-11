<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Core\Models\Invite\InviteStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invites', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('legal_id');
            $table->foreign('legal_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('phys_id');
            $table->foreign('phys_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedTinyInteger('for');
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
        });

        DB::statement('
            CREATE UNIQUE INDEX unique_active_combination
            ON invites (legal_id, phys_id, status)
            WHERE status != ' . InviteStatus::COMPLETE->value
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invites');
    }
};
