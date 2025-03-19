<?php

class Staffattendancemodel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
        $this->current_date = $this->setting_model->getDateYmd();
    }

    public function get($id = null)
    {
        $admin = $this->session->userdata('admin');
        $this->db->select()->join("staff", "staff.id = staff_attendance.staff_id")->where('staff.centre_id', $admin['centre_id'])->from('staff_attendance');
        $this->db->where("staff.is_active", 1);
        if ($id != null) {
            $this->db->where('staff_attendance.id', $id);
        } else {
            $this->db->order_by('staff_attendance.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function getUserType()
    {

        $query = $this->db->query("select distinct user_type from staff where is_active = 1");

        return $query->result_array();
    }
    public function getLeaveType()
    {
        $query = $this->db->query("select *  from leave_types where is_active = 'yes'");

        return $query->result_array();
    }
    public function searchAttendenceUserType($user_type, $date)
    {

        if ($user_type == "select") {

            $query = $this->db->query("select staff_attendance.id, staff_attendance.staff_attendance_type_id,staff_attendance.remark,staff_attendance.leave_type,staff.name,staff.surname,staff.employee_id,staff.contact_no,staff.email,roles.name as user_type,IFNULL(staff_attendance.date, 'xxx') as date,staff.id as staff_id from staff left join staff_roles on staff_roles.staff_id = staff.id left join roles on staff_roles.role_id = roles.id left join staff_attendance on (staff.id = staff_attendance.staff_id) and staff_attendance.date = " . $this->db->escape($date) . " where staff.is_active = 1 order by staff.name");
        } else {

            $query = $this->db->query("select staff_attendance.staff_attendance_type_id,staff_attendance.remark,staff_attendance.leave_type,staff.name,staff.surname,staff.employee_id,staff.contact_no,staff.email,roles.name as user_type,IFNULL(staff_attendance.date, 'xxx') as date, IFNULL(staff_attendance.id, 0) as id, staff.id as staff_id from staff left join staff_roles on (staff.id = staff_roles.staff_id) left join roles on (roles.id = staff_roles.role_id) left join staff_attendance on (staff.id = staff_attendance.staff_id) and staff_attendance.date = " . $this->db->escape($date) . " where roles.name = '" . $user_type . "' and staff.is_active = 1 order by staff.name");
        }
        return $query->result_array();
    }

    public function add($data)
    {


        if (isset($data['id'])) {

            $this->db->where('id', $data['id']);
            $this->db->update('staff_attendance', $data);
        } else {
            $this->db->insert('staff_attendance', $data);
        }
    }

    public function getStaffAttendanceType()
    {

        $query = $this->db->select('*')->where("is_active", 'yes')->get("staff_attendance_type");

        return $query->result_array();
    }

    public function searchAttendanceReport($user_type, $date)
    {
        $admin = $this->session->userdata('admin');

        if ($user_type == "select") {

            $query = $this->db->query("select staff_attendance.staff_attendance_type_id,staff_attendance_type.type as `att_type`,staff_attendance_type.key_value as `key`,staff_attendance.remark,staff.name,staff.surname,staff.employee_id,staff.contact_no,staff.email,roles.name as user_type,IFNULL(staff_attendance.date, 'xxx') as date, IFNULL(staff_attendance.id, 0) as attendence_id, staff.id as id from staff left join staff_attendance on (staff.id = staff_attendance.staff_id) and staff_attendance.date = " . $this->db->escape($date) . " left join staff_attendance_type on staff_attendance_type.id = staff_attendance.staff_attendance_type_id left join staff_roles on staff_roles.staff_id = staff.id left join roles on staff_roles.role_id = roles.id where staff.is_active = 1 and staff.centre_id =" . $admin['centre_id'] . " order by staff.name");
        } else {

            $query = $this->db->query("select staff_attendance.staff_attendance_type_id,staff_attendance_type.type as `att_type`,staff_attendance_type.key_value as `key`,staff_attendance.remark,staff.name,staff.surname,staff.employee_id,staff.contact_no,staff.email,roles.name as user_type,IFNULL(staff_attendance.date, 'xxx') as date, IFNULL(staff_attendance.id, 0) as attendence_id, staff.id as id from staff  left join staff_roles on (staff.id = staff_roles.staff_id) left join roles on (roles.id = staff_roles.role_id) left join staff_attendance on (staff.id = staff_attendance.staff_id) and staff_attendance.date = " . $this->db->escape($date) . " left join staff_attendance_type on staff_attendance_type.id = staff_attendance.staff_attendance_type_id  where roles.name = '" . $user_type . "' and staff.is_active = 1 and staff.centre_id =" . $admin['centre_id'] . " order by staff.name");
        }


        return $query->result_array();
    }

    function attendanceYearCount()
    {

        $query = $this->db->select("distinct(year) as year")
            ->from("feeyear")
            ->order_by("year", "ASC")
            ->get();


        return $query->result_array();
    }

    function searchStaffattendance($staff_id = 8, $date)
    {

        $query = $this->db->query("select staff_attendance.staff_attendance_type_id,staff_attendance_type.type as `att_type`,staff_attendance_type.key_value as `key`,staff_attendance.remark,staff.name,staff.surname,staff.contact_no,staff.email,roles.name as user_type,IFNULL(staff_attendance.date, 'xxx') as date, IFNULL(staff_attendance.id, 0) as attendence_id, staff.id as id from staff left join staff_attendance on (staff.id = staff_attendance.staff_id) and staff_attendance.date = " . $this->db->escape($date) . " left join staff_roles on staff_roles.staff_id = staff.id left join roles on staff_roles.role_id = roles.id left join staff_attendance_type on staff_attendance_type.id = staff_attendance.staff_attendance_type_id  where staff.id = '" . $staff_id . "' and staff.is_active = 1 ");

        return $query->row_array();
    }
    function getStaff()
    {
        $result = $this->db->select('staff.id,staff.employee_id,department.department_code,staff_designation.designation,staff.name,staff.surname,staff.date_of_joining,staff.staff_type')->join('department', 'department.id=staff.department')->join('staff_designation', 'staff_designation.id=staff.designation')->where('staff.id !=', 0)->get('staff')->result_array();
        return $result;
    }

    function getStaffAttendance($id, $month, $year, $date, $staff_type, $staff_id)
    {
    $result['date']=$date;
        $update = $this->db->select('leave_type')->where('staff_id', $staff_id)->where('date', $date)->get('leave_updates')->row()->leave_type;
        if ($update) {
            $result['type'] = $update;
            $result['updated'] = "updated";
        } else {
            $id = (implode('', explode('N', $id)));

            $result['in'] = $this->db->select('*')->where('DeviceId', 1)->where('C4', 0)->where('DATE(LogDate)', $date)->where('UserId', $id)->get('DeviceLogs_' . $month . '_' . $year)->row();

            $result['out'] = $this->db->select('*')->where('DeviceId', 1)->where('C4', 1)->where('DATE(LogDate)', $date)->where('UserId', $id)->get('DeviceLogs_' . $month . '_' . $year)->row();

            $datetime1 = new DateTime($result['in']->LogDate); // start time
            $datetime2 = new DateTime($result['out']->LogDate); // end time
            $interval = $datetime1->diff($datetime2);
            $result['hours'] = $interval->h;
            $result['minutes'] = $interval->i;
            $date_split = explode('-', $date);
            if ((int) $date_split[0] >= 2024 && (int) $date_split[1] >= 10) {
                if ($staff_type == 0) {
                    if ($interval->h >= 8) {
                        $result['type'] = "P";
                    } else {
                        $result['type'] = "A";
                    }
                } elseif ($staff_type == 1) {

                    if ($interval->h >= 7 && $interval->i >= 30) {
                        $result['type'] = "P";
                    } else {
                        $result['type'] = "A";
                    }
                }
            } else {
                if ($interval->h >= 8) {
                    $result['type'] = "P";
                } else {
                    $result['type'] = "A";
                }
            }
        }




        return $result;
    }
    
    function getStaffAttendanceIndividual($id, $month, $year, $date, $staff_type, $staff_id)
    {
    $result['date']=$date;
        $update = $this->db->select('leave_type')->where('staff_id', $staff_id)->where('date', $date)->get('leave_updates')->row()->leave_type;
        if ($update) {
            $result['type'] = $update;
            $result['updated'] = "updated";
        } else {
            $id = (implode('', explode('N', $id)));

            $result['in'] = $this->db->select('*')->where('DeviceId', 1)->where('C4', 0)->where('DATE(LogDate)', $date)->where('UserId', $id)->get('DeviceLogs_' . $month . '_' . $year)->row();

            $result['out'] = $this->db->select('*')->where('DeviceId', 1)->where('C4', 1)->where('DATE(LogDate)', $date)->where('UserId', $id)->get('DeviceLogs_' . $month . '_' . $year)->row();

            $datetime1 = new DateTime($result['in']->LogDate); // start time
            $datetime2 = new DateTime($result['out']->LogDate); // end time
            $interval = $datetime1->diff($datetime2);
            $result['hours'] = $interval->h;
            $result['minutes'] = $interval->i;
            $date_split = explode('-', $date);
            if($result['in']||$result['out']){
                $result['type'] = "P";
            }
            else{
                $result['type'] = "A";
            }
            // if ((int) $date_split[0] >= 2024 && (int) $date_split[1] >= 10) {
            //     if ($staff_type == 0) {
            //         if ($interval->h >= 8) {
            //             $result['type'] = "P";
            //         } else {
            //             $result['type'] = "A";
            //         }
            //     } elseif ($staff_type == 1) {

            //         if ($interval->h >= 7 && $interval->i >= 30) {
            //             $result['type'] = "P";
            //         } else {
            //             $result['type'] = "A";
            //         }
            //     }
            // } else {
            //     if ($interval->h >= 8) {
            //         $result['type'] = "P";
            //     } else {
            //         $result['type'] = "A";
            //     }
            // }
        }




        return $result;
    }
}
