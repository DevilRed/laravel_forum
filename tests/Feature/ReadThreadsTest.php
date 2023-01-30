<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;// to automatically run migrations for test
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();
        $this->thread = Thread::factory()->create();
    }
    /**
     * @test
     */
    public function a_user_can_browse_threads()
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function a_user_can_see_a_specific_thread()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        // given a thread
        // and that thread includes replies
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);

        // when we visit a thread page
        // we should see its replies
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }


    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }


    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $user = create(User::class, ['name' =>'JohnDoe']);
        $this->signIn($user);
        $threadByJohn = create(Thread::class, ['user_id' => auth()->user()->id]);
        $threadNotByJohn = create(Thread::class);

        $this->get('/threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }


    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        // given we have three threads
        // with 2 replies, 3 replies, 0 replies respectively
        $threadTwoReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadTwoReplies->id], 2);

        $threadThreeReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadThreeReplies->id], 3);

        $threadNoReplies = $this->thread;

        // when I filter all threads by popularity
        $response = $this->getJson('threads?popularity=1')->json();

        // then they should be returned from most replies to least
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
