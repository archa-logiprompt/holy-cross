<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo "Academic Date" ?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('assign_class_teacher', 'can_add') || $this->rbac->hasPrivilege('assign_class_teacher', 'can_edit')) {
                ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo "Edit Academic Date" ?></h3>

                        </div><!-- /.box-header -->
                        <form id="form1"    method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg') ?>
                                <?php } ?>
                                <?php
                                if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                }
                                ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                    <select class="form-control" name="class"  id="class_id" >
                                      
                                        <?php
                                        foreach ($classlist as $class_key => $class_value) {
                                                ?>

                                            <option <?php
                                            if ($item['class_id'] == $class_value["id"]) {
                                                echo "selected=selected";
                                            }
                                            ?> value="<?php echo $class_value["id"] ?>"><?php echo $class_value["class"] ?></option>
                                                <?php
                                            } 
                                            ?>
                                    </select>

                                    <span class="text-danger"><?php echo form_error('class'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>

                                    <select class="form-control" id="section_id" name="section" >
                                        <option value=""><?php echo $this->lang->line('select') ?></option> 
                                    </select>



                                    <span class="text-danger"><?php echo form_error('section'); ?></span>
                                </div>
                                <div class="col-md-6">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('from'); ?> <small
                                        class="req"> *</small></label>

                                <div class="input-group">
                                    <input autocomplete='false' name="datefrom" type="text" class="form-control date"
                                        value="<?php echo $item['from']; ?>" />
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar-check-o"></i>
                                    </div>
                                </div>
                                <span class="text-danger"><?php echo form_error('dateto'); ?></span>


                            </div>



                            <div class="col-md-6">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('to'); ?> <small
                                        class="req"> *</small> </label>

                                <div class="input-group">
                                    <input autocomplete='false' name="dateto" type="text" class="form-control date"
                                        value="<?php echo $item['to'] ?>" />
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar-check-o"></i>
                                    </div>
                                </div>
                                <span class="text-danger"><?php echo form_error('dateto'); ?></span>


                            </div>

                                

                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>

                </div><!--/.col (right) -->
                <!-- left column -->
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('assign_class_teacher', 'can_add') || $this->rbac->hasPrivilege('assign_class_teacher', 'can_edit')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('class_teacher_list'); ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->Setting_model->getCurrentSchoolName();?></br>
							<?php echo $this->lang->line('class_teacher_list'); ?></div>
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>

                                        <th><?php echo $this->lang->line('class'); ?>
                                        </th>
                                        <th><?php echo $this->lang->line('section'); ?>
                                        </th>
                                        <th>From
                                        </th>
                                        <th>To
                                        </th>

                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;

                                    foreach ($date_items as $items) {
                                        ?>
                                        <tr>
                                            <td class="mailbox-name">
                                                <?php echo getclassname($items["class_id"]); ?>

                                            </td>


                                            <td>

                                            <?php echo getsectionname($items["section_id"]); ?>

                                            </td>
                                            <td>

                                            <?php echo ($items["from"]); ?>

                                            </td>
                                            <td>

                                            <?php echo ($items["to"]); ?>

                                            </td>
                                           
                                            <td class="mailbox-date pull-right" >
                                                <?php
                                                if ($this->rbac->hasPrivilege('assign_class_teacher', 'can_edit')) {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>admin/subject/academicDateEdit/<?php echo $items["id"]; ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <?php
                                                }
                                                if ($this->rbac->hasPrivilege('assign_class_teacher', 'can_delete')) {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>admin/teacher/classteacherdelete/<?php echo $items["id"]; ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>

                                </tbody>
                            </table><!-- /.table -->



                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->


        </div>
        <div class="row">
            <!-- left column -->

            <!-- right column -->
            <div class="col-md-12">

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script type="text/javascript">
    function getSectionByClass(class_id, section_id) {
        if (class_id != "" && section_id != "") {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '';
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

    getSectionByClass('<?php echo $item['class_id'] ?>', '<?php echo $item['section_id'] ?>');
    var section_id = "<?php echo $item['section_id'] ?>";
 
    var date_format =
    '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
$('body').on('focus', ".date", function() {
    $(this).datepicker({
        format: date_format,
        autoclose: true
    });
});
</script>

<?php

function check_in_array($find, $array) {

    foreach ($array as $element) {
        if ($find == $element["id"]) {
            return TRUE;
        }
    }
    return FALSE;
}
?>