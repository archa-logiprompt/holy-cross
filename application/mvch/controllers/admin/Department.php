<?php

/**
 * 
 */
class Department extends Admin_Controller
{

    function __construct()
    {

        parent::__construct();

        $this->load->helper('file');
        $this->config->load("payroll");
        $this->load->model('department_model');
        $this->load->model('staff_model');
    }

    function department()
    {

        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/department/department');

        $departmenttypeid = $this->input->post("departmenttypeid");



        $DepartmentTypes = $this->department_model->getDepartmentType();
        $data["departmenttype"] = $DepartmentTypes;
        $this->form_validation->set_rules('code', 'Department Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules(
            'type',
            'Department Name',
            array(
                'required',
                array('check_exists', array($this->department_model, 'valid_department'))
            )
        );
        $data["title"] = "Add Department";
        if ($this->form_validation->run()) {

            $type = $this->input->post("type");
            $code = $this->input->post("code");
            $departmenttypeid = $this->input->post("departmenttypeid");
            $status = $this->input->post("status");
            $admin = $this->session->userdata('admin');
            if (empty($departmenttypeid)) {

                if (!$this->rbac->hasPrivilege('department', 'can_add')) {
                    access_denied();
                }
            } else {

                if (!$this->rbac->hasPrivilege('department', 'can_edit')) {
                    access_denied();
                }
            }
            if (!empty($departmenttypeid)) {
                $data = array('department_name' => $type, 'department_code' => $code, 'centre_id' => $admin['centre_id'], 'is_active' => 'yes', 'id' => $departmenttypeid);
            } else {

                $data = array('department_name' => $type, 'department_code' => $code, 'centre_id' => $admin['centre_id'], 'is_active' => 'yes');
            }
            $insert_id = $this->department_model->addDepartmentType($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success">Record added Successfully</div>');
            redirect("admin/department/department");
        } else {

            $this->load->view("layout/header");
            $this->load->view("admin/staff/departmentType", $data);
            $this->load->view("layout/footer");
        }
    }

    function departmentedit($id)
    {

        $result = $this->department_model->getDepartmentType($id);

        $data["result"] = $result;
        $data["title"] = "Edit Department";
        $departmentTypes = $this->department_model->getDepartmentType();
        $data["departmenttype"] = $departmentTypes;
        $this->load->view("layout/header");
        $this->load->view("admin/staff/departmentType", $data);
        $this->load->view("layout/footer");
    }

    function departmentdelete($id)
    {

        $this->department_model->deleteDepartment($id);
        redirect('admin/department/department');
    }
    function get_subjectdepartment()
    {
        $subject_id = $this->input->post('subject_id');
        $data = $this->department_model->get_subjectdepartment();
        echo json_encode($data);
    }
}
