<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
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

        // ensure data consistency
        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }


    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();
        $reply = create(Reply::class);
        $this->assertEquals(2, Activity::count());
    }


    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        // given we have a thread
        $this->signIn();
        create(Thread::class, ['user_id' => auth()->id()], 2);
        // modify 'created_at' of first Activity item to simulate it was created a week ago
        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        // when we fetch their feed
        $feed = Activity::feed(auth()->user(), 50);

        // then it should be returned in the proper format, from newest to oldest
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
