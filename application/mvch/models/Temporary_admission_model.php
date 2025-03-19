<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Temporary_admission_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function create($data)
    {
        $this->db->insert('temporary_admission', $data);
        // $this->session->set_userdata('sub_menu', 'temporary/create');
    }

    public function searchByClassSection($class = null, $section = null, $year = null)
    {
        $admin = $this->session->userdata('admin');
        $centre_id = $admin['centre_id'];
        $this->db->select('classes.id AS `class_id`,classes.class,sections.id AS `section_id`,sections.section,temporary_admission.id,temporary_admission.firstname , temporary_admission.lastname,temporary_admission.email,temporary_admission.user_id,temporary_admission.year')->from('temporary_admission');
        

        $this->db->join('classes', 'temporary_admission.class_id = classes.id');
        $this->db->join('sections', 'sections.id = temporary_admission.section_id');

        if ($class !== null) {
            $this->db->where('temporary_admission.class_id', $class);
        }
        if ($section !== null) {
            $this->db->where('temporary_admission.section_id', $section);
        }
        if ($year !== null) {
            $this->db->where('temporary_admission.year',$year);
        }
      

        $this->db->order_by('temporary_admission.firstname');

         
        // $this->db->order_by('students.admission_no','asc');

        $query = $this->db->get();

        return $query->result_array();

    }
    public function checkUser($username, $otp)
    {

        $user_id = $this->db->select('id,phone')->where('user_id', $username)->get('temporary_admission')->row();
        $this->db->where('id', $user_id->id)->update('temporary_admission', ['otp' => $otp]);
        return $user_id;
    }

    public function checkOtp($id, $otp)
    {
        $user_data = $this->db->where('id', $id)->where('otp', $otp)->get('temporary_admission')->row();
        return ($user_data);
    }

    public function getSectionByClass($class_id)
    {
        $result = $this->db->select('section,sections.id as section_id')->join('sections', 'sections.id=class_sections.section_id')->where('class_id', $class_id)->get('class_sections')->result_array();
        echo json_encode($result);
    }

    public function getscholar($id = null)
    {

        $this->db->select()->from('scholarship');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }
    public function getClass()
    {
        $result = $this->db->select('class,id')->where('centre_id', 2)->get('classes')->result_array();
        return $result;
    }
    public function getsection()
    {
        $result = $this->db->select('section,id')->get('sections')->result_array();
        return $result;
    }
    public function getcat($id = null)
    {

        $this->db->select()->from('categories');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }
    public function getfee($id = null)
    {

        $this->db->select()->from('feeyear');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }
    public function add($data)
    {
        $user_id = $data['user_id'];

        // Check if user_id already exists
        $this->db->select('id');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('temp_user')->row()->id;

        if ($query) {
            // Update the existing record
            $this->db->where('id', $query);
            $this->db->update('temp_user', $data);
        } else {
            // Insert a new record
            $this->db->insert('temp_user', $data);
        }

        // Optionally, you can set a session variable if needed
        // $this->session->set_userdata('sub_menu', 'temporary/create');
    }



    public function getstudent($id)
    {
        $user_data = $this->db->where('user_id', $id)->get('temp_user')->row();
        return ($user_data);
    }
}
