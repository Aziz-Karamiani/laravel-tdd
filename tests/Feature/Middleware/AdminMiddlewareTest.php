<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\CheckIsAdminMiddleware;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A normal user can not access to admin routes.
     *
     * @return void
     */
    public function test_when_authenticated_user_not_admin()
    {
        $user = User::factory()->user()->create();
        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $middleware = new CheckIsAdminMiddleware();
        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * A admin user can access to admin routes.
     *
     * @return void
     */
    public function test_when_authenticated_user_is_admin()
    {
        $user = User::factory()->admin()->create();
        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $middleware = new CheckIsAdminMiddleware();
        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals(null, $response);
    }

    /**
     * A none authenticated user can not access to admin routes.
     *
     * @return void
     */
    public function test_unauthenticated_user_call_admin_routes()
    {
        $request = Request::create('/admin', 'GET');

        $middleware = new CheckIsAdminMiddleware();
        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals(302, $response->getStatusCode());
    }
}
