<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

// feature test
class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // given an anthenticated user
        // Set the currently logged in user for the application
        $user = User::factory()->create();
        $this->be($user);

        // and an existing thread
        $thread = Thread::factory()->create();

        // when the user adds a reply to the thread
        // for testing send json directly to simulate form submit
        $reply = Reply::factory()->make();// make saves data in memory
        $this->post($thread->path() .'/replies', $reply->toArray());

        // then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function unauthenticated_user_may_not_add_replies()
    {
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->make();
        $this->post('/threads/'. $thread->id .'/replies', $reply->toArray());
        $this->get($thread->path())
            ->assertDontSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body')
        ;
    }
}
