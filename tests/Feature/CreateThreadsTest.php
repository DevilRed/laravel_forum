<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
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

    /** @test */
    public function a_thread_requires_a_body()
    {
        // to refactor test, breaking them down to what you are trying to do
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        // using channel factory just to make sure inexistent channel rule is working
        Channel::factory()->count(2)->create();
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
    }


    /** @test */
    public function authorized_users_delete_threads()
    {
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);
    }


    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $thread = create(Thread::class);
        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(401);
        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }
}
