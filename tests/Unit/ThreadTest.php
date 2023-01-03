<?php
namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Thread;

class ThreadTest extends \Tests\TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_thread_has_replies()
    {
        $thread = Thread::factory()->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $thread = Thread::factory()->create();
        // $thread->creator = new User();
        $this->assertInstanceOf(User::class, $thread->creator);
    }
}
