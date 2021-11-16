<?php

namespace Tests\Unit;

use Tests\TestCase;

class AssignmentTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_assignment_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/assignments/create",[
            "title"=>"PHP",
            "description"=>"Learning PHP"
        ],$this->admin_login())->assertStatus(201);
    }
    public function test_assignment_store_with_bad_data()
    {
        $this->post("api/assignments/create",[
        "title"=>123456,
        "description"=>"Learning PHP"
        ],$this->admin_login())->assertStatus(422);
    }
    public function test_assignment_update()
    {
        $this->put("api/assignments/1",[
            "title"=>"Laravel"
        ],$this->admin_login())->assertStatus(200);
    }
    public function test_assignment_update_with_bad_route()
    {
        $this->put("api/assignments/{id}",[
            "title"=>"Laravel"
        ],$this->admin_login())->assertStatus(404);
    }
    public function test_assignment_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/assignments/1",[],$this->admin_login())->assertStatus(200);
    }
    public function test_assignment_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/assignments/{id}",[],$this->admin_login())->assertStatus(404);
    }
    public function test_assignment_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/assignments/list",[],$this->admin_login())->assertStatus(200);

    }
    public function test_assignment_delete()
    {
        $this->delete("api/assignments/1",[],$this->admin_login())->assertStatus(200);
    }
    public function test_assignment_delete_with_bad_route()
    {
        $this->delete("api/assignments/{id}",[],$this->admin_login())->assertStatus(404);
    }


    // if logged user id Recruiter


    public function test_if_logged_user_is_recruiter_assignment_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/assignments/create",[
            "title"=>"PHP",
            "description"=>"Learning PHP"
        ],$this->recruiter_login())->assertStatus(201);
    }
    public function test_if_logged_user_is_recruiter_assignment_store_with_bad_data()
    {
        $this->post("api/assignments/create",[
        "title"=>123456,
        "description"=>"Learning PHP"
        ],$this->recruiter_login())->assertStatus(422);
    }
    public function test_if_logged_user_is_recruiter_assignment_update()
    {
        $this->put("api/assignments/2",[
            "title"=>"Laravel"
        ],$this->recruiter_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_recruiter_assignment_update_with_bad_route()
    {
        $this->put("api/assignments/{id}",[
            "title"=>"Laravel"
        ],$this->recruiter_login())->assertStatus(404);
    }
    public function test_if_logged_user_is_recruiter_assignment_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/assignments/2",[],$this->recruiter_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_recruiter_assignment_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/assignments/{id}",[],$this->recruiter_login())->assertStatus(404);
    }
    public function test_if_logged_user_is_recruiter_assignment_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/assignments/list",[],$this->recruiter_login())->assertStatus(200);

    }
    public function test_if_logged_user_is_recruiter_assignment_delete()
    {
        $this->delete("api/assignments/2",[],$this->recruiter_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_recruiter_assignment_delete_with_bad_route()
    {
        $this->delete("api/assignments/{id}",[],$this->recruiter_login())->assertStatus(404);
    }

    // if logged user is Mentor

    public function test_if_logged_user_is_mentor_assignment_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/assignments/create",[
            "title"=>"PHP",
            "description"=>"Learning PHP"
        ],$this->mentor_login())->assertStatus(201);
    }
    public function test_if_logged_user_is_mentor_assignment_store_with_bad_data()
    {
        $this->post("api/assignments/create",[
        "title"=>123456,
        "description"=>"Learning PHP"
        ],$this->mentor_login())->assertStatus(422);
    }
    public function test_if_logged_user_is_mentor_assignment_update()
    {
        $this->put("api/assignments/3",[
            "title"=>"Laravel"
        ],$this->mentor_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_mentor_assignment_update_with_bad_route()
    {
        $this->put("api/assignments/{id}",[
            "title"=>"Laravel"
        ],$this->mentor_login())->assertStatus(404);
    }
    public function test_if_logged_user_is_mentor_assignment_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/assignments/3",[],$this->mentor_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_mentor_assignment_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/assignments/{id}",[],$this->mentor_login())->assertStatus(404);
    }
    public function test_if_logged_user_is_mentor_assignment_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/assignments/list",[],$this->mentor_login())->assertStatus(200);

    }
    public function test_if_logged_user_is_mentor_assignment_delete()
    {
        $this->delete("api/assignments/3",[],$this->mentor_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_mentor_assignment_delete_with_bad_route()
    {
        $this->delete("api/assignments/{id}",[],$this->mentor_login())->assertStatus(404);
    }
}
