<?php

namespace Tests\Unit;

use Tests\TestCase;

class EvaluationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_evaluation_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/evaluations/create",[
            "title"=>"PHP Nis"
        ],$this->admin_login())->assertStatus(201);
    }
    public function test_evaluation_store_with_bad_data()
    {
        $this->post("api/evaluations/create",[
        "title"=>123456
        ],$this->admin_login())->assertStatus(422);
    }
    public function test_evaluation_update()
    {
        $this->put("api/evaluations/1",[
            "title"=>"Laravel"
        ],$this->admin_login())->assertStatus(200);
    }
    public function test_evaluation_update_with_bad_route()
    {
        $this->put("api/evaluations/{id}",[
            "title"=>"Laravel"
        ],$this->admin_login())->assertStatus(404);
    }
    public function test_evaluation_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/evaluations/1",[],$this->admin_login())->assertStatus(200);
    }
    public function test_evaluation_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/evaluations/{id}",[],$this->admin_login())->assertStatus(404);
    }
    public function test_evaluation_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/evaluations/list",[],$this->admin_login())->assertStatus(200);

    }
    public function test_evaluation_delete()
    {
        $this->delete("api/evaluations/1",[],$this->admin_login())->assertStatus(200);
    }
    public function test_evaluation_delete_with_bad_route()
    {
        $this->delete("api/evaluations/{id}",[],$this->admin_login())->assertStatus(404);
    }

}
