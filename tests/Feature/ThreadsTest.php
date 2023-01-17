<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;// to automatically run migrations for test
use Tests\TestCase;

class ThreadsTest extends TestCase
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
}
