<?php

namespace Tests\Unit;

use Tests\TestCase;

class MentorTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_mentor_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/mentors/create",[
            "name"=>"Petar",
            "surname"=>"Petrovic",
            "email"=>"petar@gmail.com",
            "password"=>"123456"
        ],$this->admin_login())->assertStatus(201);
    }
    public function test_mentor_store_with_bad_data()
    {
        $this->post("api/mentors/create",["name"=>"Petar1",
        "surname"=>"Petrovic",
        "email"=>"pera@gmail.com",
        "password"=>"123456"],$this->admin_login())->assertStatus(422);
    }
    public function test_mentor_update()
    {
        $this->put("api/mentors/2",[
            "email"=>"pera@gmail.com"
        ],$this->admin_login())->assertStatus(200);
    }
    public function test_mentor_update_with_bad_route()
    {
        $this->put("api/mentors/{id}",[
            "email"=>"pera@gmail.com"
        ],$this->admin_login())->assertStatus(403);
    }
    public function test_mentor_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/mentors/2",[],$this->admin_login())->assertStatus(200);
    }
    public function test_mentor_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/mentors/{id}",[],$this->admin_login())->assertStatus(404);
    }
    public function test_mentor_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/mentors/list",[],$this->admin_login())->assertStatus(200);

    }
    public function test_mentor_delete()
    {
        $this->delete("api/mentors/2",[],$this->admin_login())->assertStatus(200);
    }
    public function test_mentor_delete_with_bad_route()
    {
        $this->delete("api/mentors/{id}",[],$this->admin_login())->assertStatus(404);
    }

    public function test_mentor_logout()
    {
        $this->post("api/mentors/logout",[],$this->admin_login())->assertStatus(200);
    }


    // if logged user is Recruiter

    public function test_if_logged_user_is_recruiter_mentor_store_with_bad_data()
    {
        $this->post("api/mentors/create",[
            "name"=>"Bosko1",
            "surname"=>"Stupar",
            "email"=>"bosko@gmail.com",
            "password"=>"123456"
        ],$this->recruiter_login())->assertStatus(422);
    }
    public function test_if_logged_user_is_recruiter_mentor_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/mentors/create",[
            "name"=>"Bosko",
            "surname"=>"Stupar",
            "email"=>"bosko@gmail.com",
            "password"=>"123456"
        ],$this->recruiter_login())->assertStatus(201);
    }
    public function  test_if_logged_user_is_recruiter_mentor_update()
    {
        $this->put("api/mentors/3",[
            "email"=>"pera@gmail.com"
        ],$this->recruiter_login())->assertStatus(200);
    }
    public function  test_if_logged_user_is_recruiter_mentor_update_with_bad_route()
    {
        $this->put("api/mentors/{id}",[
            "email"=>"pera@gmail.com"
        ],$this->recruiter_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_recruiter_mentor_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/mentors/3",[],$this->recruiter_login())->assertStatus(200);
    }
    public function  test_if_logged_user_is_recruiter_mentor_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/mentors/{id}",[],$this->recruiter_login())->assertStatus(404);
    }
    public function  test_if_logged_user_is_recruiter_mentor_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/mentors/list",[],$this->recruiter_login())->assertStatus(200);

    }
    public function  test_if_logged_user_is_recruiter_mentor_delete()
    {
        $this->delete("api/mentors/3",[],$this->recruiter_login())->assertStatus(200);
    }
    public function  test_if_logged_user_is_recruiter_mentor_delete_with_bad_route()
    {
        $this->delete("api/mentors/{id}",[],$this->recruiter_login())->assertStatus(404);
    }
    // if logged user is Mentor

    public function test_if_logged_user_is_mentor_mentor_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/mentors/create",[
            "name"=>"Petar",
            "surname"=>"Petrovic",
            "email"=>"petar@gmail.com",
            "password"=>"123456"
        ],$this->mentor_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_mentor_mentor_update()
    {
        $this->put("api/mentors/3",[
            "email"=>"pera@gmail.com"
        ],$this->mentor_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_mentor_mentor_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/mentors/1",[],$this->mentor_login())->assertStatus(200);
    }
    public function  test_if_logged_user_is_mentor_mentor_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/mentors/list",[],$this->mentor_login())->assertStatus(200);

    }
    public function  test_if_logged_user_is_mentor_mentor_delete()
    {
        $this->delete("api/mentors/3",[],$this->mentor_login())->assertStatus(403);
    }
}
