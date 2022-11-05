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
     * Authenticated User is active.
     *
     * @return void
     */
    public function test_user_is_active_middleware()
    {
        $user = User::factory()->user()->create();
        $this->actingAs($user);

        $request = Request::create('/', 'GET');

        $middleware = new CheckUserIsActiveMiddleware();
        $response = $middleware->handle($request, function(){});
        $this->assertNull($response);

        $this->assertEquals('online', Cache::get("user-{$user->id}-status"));
    }

    /**
     * Unauthenticated User is  not active.
     *
     * @return void
     */
    public function test_unauthenticated_user_is_active_middleware()
    {
        $request = Request::create('/', 'GET');

        $middleware = new CheckUserIsActiveMiddleware();
        $response = $middleware->handle($request, function(){});

        $this->assertNull($response);
    }

    /**
     * Active user middleware check
     */
    public function test_check_active_status_middleware_apply_to_all_route()
    {
        $this->get('/');
        $this->assertEquals(['web'], request()->route()->middleware());
    }
}
