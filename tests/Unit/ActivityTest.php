<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    // test activity is recorded when a thread is created
    public function it_recods_activity_when_a_thread_is_created()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Models\Thread'
        ]);
    }
}
