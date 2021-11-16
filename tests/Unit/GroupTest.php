<?php

namespace Tests\Unit;

use Tests\TestCase;

class GroupTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_group_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/groups/create",[
            "title"=>"PHP Nis"
        ],$this->admin_login())->assertStatus(201);
    }
    public function test_group_store_with_bad_data()
    {
        $this->post("api/groups/create",[
        "title"=>123456
        ],$this->admin_login())->assertStatus(422);
    }
    public function test_group_update()
    {
        $this->put("api/groups/1",[
            "title"=>"Laravel"
        ],$this->admin_login())->assertStatus(200);
    }
    public function test_group_update_with_bad_route()
    {
        $this->put("api/groups/{id}",[
            "title"=>"Laravel"
        ],$this->admin_login())->assertStatus(404);
    }
    public function test_group_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/groups/1",[],$this->admin_login())->assertStatus(200);
    }
    public function test_group_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/groups/{id}",[],$this->admin_login())->assertStatus(404);
    }
    public function test_group_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/groups/list",[],$this->admin_login())->assertStatus(200);

    }
    public function test_group_delete()
    {
        $this->delete("api/groups/1",[],$this->admin_login())->assertStatus(200);
    }
    public function test_group_delete_with_bad_route()
    {
        $this->delete("api/groups/{id}",[],$this->admin_login())->assertStatus(404);
    }


    // if logged user id Recruiter


    public function test_if_logged_user_is_recruiter_group_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/groups/create",[
            "title"=>"PHP"
        ],$this->recruiter_login())->assertStatus(201);
    }
    public function test_if_logged_user_is_recruiter_group_store_with_bad_data()
    {
        $this->post("api/groups/create",[
        "title"=>123456
        ],$this->recruiter_login())->assertStatus(422);
    }
    public function test_if_logged_user_is_recruiter_group_update()
    {
        $this->put("api/groups/2",[
            "title"=>"Laravel"
        ],$this->recruiter_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_recruiter_group_update_with_bad_route()
    {
        $this->put("api/groups/{id}",[
            "title"=>"Laravel"
        ],$this->recruiter_login())->assertStatus(404);
    }
    public function test_if_logged_user_is_recruiter_group_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/groups/2",[],$this->recruiter_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_recruiter_group_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/groups/{id}",[],$this->recruiter_login())->assertStatus(404);
    }
    public function test_if_logged_user_is_recruiter_group_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/groups/list",[],$this->recruiter_login())->assertStatus(200);

    }
    public function test_if_logged_user_is_recruiter_group_delete()
    {
        $this->delete("api/groups/2",[],$this->recruiter_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_recruiter_group_delete_with_bad_route()
    {
        $this->delete("api/groups/{id}",[],$this->recruiter_login())->assertStatus(404);
    }

    // if logged user is Mentor

    public function test_if_logged_user_is_mentor_group_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/groups/create",[
            "title"=>"PHP"
        ],$this->mentor_login())->assertStatus(201);
    }
    public function test_if_logged_user_is_mentor_group_store_with_bad_data()
    {
        $this->post("api/groups/create",[
        "title"=>123456
        ],$this->mentor_login())->assertStatus(422);
    }
    public function test_if_logged_user_is_mentor_group_update()
    {
        $this->put("api/groups/3",[
            "title"=>"Laravel"
        ],$this->mentor_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_mentor_group_update_with_bad_route()
    {
        $this->put("api/groups/{id}",[
            "title"=>"Laravel"
        ],$this->mentor_login())->assertStatus(404);
    }
    public function test_if_logged_user_is_mentor_group_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/groups/3",[],$this->mentor_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_mentor_group_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/groups/{id}",[],$this->mentor_login())->assertStatus(404);
    }
    public function test_if_logged_user_is_mentor_group_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/groups/list",[],$this->mentor_login())->assertStatus(200);

    }
    public function test_if_logged_user_is_mentor_group_delete()
    {
        $this->delete("api/groups/3",[],$this->mentor_login())->assertStatus(200);
    }
    public function test_if_logged_user_is_mentor_group_delete_with_bad_route()
    {
        $this->delete("api/groups/{id}",[],$this->mentor_login())->assertStatus(404);
    }
}
