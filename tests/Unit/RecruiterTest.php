<?php

namespace Tests\Unit;

use Tests\TestCase;

class RecruiterTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_recruiter_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/recruiters/create",[
            "name"=>"Petar",
            "surname"=>"Petrovic",
            "email"=>"petar@gmail.com",
            "password"=>"123456"
        ],$this->admin_login())->assertStatus(201);
    }
    public function test_recruiter_store_with_bad_data()
    {
        $this->post("api/recruiters/create",["name"=>"Petar1",
        "surname"=>"Petrovic",
        "email"=>"pera@gmail.com",
        "password"=>"123456"],$this->admin_login())->assertStatus(422);
    }
    public function test_recruiter_update()
    {
        $this->put("api/recruiters/2",[
            "email"=>"pera@gmail.com"
        ],$this->admin_login())->assertStatus(200);
    }
    public function test_recruiter_update_with_bad_route()
    {
        $this->put("api/recruiters/{id}",[
            "email"=>"pera@gmail.com"
        ],$this->admin_login())->assertStatus(404);
    }
    public function test_recruiter_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/recruiters/1",[],$this->admin_login())->assertStatus(200);
    }
    public function test_recruiter_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/recruiters/{id}",[],$this->admin_login())->assertStatus(404);
    }
    public function test_recruiter_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/recruiters/list",[],$this->admin_login())->assertStatus(200);

    }
    public function test_recruiter_delete()
    {
        $this->delete("api/recruiters/2",[],$this->admin_login())->assertStatus(200);
    }
    public function test_recruiter_delete_with_bad_route()
    {
        $this->delete("api/recruiters/{id}",[],$this->admin_login())->assertStatus(404);
    }

    public function test_recruiter_logout()
    {
        $this->post("api/recruiters/logout",[],$this->admin_login())->assertStatus(200);
    }


    // if logged user is Recruiter

    public function test_if_logged_user_is_recruiter_recruiter_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/recruiters/create",[
            "name"=>"Petar",
            "surname"=>"Petrovic",
            "email"=>"petar@gmail.com",
            "password"=>"123456"
        ],$this->recruiter_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_recruiter_recruiter_update()
    {
        $this->put("api/recruiters/3",[
            "email"=>"pera@gmail.com"
        ],$this->recruiter_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_recruiter_recruiter_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/recruiters/1",[],$this->recruiter_login())->assertStatus(200);
    }
    public function  test_if_logged_user_is_recruiter_recruiter_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/recruiters/list",[],$this->recruiter_login())->assertStatus(200);

    }
    public function  test_if_logged_user_is_recruiter_recruiter_delete()
    {
        $this->delete("api/recruiters/3",[],$this->recruiter_login())->assertStatus(403);
    }
    // if logged user is Mentor

    public function test_if_logged_user_is_mentor_recruiter_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/recruiters/create",[
            "name"=>"Petar",
            "surname"=>"Petrovic",
            "email"=>"petar@gmail.com",
            "password"=>"123456"
        ],$this->mentor_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_mentor_recruiter_update()
    {
        $this->put("api/recruiters/3",[
            "email"=>"pera@gmail.com"
        ],$this->mentor_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_mentor_recruiter_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/recruiters/1",[],$this->mentor_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_mentor_recruiter_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/recruiters/list",[],$this->mentor_login())->assertStatus(403);

    }
    public function  test_if_logged_user_is_mentor_recruiter_delete()
    {
        $this->delete("api/recruiters/3",[],$this->mentor_login())->assertStatus(403);
    }
}
