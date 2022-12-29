<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\User;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;// use this instead phpUnit test case
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();
    }
    /**
     * @test
     */
    public function it_has_an_owner()
    {
        $reply = Reply::factory()->create();
        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
