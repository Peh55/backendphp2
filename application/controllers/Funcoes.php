<?php
defined('BASEPATH') OR exit('No direct script access allowed ');

class Funcoes extends CI_controller{
    public function index(){
        $this->load->view('index');
    }
    
}