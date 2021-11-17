<?php

namespace Tests\Unit;

use Tests\TestCase;

class DataTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_data_store()
    {
        $assignment= $this->create_assignment();
        $intern=$this->create_intern();

        $mentor= $this->create_mentor();

        $group= $this->create_group();

        $this->withoutExceptionHandling();
        $this->post("api/groups/data/create",[
            "intern_id"=>$intern["id"],
            "group_id"=>$group["id"],
            "assignment_id"=>$assignment["id"],
            "activated"=>0,
            "mentor_id"=>$mentor["id"]
        ],$this->admin_login())->assertStatus(201);
    }
    public function test_data_store_with_bad_data()
    {
        $this->withoutExceptionHandling();
        $this->post("api/groups/data/create",[
            "intern_id"=>1,
            "group_id"=>1,
            "assignment_id"=>1,
            "activated"=>0,
            "mentor_id"=>1
        ],$this->admin_login())->assertStatus(422);
    }
    public function test_data_update()
    {
        $this->withoutExceptionHandling();
        $this->put("api/groups/data/1",["activated"=>1],$this->admin_login())->assertStatus(200);
    }
    public function test_data_update_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->put("api/groups/data/{id}",["activated"=>1],$this->admin_login())->assertStatus(404);
    }
    public function test_data_delete()
    {
        $this->delete("api/groups/data/1",[],$this->admin_login())->assertStatus(200);
    }
    public function test_data_delete_with_bad_route()
    {
        $this->delete("api/groups/data/{id}",[],$this->admin_login())->assertStatus(404);
    }

    // if logged user is Recruiter

    public function test_if_logged_user_is_recruiter_data_store()
    {
        $assignment= $this->create_assignment();
        $intern=$this->create_intern();
        $mentor= $this->create_mentor();
        $group= $this->create_group();
        $this->withoutExceptionHandling();
        $this->post("api/groups/data/create",[
            "intern_id"=>$intern["id"],
            "group_id"=>$group["id"],
            "assignment_id"=>$assignment["id"],
            "activated"=>0,
            "mentor_id"=>$mentor["id"]
        ],$this->recruiter_login())->assertStatus(201);
    }
    public function test_if_logged_user_is_recruiter_data_store_with_bad_data()
    {
        $this->withoutExceptionHandling();
        $this->post("api/groups/data/create",[
            "intern_id"=>1,
            "group_id"=>1,
            "assignment_id"=>1,
            "activated"=>0,
            "mentor_id"=>1
        ],$this->recruiter_login())->assertStatus(422);
    }
    public function test_if_logged_user_is_recruiter_data_update()
    {
        $this->withoutExceptionHandling();
        $this->put("api/groups/data/2",["activated"=>1],$this->recruiter_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_recruiter_data_update_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->put("api/groups/data/{id}",["activated"=>1],$this->recruiter_login())->assertStatus(404);
    }
    public function test_if_logged_user_is_recruiter_data_delete()
    {
        $this->delete("api/groups/data/2",[],$this->recruiter_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_recruiter_data_delete_with_bad_route()
    {
        $this->delete("api/groups/data/{id}",[],$this->recruiter_login())->assertStatus(404);
    }

    // if logged user is mentor

    public function test_if_logged_user_is_mentor_data_store()
    {
        $assignment= $this->create_assignment();
        $intern=$this->create_intern();
        $mentor= $this->create_mentor();
        $group= $this->create_group();
        $this->withoutExceptionHandling();
        $this->post("api/groups/data/create",[
            "intern_id"=>$intern["id"],
            "group_id"=>$group["id"],
            "assignment_id"=>$assignment["id"],
            "activated"=>0,
            "mentor_id"=>$mentor["id"]
        ],$this->mentor_login())->assertStatus(201);
    }
    public function test_if_logged_user_is_mentor_data_store_with_bad_data()
    {
        $this->withoutExceptionHandling();
        $this->post("api/groups/data/create",[
            "intern_id"=>1,
            "group_id"=>1,
            "assignment_id"=>1,
            "activated"=>0,
            "mentor_id"=>1
        ],$this->mentor_login())->assertStatus(422);
    }
    public function test_if_logged_user_is_mentor_data_update()
    {
        $this->withoutExceptionHandling();
        $this->put("api/groups/data/3",["activated"=>1],$this->mentor_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_mentor_data_update_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->put("api/groups/data/{id}",["activated"=>1],$this->mentor_login())->assertStatus(404);
    }
    public function test_if_logged_user_is_mentor_data_delete()
    {
        $this->delete("api/groups/data/3",[],$this->mentor_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_mentor_data_delete_with_bad_route()
    {
        $this->delete("api/groups/data/{id}",[],$this->mentor_login())->assertStatus(404);
    }
}
