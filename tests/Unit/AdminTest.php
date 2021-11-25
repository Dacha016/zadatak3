<?php

namespace Tests\Unit;

use App\Models\Admin;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    // if logged user in Admin


    public function test_admin_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/admins/create",[
            "name"=>"Petar",
            "surname"=>"Petrovic",
            "email"=>"petar@gmail.com",
            "password"=>"123456"
        ],$this->admin_login())->assertStatus(201);
    }
    public function test_admin_store_with_bad_data()
    {
        $this->post("api/admins/create",["name"=>"Petar1",
        "surname"=>"Petrovic",
        "email"=>"pera@gmail.com",
        "password"=>"123456"],$this->admin_login())->assertStatus(422);
    }
    public function test_admin_update()
    {
        $admin=Admin::where("id",1)->first()->toArray();
        $loggedAdmin=$this->admin_login();
        if($loggedAdmin[0]["id"]===$admin["id"]){
            $this->put("api/admins/1",[
                "email"=>"pera@gmail.com"
            ])->assertStatus(200);
        }
    }
    public function test_admin_update_with_bad_route()
    {
        $this->put("api/admins/{id}",[
            "email"=>"pera@gmail.com"
        ],$this->admin_login())->assertStatus(403);
    }
    public function test_admin_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/admins/1",[],$this->admin_login())->assertStatus(200);
    }
    public function test_admin_show_with_bad_route()
    {
        $this->withoutExceptionHandling();
        $this->get("api/admins/{id}",[],$this->admin_login())->assertStatus(404);
    }
    public function test_admin_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/admins/list",[],$this->admin_login())->assertStatus(200);

    }
    public function test_admin_delete()
    {
        $this->delete("api/admins/2",[],$this->admin_login())->assertStatus(200);
    }
    public function test_admin_delete_with_bad_route()
    {
        $this->delete("api/admins/{id}",[],$this->admin_login())->assertStatus(404);
    }

    public function test_admin_logout()
    {
        $this->post("api/admins/logout",[],$this->admin_login())->assertStatus(200);
    }


    // if logged user is Recruiter

    public function test_if_logged_user_is_recruiter_admin_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/admins/create",[
            "name"=>"Petar",
            "surname"=>"Petrovic",
            "email"=>"petar@gmail.com",
            "password"=>"123456"
        ],$this->recruiter_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_recruiter_admin_update()
    {
        $this->put("api/admins/3",[
            "email"=>"pera@gmail.com"
        ],$this->recruiter_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_recruiter_admin_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/admins/1",[],$this->recruiter_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_recruiter_admin_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/admins/list",[],$this->recruiter_login())->assertStatus(403);

    }
    public function  test_if_logged_user_is_recruiter_admin_delete()
    {
        $this->delete("api/admins/3",[],$this->recruiter_login())->assertStatus(403);
    }
    // if logged user is Mentor

    public function test_if_logged_user_is_mentor_admin_store()
    {
        $this->withoutExceptionHandling();
        $this->post("api/admins/create",[
            "name"=>"Petar",
            "surname"=>"Petrovic",
            "email"=>"petar@gmail.com",
            "password"=>"123456"
        ],$this->mentor_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_mentor_admin_update()
    {
        $this->put("api/admins/3",[
            "email"=>"pera@gmail.com"
        ],$this->mentor_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_mentor_admin_show()
    {
        $this->withoutExceptionHandling();
        $this->get("api/admins/1",[],$this->mentor_login())->assertStatus(403);
    }
    public function  test_if_logged_user_is_mentor_admin_index()
    {
        $this->withoutExceptionHandling();
        $this->get("api/admins/list",[],$this->mentor_login())->assertStatus(403);

    }
    public function  test_if_logged_user_is_mentor_admin_delete()
    {
        $this->delete("api/admins/3",[],$this->mentor_login())->assertStatus(403);
    }
}
