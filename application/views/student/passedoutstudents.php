<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<style type="text/css">

</style>

<div class="content-wrapper" style="min-height: 946px;">  
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus"></i> <?php echo "Passed Out" ?> <small><?php echo $this->lang->line('student1'); ?></small></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="box-body">
                        <?php if ($this->session->flashdata('msg')) { ?> <div class="alert alert-success">  <?php echo $this->session->flashdata('msg') ?> </div> <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <form role="form" action="<?php echo site_url('student/passedout') ?>" method="post" class="">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="col-sm-6">
                                            <div class="form-group"> 
                                                <label><?php echo $this->lang->line('class'); ?></label> <small class="req"> *</small> 
                                                <select autofocus="" id="class_id" name="class_id" class="form-control" >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                    <?php
                                                    foreach ($classlist as $class) {
                                                        ?>
                                                                        <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id'])
                                                                               echo "selected=selected" ?>><?php echo $class['class'] ?></option>
                                                                        <?php
                                                                        $count++;
                                                    }
                                                    ?>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                            </div>  
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small> 
                                                <select  id="section_id" name="section_id" class="form-control" >
                                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                </select>
                                                <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                            </div>   
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>
                                </div>  
                                
                                </form>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="row">
                                    <form role="form" action="<?php echo site_url('student/search') ?>" method="post" class="">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label><?php echo $this->lang->line('search_by_keyword'); ?></label>
                                                <input type="text" name="search_text" class="form-control"   placeholder="<?php echo $this->lang->line('search_by_student_name'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button type="submit" name="search" value="search_full" class="btn btn-primary pull-right btn-sm checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <?php
                if (isset($resultlist)) {
                    //var_dump($resultlist);
                    ?>
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-list"></i> <?php echo $this->lang->line('list'); ?>                  <?php echo $this->lang->line('view'); ?></a></li>
                                            <!-- <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-newspaper-o"></i> <?php echo $this->lang->line('details'); ?>     <?php echo $this->lang->line('view'); ?></a></li> -->
                                        </ul>
                                        <div class="tab-content">
                                            <div class="download_label"> <?php echo $this->Setting_model->getCurrentSchoolName(); ?></br>
                                            <?php echo $title; ?></div>
                                            <div class="tab-pane active table-responsive no-padding" id="tab_1">
                                                <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang->line('admission_no'); ?></th>
                                                            <th><?php echo $this->lang->line('student_name'); ?></th>
                                                            <th><?php echo $this->lang->line('class'); ?></th>
                                                             <th>Batch</th>
                                                            <!-- <th><?php echo $this->lang->line('father_name'); ?></th> -->
                                                            <!-- <th><?php echo $this->lang->line('date_of_birth'); ?></th> -->
                                                            <!-- <th><?php echo $this->lang->line('email'); ?></th> -->
                                                            <!-- <th><?php echo $this->lang->line('gender'); ?></th> -->
                                           
                                                            <!-- <th><?php echo $this->lang->line('mobile_no'); ?></th> -->

                                                            <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (empty($resultlist)) {
                                                            ?>
                                                                                            <!-- <tr>
                                                                <td colspan="12" class="text-danger text-center"><?php echo $this->lang->line('no_record_found'); ?></td>
                                                            </tr> -->
                                                                            <?php
                                                        } else {
                                                            $count = 1;
                                                            foreach ($resultlist as $student) {
                                                                ?>
                                                                                                <tr>
                                                                                                    <td><?php echo $student['admission_no']; ?></td>
                                                                                                    <td>
                                                                                                        <a href="<?php echo base_url(); ?>student/view/<?php echo $student['id']; ?>"><?php echo $student['firstname'] . " " . $student['lastname']; ?>
                                                                                                        </a>
                                                                                                    </td>
                                                                                                    <td><?php echo $student['class'] . "(" . $student['section'] . ")" ?></td>
                                                                                                    <td><?php echo $this->setting_model->getCurrentSessionName(); ?></td>
                                                                                                    <!-- <td><?php echo $student['father_name']; ?></td> -->
                                                                                                    <!-- <td><?php if ($student["dob"] != null) {
                                                                                                        echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob']));
                                                                                                    } ?></td> -->
                                                                                                    <!-- <td><?php echo $student['email']; ?></td> -->
                                                                                                    <!-- <td><?php echo $student['gender']; ?></td> -->
                                                    
                                                                                                    <!-- <td><?php echo $student['mobileno']; ?></td> -->

                                                                                                    <td class="pull-right">
                                                                                                    <a href="#" data-studentdata='<?php echo json_encode($student); ?>' class="btn  btn-xs open-modal" data-toggle="tooltip" title="<?php echo $this->lang->line('show'); ?>" data-student-id="<?php echo $student['id']; ?>" >
                                                                                                            <button class="btn <?php  echo $student['duration']?'btn-warning':'btn-success' ?>  " data-studentdata="<?php echo json_encode($student) ?>" >Passed Out</button>
                                                                                                        </a>
                                                        
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <?php
                                                                                                $count++;
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>                           
                                            <div class="tab-pane" id="tab_2">
                                                <?php if (empty($resultlist)) {
                                                    ?>
                                                                    <div class="alert alert-info"><?php echo $this->lang->line('no_record_found'); ?></div>
                                                                    <?php
                                                } else {
                                                    $count = 1;
                                                    // var_dump($resultlist);exit;
                                                    foreach ($resultlist as $student) {

                                                        if (empty($student["image"])) {
                                                            $image = "uploads/student_images/no_image.png";
                                                        } else {
                                                            $image = $student['image'];
                                                        }
                                                        ?>
                                                                                        <div class="carousel-row">
                                                                                            <div class="slide-row">
                                                                                                <div id="carousel-2" class="carousel slide slide-carousel" data-ride="carousel">
                                                                                                    <div class="carousel-inner">
                                                                                                        <div class="item active">
                                                                                                            <a href="<?php echo base_url(); ?>student/view/<?php echo $student['id'] ?>"> <img class="img-responsive img-thumbnail width150" alt="<?php echo $student["firstname"] . " " . $student["lastname"] ?>" src="<?php echo base_url() . $image; ?>" alt="Image"></a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="slide-content">
                                                                                                    <h4><a href="<?php echo base_url(); ?>student/view/<?php echo $student['id'] ?>"> <?php echo $student['firstname'] . " " . $student['lastname'] ?></a></h4>
                                                                                                    <div class="row">
                                                                                                        <div class="col-xs-6 col-md-6">
                                                                                                            <address>
                                                                                                                <strong><b><?php echo $this->lang->line('class'); ?>: </b><?php echo $student['class'] . "(" . $student['section'] . ")" ?></strong><br>
                                                                                                                <b><?php echo $this->lang->line('admission_no'); ?>: </b><?php echo $student['admission_no'] ?><br/>
                                                                                                                <b><?php echo $this->lang->line('date_of_birth'); ?>:
                                                                                                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob'])); ?><br>
                                                                                                                    <b><?php echo $this->lang->line('gender'); ?>:&nbsp;</b><?php echo $student['gender'] ?><br>
                                                                                                                    </address>
                                                                                                                    </div>
                                                                                                                    <div class="col-xs-6 col-md-6">
                                                                                                                        <b><?php echo $this->lang->line('local_identification_no'); ?>:&nbsp;</b><?php echo $student['samagra_id'] ?><br>
                                                                                                                        <b><?php echo $this->lang->line('guardian_name'); ?>:&nbsp;</b><?php echo $student['guardian_name'] ?><br>
                                                                                                                        <b><?php echo $this->lang->line('guardian_phone'); ?>: </b> <abbr title="Phone"><i class="fa fa-phone-square"></i>&nbsp;</abbr> <?php echo $student['guardian_phone'] ?><br>
                                                                                                                        <b><?php echo $this->lang->line('current_address'); ?>:&nbsp;</b><?php echo $student['current_address'] ?>                                                 <?php echo $student['city'] ?><br>
                                                                                                                    </div>
                                                                                                                    </div>
                                                                                                                    </div>
                                                                                                                    <div class="slide-footer">
                                                                                                                        <span class="pull-right buttons">
                                                                                                                            <a href="<?php echo base_url(); ?>student/view/<?php echo $student['id'] ?>" class="btn btn-info "  data-toggle="tooltip" title="<?php echo $this->lang->line('show'); ?>" >
                                                                                                                                <i class="fa fa-reorder"></i>
                                                                                                                            </a>
                                                                                                               
                                                                                            <?php } ?> 
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                                <?php
                                                }
                                                $count++;
                }
                ?>
                                                                        </div>                                                          
                                                                        </div>                                                         
                                                                        </div>
                
                                                        </div>  
                                                        </div> 
                                                        </section>
                                                        </div>
                                                                            <div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5 class="modal-title" id="studentModalLabel">Passed Out Details</h5>
                                </div>
                                <form id="form1" action="<?php echo site_url('student/datecompletion') ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <input type="hidden" name="student_id" id="student_id">
                                <b><?php echo "Admission No" ?>: </b><span id="admission_no"> </span><br>
                                <b><?php echo "Name" ?>: </b><span id="firstname"> </span><br>
                                <b><?php echo "Class-Section" ?>: </b><span id="class_section"> </span><br>
                              
                
                                <b><?php echo "Duration of Course(In Year)" ?>: </b> <input value=""   name="duration" id="duration" placeholder="" type="number" class="form-control"  value="" />
                                <b><?php echo "Date of publication of Final Result" ?>: </b> <input value="" name="date_of_result" id="date_of_result" placeholder="" type="date" class="form-control"  value="" />
                                
                                <b><?php echo "Date Completion" ?>: </b> <input value="" name="date_of_completion" id="date_of_completion" placeholder="" type="date" class="form-control"  value="" />
<br>

                                   
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                                  </form>
                            </div>
                        </div>
                    </div>


                                                        <script type="text/javascript">
                                                            function getSectionByClass(class_id, section_id) {
                                                                if (class_id != "" && section_id != "") {
                                                                    $('#section_id').html("");
                                                                    var base_url = '<?php echo base_url() ?>';
                                                                    var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                                                                    $.ajax({
                                                                        type: "GET",
                                                                        url: base_url + "sections/getByClass",
                                                                        data: {'class_id': class_id},
                                                                        dataType: "json",
                                                                        success: function (data) {
                                                                            $.each(data, function (i, obj)
                                                                            {
                                                                                var sel = "";
                                                                                if (section_id == obj.section_id) {
                                                                                    sel = "selected";
                                                                                }
                                                                                div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                                                                            });
                                                                            $('#section_id').append(div_data);
                                                                        }
                                                                    });
                                                                }
                                                            }
                                                            $(document).ready(function () {
                                                                var class_id = $('#class_id').val();
                                                                var section_id = '<?php echo set_value('section_id') ?>';
                                                                getSectionByClass(class_id, section_id);
                                                                $(document).on('change', '#class_id', function (e) {
                                                                    $('#section_id').html("");
                                                                    var class_id = $(this).val();
                                                                    var base_url = '<?php echo base_url() ?>';
                                                                    var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                                                                    $.ajax({
                                                                        type: "GET",
                                                                        url: base_url + "sections/getByClass",
                                                                        data: {'class_id': class_id},
                                                                        dataType: "json",
                                                                        success: function (data) {
                                                                            $.each(data, function (i, obj)
                                                                            {
                                                                                div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";
                                                                            });
                                                                            $('#section_id').append(div_data);
                                                                        }
                                                                    });
                                                                });
                                                            });
                                                        </script>
                                                        <script>
    $(document).ready(function () {
        $('.open-modal').on('click', function () {
            let studentdata = $(this).data('studentdata')
            console.log("🚀 ~ studentdata:", studentdata)
            $('#student_id').val(studentdata.id)
            $('#admission_no').text(studentdata.admission_no)
            $('#firstname').text(studentdata.firstname+' '+studentdata.lastname)
            $('#class_section').text(studentdata.class+' '+studentdata.section)
            $('#duration').val(studentdata.duration)
            $('#date_of_result').val(studentdata.date_of_result)
            $('#date_of_completion').val(studentdata.date_of_completion) 

            
            $('#studentModal').modal('show');
        });
    });
</script>