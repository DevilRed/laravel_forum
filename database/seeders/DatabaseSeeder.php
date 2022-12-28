<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $threads = \App\Models\Thread::factory()->count(50)->create();
        $threads->each(
            function($thread){
                \App\Models\Reply::factory()->count(10)->create(['thread_id' => $thread->id]);
            });


    }
}
