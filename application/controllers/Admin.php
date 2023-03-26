<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->get_user();
    }
    public function index()
    {
        $data                = array();
        $data['maincontent'] = $this->load->view('admin/pages/home', '', true);
        $this->load->view('admin/master', $data);
    }

    public function get_user()
    {
        $jwt_cookie_tk = $this->input->cookie('JWT_Token');
        // echo json_encode($jwt_cookie_tk);
        // die();
        
        if (!empty($jwt_cookie_tk)){

            $JWT_data = AUTHORIZATION::validateToken($jwt_cookie_tk);
            
            if($JWT_data == false || $JWT_data->user_email != "admin@gmail.com"){

                redirect('admin');
            }else{
                $this->session->set_userdata('user_email' , "admin@gmail.com");
                $this->session->set_userdata('user_name' , "admin");
                $this->session->set_userdata('user_id' , "1");
            }
        }else{
            redirect('admin');
        }         

    }

    public function logout()
    {

        $email = $this->session->unset_userdata('user_email');
        $name  = $this->session->unset_userdata('user_name');
        $id    = $this->session->unset_userdata('user_id');
        delete_cookie("JWT_Token");
        if ($email == false) {
            redirect('admin');
        }

    }

}
