<?php

namespace Tests\Unit;

use Tests\TestCase;

class InternTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_intern_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/interns/create",[
            "name"=>"Petar",
            "surname"=>"Petrovic",
            "email"=>"petar@gmail.com"
        ],$this->admin_login())->assertStatus(201);
    }
    public function test_intern_store_with_bad_data()
    {
        $this->post("api/interns/create",[
            "name"=>"Petar1",
            "surname"=>"Petrovic",
            "password"=>"123456"],$this->admin_login())->assertStatus(422);
    }
    public function test_intern_show()//public route
    {
        $this->withoutExceptionHandling();
        $this->get("api/interns/1")->assertStatus(200);
    }
    public function test_intern_update()
    {
        $this->put("api/interns/1",[
            "email"=>"pera@gmail.com"
        ],$this->admin_login())->assertStatus(200);
    }
    public function test_intern_update_with_bad_route()
    {
        $this->put("api/interns/{id}",[
            "email"=>"pera@gmail.com"
        ],$this->admin_login())->assertStatus(404);
    }
    public function test_intern_delete()
    {
        $this->delete("api/interns/1",[],$this->admin_login())->assertStatus(200);
    }
    public function test_intern_delete_with_bad_route()
    {
        $this->delete("api/interns/{id}",[],$this->admin_login())->assertStatus(404);
    }


    // if logged user is Recruiter

    public function test_if_logged_user_is_recruiter_intern_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/interns/create",[
            "name"=>"Bosko",
            "surname"=>"Stupar",
            "email"=>"bosko@gmail.com"
        ],$this->recruiter_login())->assertStatus(201);
    }
    public function test_if_logged_user_is_recruiter_intern_store_with_bad_data()
    {
        $this->post("api/interns/create",[
            "name"=>"Bosko1",
            "surname"=>"Stupar",
            "email"=>"bosko@gmail.com"
        ],$this->recruiter_login())->assertStatus(422);
    }
    public function  test_if_logged_user_is_recruiter_intern_update()
    {
        $this->put("api/interns/2",[
            "email"=>"pera@gmail.com"
        ],$this->recruiter_login())->assertStatus(200);
    }
    public function  test_if_logged_user_is_recruiter_intern_update_with_bad_route()
    {
        $this->put("api/interns/{id}",[
            "email"=>"pera@gmail.com"
        ],$this->recruiter_login())->assertStatus(404);
    }
    public function  test_if_logged_user_is_recruiter_intern_delete()
    {
        $this->delete("api/interns/2",[],$this->recruiter_login())->assertStatus(200);
    }
    public function  test_if_logged_user_is_recruiter_intern_delete_with_bad_route()
    {
        $this->delete("api/interns/{id}",[],$this->recruiter_login())->assertStatus(404);
    }
    // if logged user is Mentor

    public function test_if_logged_user_is_intern_mentor_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/interns/create",[
            "name"=>"Petar",
            "surname"=>"Petrovic",
            "email"=>"petar@gmail.com"
        ],$this->mentor_login())->assertStatus(201);
    }
    public function test_if_logged_user_is_intern_mentor_store_with_bad_data()
    {
        $this->post("api/interns/create",[
            "name"=>"Petar1",
            "surname"=>"Petrovic",
            "email"=>"petar@gmail.com"
        ],$this->mentor_login())->assertStatus(422);
    }
    public function  test_if_logged_user_is_intern_mentor_update()
    {
        $this->put("api/interns/3",[
            "email"=>"pera@gmail.com"
        ],$this->mentor_login())->assertStatus(200);
    }
    public function  test_if_logged_user_is_intern_mentor_update_with_bad_route()
    {
        $this->put("api/interns/{id}",[
            "email"=>"pera@gmail.com"
        ],$this->mentor_login())->assertStatus(404);
    }
    public function  test_if_logged_user_is_intern_mentor_delete()
    {
        $this->delete("api/interns/3",[],$this->mentor_login())->assertStatus(200);
    }
    public function  test_if_logged_user_is_intern_mentor_delete_with_bad_route()
    {
        $this->delete("api/interns/{id}",[],$this->mentor_login())->assertStatus(404);
    }
    //public routes


    public function test_intern_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/interns/{id}")->assertStatus(404);
    }
    public function test_intern_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/interns/list")->assertStatus(200);

    }
}
