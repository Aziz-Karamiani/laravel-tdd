<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\CheckUserIsActiveMiddleware;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CheckActiveUserMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User is active.
     *
     * @return void
     */
    public function test_user_is_active_middleware()
    {
        $user = User::factory()->user()->create();
        $this->actingAs($user);

        $request = Request::create('/', 'GET');

        $middleware = new CheckUserIsActiveMiddleware();
        $middleware->handle($request, function(){});

        $this->assertEquals('online', Cache::get("user-{$user->id}-status"));
    }
}
