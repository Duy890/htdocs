<?php
class Register extends Controller{
    function index(){
        $this->model("register"); // Load the register model
        $this->view("loginlayout", [
            "Page" => "register"
        ]);
    }
}