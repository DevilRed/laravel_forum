<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        // given an authenticated user
        $this->signIn();

        // when we hit the endpoint to create a new thread
        $thread = make(Thread::class);// make return the object in memory

        // send data as array to endpoint
        $this->post('/threads', $thread->toArray());

        // when we visit the thread page
        $this->get($thread->path())
            // we should see the new thread
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function guestMayNotCreateThreads()
    {
        $thread = make(Thread::class);
        $this->post('/threads', $thread->toArray());
        // unauthenticated user will be redirected to the login route
        $this->get($thread->path())
            ->assertSee("login");
    }
}
