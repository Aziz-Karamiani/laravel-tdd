<?php

namespace Tests\Feature\Models;

use Illuminate\Database\Eloquent\Model;

trait ModelHelper
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_insert_post()
    {
        $model = $this->model();
        $table = $model->getTable();

        $post = $model::factory()->create();

        $this->assertDatabaseHas($table, $post->toArray());
    }

    abstract protected function model(): Model;
}
