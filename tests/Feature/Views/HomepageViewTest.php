<?php

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home_page_admin_user()
    {
        $user = User::factory()->state(['type' => 'admin'])->create();
        $this->actingAs($user);

        $view = $this->view('home');
        $view->assertSee('<a href="/admin/dashboard" class="btn btn-primary">Admin Dashboard</a>', false);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home_page_normal_user()
    {
        $user = User::factory()->state(['type' => 'user'])->create();
        $this->actingAs($user);

        $view = $this->view('home');
        $view->assertDontSee('<a href="/admin/dashboard" class="btn btn-primary">Admin Dashboard</a>', false);
    }
}
