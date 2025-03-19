<div class="content-wrapper">  
    <section class="content-header">
        <h1><i class="fa fa-sitemap"></i> <?php echo "Update Attendance" ?>
            </h1>


    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo "Update Leave"; ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?php echo base_url("admin/staff/updateattendance") ?>" method="post">
                                  <div class="form-group col-md-4">
                                    <label for="staff_id">Staff</label>
                                    <select class="form-control" id="staff_id" name="staff_id">
                                        <option value="">Select</option>
                                        <?php foreach($staffs as $staff) {?>
                                        <option value="<?php echo $staff['id']?>"><?php echo $staff['name']." ".$staff['surname']; ?></option>
                                        <?php }?>
                                    </select>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="exampleInputPassword1">Date</label>
                                    <input type="text" class="form-control date" id="date" autocomplete="off" name="date">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label for="leave_type">Leave Type</label>
                                    <select class="form-control" id="leave_type" name="leave_type">
                                        <option value="">Select</option>
                                        <option value="A">Absent</option>
                                        <option value="P">Present</option>
                                        <option value="OD">On Duty</option>
                                    </select>
                                  </div>
                                 
                                  <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>  
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('minutes'); ?> <?php echo $this->lang->line('list'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                     <th><?php echo "Staff"; ?></th>
                                    
                                        <th><?php echo $this->lang->line('date'); ?> 
                                        </th>
                                        <th><?php echo "Leave Type" ?> 
                                        </th>
                                        
                             



               <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									
                                    foreach ($updates as $update) {
                                        ?>
                                        <tr>
                                           
                                            <td class="mailbox-name">
                                                <?php echo $update['name']. " ".$updates['surname']; ?>
                                                
                                            </td>
                                            <td class="mailbox-name">
                                                <?php echo $update['date']; ?>
                                                
                                            </td>
                                             <td class="mailbox-name">
                                                <?php echo $update['leave_type']; ?>
                                                
                                            </td>
                                            
                                            
                                            
                                            
                                            <td class="mailbox-date pull-right">
                                                
                                                <?php
                                                if ($this->rbac->hasPrivilege('update_attendance', 'can_delete')) {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>admin/staff/deletestaffupdate/<?php echo $update['id'] ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div>
                </div>
                
            </div> </div>

    </section>
</div>

<script type="text/javascript">
    /*--dropify--*/
    $(document).ready(function () {
        // Basic
        $('.filestyle').dropify();
    });
    /*--end dropify--*/
</script>

<script type="text/javascript">
    $(document).ready(function () {
        
        
         $('.date').datepicker({
                        dateFormat: "yyyy-mm-dd",
                        autoclose: true
                    });
        
        
        
        getLeaveTypeDDL('<?php echo $staff_id ?>', '');
        $('.detail_popover').popover({
            placement: 'right',
            title: '',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });

        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

        $('#applieddate,#leavefrom,#leaveto').datepicker({
            format: date_format,
            autoclose: true
        });
        $('#reservation').daterangepicker();
    });

    function addLeave() {

        $('input[type=text]').val('');
        $('textarea[name="reason"]').text('');

        $("#resetbutton").click();
        $("#clearform").click();


        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

        $('#applieddate').datepicker({
            format: date_format,
            autoclose: true
        });
        $('#reservation').daterangepicker();
        var date = '<?php echo date("Y-m-d") ?>';
        $('input[type=text][name=applieddate]').val(new Date(date).toString("MM/dd/yyyy"));

        $('#addleave').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
    }


    function getRecord(id) {
        $("#download_file").html('');
        $('input:radio[name=status]').attr('checked', false);
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/leaverequest/leaveRecord',
            type: 'POST',
            data: {id: id},
            dataType: "json",
            success: function (result) {


                $('input[name="leave_request_id"]').val(result.id);
                $('#employee_id').html(result.employee_id);
                $('#name').html(result.name);
                $('#leave_from').html(new Date(result.leave_from).toString("MM/dd/yyyy"));
                $('#leave_to').html(new Date(result.leave_to).toString("MM/dd/yyyy"));
                $('#leave_type').html(result.type);
                $('#days').html(result.leave_days + ' Days');
                $('#remark').html(result.employee_remark);
                $('#applied_date').html(new Date(result.date).toString("MM/dd/yyyy"));
                $('#appliedby').html(result.applied_by);
                $("#detailremark").text(result.admin_remark);
                if (result.document_file != "") {
                    var cl = "<i class='fa fa-download'></i>";
                    $("#download_file").html('<a href=' + base_url + 'admin/staff/download/' + result.staff_id + '/' + result.document_file + ' class=btn btn-default btn-xs  data-toggle=tooltip >' + cl + '</a>');
                }
				$('#prstatus').html(result.pstatus);
				$('#prnote').html(result.principal_remark);
				$('#drstatus').html(result.dstatus);
                $("#drnote").text(result.director_remark);
				$("#status").text(result.status);
				$('#hodstatus').html(result.hod);
				$('#method').html(result.leave_method);
                $("#hodnote").text(result.hod_remark);
                // if(result.status == 'approve'){

                // $('input:radio[name=status]')[1].checked = true;

                // }else if(result.status == 'pending'){
                // $('input:radio[name=status]')[0].checked = true;

                // }
                // else if(result.status == 'disapprove'){
                // $('input:radio[name=status]')[2].checked = true;

                // }


            }
        });

        $('#leavedetails').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
    }
    ;



    $(document).on('click', '.submit_schsetting', function (e) {
        var $this = $(this);
        $this.button('loading');
        $.ajax({
            url: '<?php echo site_url("admin/leaverequest/leaveStatus") ?>',
            type: 'post',
            data: $('#leavedetails_form').serialize(),
            dataType: 'json',
            success: function (data) {

                if (data.status == "fail") {

                    var message = "";
                    $.each(data.error, function (index, value) {

                        message += value;
                    });
                    errorMsg(message);
                } else {

                    successMsg(data.message);
                    window.location.reload(true);
                }

                $this.button('reset');
            }
        });
    });

    function checkStatus(status) {


        if (status == 'approve') {

            $("#reason").hide();
        } else if (status == 'pending') {

            $("#reason").hide();
        } else if (status == 'disapprove') {

            $("#reason").show();
        }

    }


    $(document).ready(function (e) {
        $("#addleave_form").on('submit', (function (e) {

            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url("admin/leaverequest/add_staff_leave") ?>",
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {

                    if (data.status == "fail") {

                        var message = "";
                        $.each(data.error, function (index, value) {

                            message += value;
                        });
                        errorMsg(message);
                    } else {

                        successMsg(data.message);
                        window.location.reload(true);
                    }
                }
            });
        }));


    });


    function getEmployeeName(role) {
        var ne = "";
        var base_url = '<?php echo base_url() ?>';
        $("#empname").html("<option value=''>Select</option>");
        var div_data = "";
        $.ajax({
            type: "POST",
            url: base_url + "admin/staff/getEmployeeByRole",
            data: {'role': role},
            dataType: "json",
            success: function (data) {
                $.each(data, function (i, obj)
                {


                    div_data += "<option value='" + obj.id + "' >" + obj.name + " " + obj.surname + " " + "(" + obj.employee_id + ")</option>";
                });

                $('#empname').append(div_data);
            }
        });
    }

    function setEmployeeName(role, id = '') {
        var ne = "";
        var base_url = '<?php echo base_url() ?>';
        $("#empname").html("<option value=''>Select</option>");
        var div_data = "";
        $.ajax({
            type: "POST",
            url: base_url + "admin/staff/getEmployeeByRole",
            data: {'role': role},
            dataType: "json",
            success: function (data) {
                $.each(data, function (i, obj)
                {
                    if (obj.employee_id == id) {
                        ne = 'selected';
                    } else {
                        ne = "";
                    }

                    div_data += "<option value='" + obj.id + "' " + ne + " >" + obj.name + " " + obj.surname + " " + "(" + obj.employee_id + ")</option>";
                });

                $('#empname').append(div_data);

            }
        });

    }

    function getLeaveTypeDDL(id, lid = '') {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/leaverequest/countLeave/' + id,
            type: 'POST',
            data: {lid: lid},
            //dataType: "json",
            success: function (result) {

                $("#leavetypeddl").html(result);

            }

        });
    }
    function editRecord(id) {

        var leave_from = '05/01/2018';
        var leave_to = '05/10/2018';
        $("#resetbutton").click();
        $('textarea[name="reason"]').text('');

        $('textarea[name="remark"]').text('');
        $('input:radio[name=addstatus]').attr('checked', false);

        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/leaverequest/leaveRecord',
            type: 'POST',
            data: {id: id},
            dataType: "json",
            success: function (result) {


                leave_from = result.leavefrom;
                leave_to = result.leaveto;


                setEmployeeName(result.user_type, result.employee_id);
                getLeaveTypeDDL(result.staff_id, result.lid);
                $('select[name="role"] option[value="' + result.user_type + '"]').attr("selected", "selected");
                $('input[name="applieddate"]').val(new Date(result.date).toString("MM/dd/yyyy"));
                $('input[name="leavefrom"]').val(new Date(result.leave_from).toString("MM/dd/yyyy"));
                $('input[name="filename"]').val(result.document_file);
                $('input[name="leavedates"]').val(result.leavefrom + '-' + result.leaveto);

                $('input[name="leaverequestid"]').val(id);
                $('textarea[name="reason"]').text(result.employee_remark);
                $('textarea[name="remark"]').text(result.admin_remark);

                if (result.status == 'approve') {

                    $('input:radio[name=addstatus]')[1].checked = true;

                } else if (result.status == 'pending') {
                    $('input:radio[name=addstatus]')[0].checked = true;

                } else if (result.status == 'disapprove') {
                    $('input:radio[name=addstatus]')[2].checked = true;

                }

                $('#reservation').daterangepicker({
                    startDate: leave_from,
                    endDate: leave_to
                });
            }
        });
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['m' => 'mm', 'd' => 'dd', 'Y' => 'yyyy',]) ?>';

        $('#applieddate').datepicker({
            format: date_format,
            autoclose: true
        });


        $('#addleave').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
    }
    ;

    function clearForm(oForm) {

        var elements = oForm.elements;



        for (i = 0; i < elements.length; i++) {

            field_type = elements[i].type.toLowerCase();

            switch (field_type) {

                case "text":
                case "password":

                case "hidden":

                    elements[i].value = "";
                    break;

                case "select-one":
                case "select-multi":
                    elements[i].selectedIndex = "";
                    break;

                default:
                    break;
            }
        }
    }

</script>





