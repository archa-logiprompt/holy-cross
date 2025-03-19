<?php

/**
 * 
 */
class Staffattendance extends Admin_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->load->helper('file');
        //  $this->lang->load('message', 'english');
        $this->config->load("mailsms");
        $this->config->load("payroll");
        $this->load->library('mailsmsconf');
        $this->config_attendance = $this->config->item('attendence');
        $this->staff_attendance = $this->config->item('staffattendance');
        $this->load->model("staffattendancemodel");
        $this->load->model("staff_model");
        $this->load->model("payroll_model");
    }

    function index()
    {


        if (!($this->rbac->hasPrivilege('staff_attendance', 'can_view'))) {
            access_denied();
        }
        //  if(!$this->rbac->hasPrivilege('staff_attendance','can_add')){
        // access_denied();
        // }
        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/staffattendance');
        $data['title'] = 'Staff Attendance List';
        $data['title_list'] = 'Staff Attendance List';
        $user_type = $this->staff_model->getStaffRole();

        $data['classlist'] = $user_type;
        $data['class_id'] = "";
        $data['section_id'] = "";
        $data['date'] = "";
        $user_type_id = $this->input->post('user_id');
        $leavetype = $this->staffattendancemodel->getLeaveType();
        $data['leavetype'] = $leavetype;
        $data["user_type_id"] = $user_type_id;
        if (!(isset($user_type_id))) {

            $this->load->view('layout/header', $data);
            $this->load->view('admin/staffattendance/staffattendancelist', $data);
            $this->load->view('layout/footer', $data);
        } else {

            $user_type = $this->input->post('user_id');
            $date = $this->input->post('date');
            $user_list = $this->staffattendancemodel->get();
            $data['userlist'] = $user_list;
            $data['class_id'] = $user_list;
            $data['user_type_id'] = $user_type_id;
            $data['section_id'] = "";
            $data['date'] = $date;
            $search = $this->input->post('search');
            $holiday = $this->input->post('holiday');

            $this->session->set_flashdata('msg', '');

            if ($search == "saveattendence") {

                $user_type_ary = $this->input->post('student_session');
                $admin = $this->session->userdata('admin');
                $absent_student_list = array();
                foreach ($user_type_ary as $key => $value) {
                    $checkForUpdate = $this->input->post('attendendence_id' . $value);

                    if ($checkForUpdate != 0) {


                        if (isset($holiday)) {
                            $arr = array(
                                'id' => $checkForUpdate,
                                'staff_id' => $value,
                                'centre_id' => $admin['centre_id'],
                                'staff_attendance_type_id' => 5,
                                'remark' => $this->input->post("remark" . $value),
                                'leave_type' => $this->input->post("selLeave" . $value),
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date))
                            );
                        } else {
                            $arr = array(
                                'id' => $checkForUpdate,
                                'staff_id' => $value,
                                'centre_id' => $admin['centre_id'],
                                'staff_attendance_type_id' => $this->input->post('attendencetype' . $value),
                                'remark' => $this->input->post("remark" . $value),
                                'leave_type' => $this->input->post("selLeave" . $value),
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date))
                            );
                        }

                        $insert_id = $this->staffattendancemodel->add($arr);
                    } else {
                        if (isset($holiday)) {
                            $arr = array(
                                'staff_id' => $value,
                                'centre_id' => $admin['centre_id'],
                                'staff_attendance_type_id' => 5,
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date)),
                                'remark' => '',
                                'leave_type' => '',
                            );
                        } else {


                            $arr = array(
                                'staff_id' => $value,
                                'centre_id' => $admin['centre_id'],
                                'staff_attendance_type_id' => $this->input->post('attendencetype' . $value),
                                'date' => date('Y-m-d', $this->customlib->datetostrtotime($date)),
                                'leave_type' => $this->input->post("selLeave" . $value),
                                'remark' => $this->input->post("remark" . $value),
                            );
                        }

                        $insert_id = $this->staffattendancemodel->add($arr);
                        $absent_config = $this->config_attendance['absent'];
                        if ($arr['staff_attendance_type_id'] == $absent_config) {
                            $absent_student_list[] = $value;
                        }
                    }
                }



                $absent_config = $this->config_attendance['absent'];
                if (!empty($absent_student_list)) {

                    $this->mailsmsconf->mailsms('absent_attendence', $absent_student_list, $date);
                }

                $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Attendance Saved Successfully</div>');

                redirect('admin/staffattendance/index');
            }

            $attendencetypes = $this->attendencetype_model->getStaffAttendanceType();
            $data['attendencetypeslist'] = $attendencetypes;
            $resultlist = $this->staffattendancemodel->searchAttendenceUserType($user_type, date('Y-m-d', $this->customlib->datetostrtotime($date)));
            $data['resultlist'] = $resultlist;
            /*$leavetype=$this->staffattendancemodel->getLeaveType();
			$data['leavetype']= $leavetype;*/
            //var_dump($data['leavetype']);

            $this->load->view('layout/header', $data);
            $this->load->view('admin/staffattendance/staffattendancelist', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function attendancereport()
    {
        if (!$this->rbac->hasPrivilege('staff_attendance_report', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/staffattendance/attendancereport');
        $attendencetypes = $this->staffattendancemodel->getStaffAttendanceType();
        $data['attendencetypeslist'] = $attendencetypes;
        $staffRole = $this->staff_model->getStaffRole();
        $data["role"] = $staffRole;
        $data['title'] = 'Attendance Report';
        $data['title_list'] = 'Attendance';
        $data['monthlist'] = $this->customlib->getMonthDropdown();
        $data['yearlist'] = $this->staffattendancemodel->attendanceYearCount();
        $data['date'] = "";
        $data['month_selected'] = "";
        $data["role_selected"] = "";
        $role = $this->input->post("role");
        $this->form_validation->set_rules('month', 'Month', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/staffattendance/attendancereport', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $resultlist = array();
            $month = $this->input->post('month');
            $role = $this->input->post('role');
            $searchyear = $this->input->post('year');
            $data['month_selected'] = $month;
            $data["role_selected"] = $role;
            $data["year_selected"] = $searchyear;


            $start_date = "01-" . $month . "-" . $searchyear;
            $start_time = strtotime($start_date);

            $end_time = strtotime("+1 month", $start_time);

            for ($i = $start_time; $i < $end_time; $i += 86400) {
                $days[] = date('Y-m-d', $i);
            }
            $staff = $this->staffattendancemodel->getStaff($role);
            $data['staff'] = $staff;
            $data['resultlist'] = true;
            $data['days'] = $days;
            $attendance = array();

            $today = date("Y-m-d");
            foreach ($staff as $index => $row) {
                foreach ($days as $day => $date) {
                    $in_out = array();
                    if ($today < $date) {
                        $in_out['type'] = "-";
                    } else {
                        $in_out = $this->staffattendancemodel->getStaffAttendance($row['employee_id'], date('n', strtotime($month)), $searchyear, $date, $row['staff_type'], $row['id']);
                        // echo $this->db->last_query();exit;

                    }



                    $attendance[$index][$day] = $in_out;
                }
            }
            $data['attendance'] = $attendance;

            $this->load->view('layout/header', $data);
            $this->load->view('admin/staffattendance/attendancereport', $data);
            $this->load->view('layout/footer', $data);
        }
    }
    function attendancereportbyperiod()
    {

        if (!$this->rbac->hasPrivilege('staff_attendance_report', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'HR');
        $this->session->set_userdata('sub_menu', 'admin/staffattendance/attendancereportbyperiod');
        $attendencetypes = $this->staffattendancemodel->getStaffAttendanceType();
        $data['attendencetypeslist'] = $attendencetypes;
        // $staffRole = $this->staff_model->getStaffRole();
        // $data["role"] = $staffRole;

        $staff_list = $this->staff_model->getstafflist();
        $data['staff_list'] =  $staff_list;

        $data['title'] = 'Attendance Report';
        $data['title_list'] = 'Attendance';
        $data['monthlist'] = $this->customlib->getMonthDropdown();
        $data['yearlist'] = $this->staffattendancemodel->attendanceYearCount();
        $userdata = $this->customlib->getUserData();
        $carray = array();

        if (!empty($data["classlist"])) {
            foreach ($data["classlist"] as $ckey => $cvalue) {

                $carray[] = $cvalue["id"];
            }
        }

        $button = $this->input->post('search');
        if ($this->input->server('REQUEST_METHOD') == "GET") {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/staffattendance/attendancereportbyperiod', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $staff = $this->input->post('staff');
            $staffDetails = $this->db->select('id,staff_type,name,surname')->where('employee_id', $staff)->get('staff')->row();
            $resultlist = array();
            $month = $this->input->post('month');
            $role = $this->input->post('role');
            $searchyear = $this->input->post('year');
            $data['month_selected'] = $month;
            $data['staff_id'] = $staff;
            $data['staffname'] = $staffDetails->name." ".$staffDetails->surname;
            $data["role_selected"] = $role;
            $data["year_selected"] = $searchyear;


            $start_date = "01-" . $month . "-" . $searchyear;
            $start_time = strtotime($start_date);

            $end_time = strtotime("+1 month", $start_time);

            for ($i = $start_time; $i < $end_time; $i += 86400) {
                $days[] = date('Y-m-d', $i);
            }

            $data['resultlist'] = true;
            $data['days'] = $days;
            $attendance = array();

            $today = date("Y-m-d");

            foreach ($days as $day => $date) {
                $in_out = array();
                if ($today < $date) {
                    $in_out['type'] = "-";
                } else {
                    $in_out = $this->staffattendancemodel->getStaffAttendanceIndividual($staff, date('n', strtotime($month)), $searchyear, $date, $staffDetails->staff_type, $staffDetails->id);
                    // echo $this->db->last_query();exit;

                }



                $attendance[$day] = $in_out;
            }

            $data['attendance'] = $attendance;

            $this->load->view('layout/header', $data);
            $this->load->view('admin/staffattendance/attendancereportbyperiod', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function monthAttendance($st_month, $no_of_months, $emp)
    {

        $this->load->model("payroll_model");
        $record = array();

        $r = array();
        $month = date('m', strtotime($st_month));
        $year = date('Y', strtotime($st_month));

        foreach ($this->staff_attendance as $att_key => $att_value) {

            $s = $this->payroll_model->count_attendance_obj($month, $year, $emp, $att_value);

            $r[$att_key] = $s;
        }

        $record[$emp] = $r;

        return $record;
    }

    function profileattendance()
    {

        $monthlist = $this->customlib->getMonthDropdown();
        $startMonth = $this->setting_model->getStartMonth();
        $data["monthlist"] = $monthlist;
        $data['yearlist'] = $this->staffattendancemodel->attendanceYearCount();
        $staffRole = $this->staff_model->getStaffRole();
        $data["role"] = $staffRole;
        $data["role_selected"] = "";
        $j = 0;
        for ($i = 1; $i <= 31; $i++) {

            $att_date = sprintf("%02d", $i);

            $attendence_array[] = $att_date;

            foreach ($monthlist as $key => $value) {

                $datemonth = date("m", strtotime($value));
                $att_dates = date("Y") . "-" . $datemonth . "-" . sprintf("%02d", $i);
                $date_array[] = $att_dates;
                $res[$att_dates] = $this->staffattendancemodel->searchStaffattendance($staff_id = 8, $att_dates);
            }

            $j++;
        }

        $data["resultlist"] = $res;
        $data["attendence_array"] = $attendence_array;
        $data["date_array"] = $date_array;

        $this->load->view("layout/header");
        $this->load->view("admin/staff/staffattendance", $data);
        $this->load->view("layout/footer");
    }
}
