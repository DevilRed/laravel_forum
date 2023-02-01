<?php

namespace Tests\Feature;

use App\Models\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function guests_can_not_favorites_anything()
    {
        $this->post("/replies/1/favorites")
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        // what is going to be the favorite route
        // /replies/id/favorites
        $reply = create(Reply::class);// in reply factory the thread_id is automatically added


        // if I post to a 'favorite' endpoint
        $this->post("replies/{$reply->id}/favorites");

        // it should be recorded in the database
        $this->assertCount(1, $reply->favorites);
    }
}
