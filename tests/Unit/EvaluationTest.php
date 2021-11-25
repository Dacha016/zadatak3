<?php

namespace Tests\Unit;

use App\Models\GroupData;
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
        $this->create_group_data();
        $data=GroupData::first()->toArray();
        $this->post("api/evaluations/create",[
            "intern_id"=>$data["intern_id"],
            "assignment_id"=>$data["assignment_id"],
            "pro"=>"Some text",
            "con"=>"Some another text",
            "evaluation_day"=>"2021-11-16",
            "mentor_id"=>$data["mentor_id"]
        ],$this->admin_login())->assertStatus(403);

    }
    public function test_evaluation_store_with_bad_data()
    {
        $this->post("api/evaluations/create",[
            "intern_id"=>10,
            "assignment_id"=>1,
            "pro"=>"Some text",
            "con"=>"Some another text",
            "evaluation_day"=>"2021-11-16",
            "mentor_id"=>1
        ],$this->admin_login())->assertStatus(403);
    }
    public function test_evaluation_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/evaluations/interns/1")->assertStatus(404);
    }
    public function test_evaluation_delete_with_bad_route()
    {
        $this->delete("api/evaluations/{id}",[],$this->admin_login())->assertStatus(404);
    }
    // if logged user is Recruiter

    public function test_if_logged_user_is_recruiter_evaluation_store()
    {
        $this->withoutExceptionHandling();
        $this->create_group_data();
        $data=GroupData::first()->toArray();
        $this->post("api/evaluations/create",[
            "intern_id"=>$data["intern_id"],
            "assignment_id"=>$data["assignment_id"],
            "pro"=>"Some text",
            "con"=>"Some another text",
            "evaluation_day"=>"2021-11-16",
            "mentor_id"=>$data["mentor_id"]
        ],$this->recruiter_login())->assertStatus(403);
    }
    public function test_if_logged_user_is_recruiter_evaluation_store_with_bad_data()
    {
        $this->post("api/evaluations/create",[
            "intern_id"=>15,
            "assignment_id"=>1,
            "pro"=>"Some text",
            "con"=>"Some another text",
            "evaluation_day"=>"2021-11-16",
            "mentor_id"=>1
        ],$this->recruiter_login())->assertStatus(403);
    }
    public function test_if_logged_user_is_recruiter_evaluation_delete()
    {
        $this->delete("api/evaluations/2",[],$this->recruiter_login())->assertStatus(403);
    }
    public function test_if_logged_user_is_recruiter_evaluation_delete_with_bad_route()
    {
        $this->delete("api/evaluations/{id}",[],$this->recruiter_login())->assertStatus(403);
    }

    // if logged user id mentor
    public function test_if_logged_user_is_mentor_evaluation_store()
    {
        $data=$this->create_group_data();


        $this->post("api/evaluations/create",[
            "intern_id"=>$data["intern_id"],
            "assignment_id"=>$data["assignment_id"],
            "pro"=>"Some text",
            "con"=>"Some another text",
            "evaluation_day"=>"2021-11-16",
            "mentor_id"=>$data["mentor_id"]
        ],$this->mentor_login())->assertStatus(201);
    }
    public function test_if_logged_user_is_mentor_evaluation_store_with_bad_data()
    {
        $this->post("api/evaluations/create",[
            "intern_id"=>25,
            "assignment_id"=>1,
            "pro"=>"Some text",
            "con"=>"Some another text",
            "evaluation_day"=>"2021-11-16",
            "mentor_id"=>1
        ],$this->mentor_login())->assertStatus(422);
    }
    public function test_if_logged_user_is_mentor_evaluation_delete()
    {
        $this->delete("api/evaluations/3",[],$this->mentor_login())->assertStatus(403);
    }
    public function test_if_logged_user_is_mentor_evaluation_delete_with_bad_route()
    {
        $this->delete("api/evaluations/{id}",[],$this->mentor_login())->assertStatus(403);
    }
    public function test_evaluation_delete()
    {
        $this->delete("api/evaluations/1",[],$this->admin_login())->assertStatus(200);
    }
    public function test_evaluation_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/evaluations/interns/{id}")->assertStatus(404);
    }
    public function test_evaluation_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/evaluations/list")->assertStatus(200);
    }
}
