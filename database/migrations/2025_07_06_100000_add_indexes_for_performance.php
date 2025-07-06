<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Add indexes for frequently queried columns
            $table->index(['status', 'created_at'], 'tasks_status_created_at_index');
            $table->index(['user_id', 'status'], 'tasks_user_status_index');
            $table->index(['due_date', 'status'], 'tasks_due_date_status_index');
            $table->index(['priority', 'status'], 'tasks_priority_status_index');
            $table->index('created_at', 'tasks_created_at_index');
            
            // Full-text index for search functionality
            $table->fullText(['title', 'description'], 'tasks_search_index');
        });

        Schema::table('users', function (Blueprint $table) {
            // Add indexes for user queries
            $table->index('role', 'users_role_index');
            $table->index('last_activity', 'users_last_activity_index');
            $table->index('created_at', 'users_created_at_index');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex('tasks_status_created_at_index');
            $table->dropIndex('tasks_user_status_index');
            $table->dropIndex('tasks_due_date_status_index');
            $table->dropIndex('tasks_priority_status_index');
            $table->dropIndex('tasks_created_at_index');
            $table->dropIndex('tasks_search_index');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_index');
            $table->dropIndex('users_last_activity_index');
            $table->dropIndex('users_created_at_index');
        });
    }
};
