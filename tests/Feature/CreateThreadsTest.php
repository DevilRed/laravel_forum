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
        $response = $this->post('/threads', $thread->toArray());


        // when we visit the thread page
        $this->get($response->headers->get('Location'))
            // we should see the new thread
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function guestMayNotCreateThreads()
    {
        $thread = create(Thread::class);
        // dd($thread->path());
        $this->post($thread->path(), $thread->toArray());
        // unauthenticated user will be redirected to the login route
        $this->get($thread->path())
            ->assertSee("login");
    }

    /** @test */
    public function guest_cannot_see_the_create_thread_page()
    {
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        // to refactor test, breaking them down to what you are trying to do
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function publishThread($overrides = []) {
        $this->signIn();
        $thread = make(Thread::class, $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
