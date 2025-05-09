<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-mortar-board"></i> <?php echo $this->lang->line('scholarship'); ?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('scholarship', 'can_add')) {
                ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('add_scholarship'); ?></h3>
                        </div><!-- /.box-header -->
                        
                        <form id="form1" action="<?php echo base_url(); ?>admin/scholarship/edit/<?php echo $id ?>"  id="employeeform" name="employeeform" method="post" accept-charset="utf-8">
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

                                  <input type="hidden" name="id" value="<?php echo $scholar['id'] ?>" />
                                 
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('scholarship'); ?> <?php echo $this->lang->line('name'); ?></label> <small class="req">*</small>
                                    <input autofocus="" id="name" name="name" type="text" class="form-control"  value="<?php echo set_value('year',$scholar['name']); ?>" />
                                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                                </div>
                                


                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo set_value('description',$scholar['description']); ?></textarea>
                                    <span class="text-danger"></span>
                                </div>
                                
                                
                                
                                     <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('valid_from'); ?></label> 
                                    <input autofocus="" id="valid_from" name="valid_from" type="date" class="form-control"  value="<?php echo set_value('valid_from',$scholar['valid_from']); ?>" />
                                    <span class="text-danger"><?php echo form_error('valid_from'); ?></span>
                                </div>
                                
                                
                             
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('valid_to'); ?></label> 
                                    <input autofocus="" id="valid_to" name="valid_to" type="date" class="form-control"  value="<?php echo set_value('valid_to',$scholar['valid_to']); ?>" />
                                    <span class="text-danger"><?php echo form_error('valid_to'); ?></span>
                                </div>
                                   
                                
                            </div>
                            
                            
                        
                            
                            
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>

                </div><!--/.col (right) -->
                <!-- left column -->
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('scholarship', 'can_add')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('scholarship_list'); ?></h3>
                        <div class="box-tools pull-right">
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('scholarship_list'); ?></div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('scholarship'); ?> <?php echo $this->lang->line('name'); ?>
                                        </th>
                                      <!--  <th><?php //echo $this->lang->line('fees_code'); ?></th>-->



                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									
                                    foreach ($sch as $sch) {
									
                                        ?>
                                        <tr>
                                            <!--<td class="mailbox-name">
                                                <a href="#" data-toggle="popover" class="detail_popover"><?php //echo $feetype['type'] ?></a>

                                                <div class="fee_detail_popover" style="display: none">
                                                    <?php
                                                    //if ($feetype['description'] == "") {
                                                        ?>
                                                        <p class="text text-danger"><?php //echo $this->lang->line('no_description'); ?></p>
                                                        <?php
                                                    //} else {
                                                        ?>
                                                        <p class="text text-info"><?php //echo $feetype['description']; ?></p>
                                                        <?php
                                                    //}
                                                    ?>
                                                </div>
                                            </td>-->
                                            <td class="mailbox-name">
                                                <?php echo $sch['name']; ?>
                                            </td>
                                            
                                            
                     
        <td class="mailbox-date pull-right">
    <?php if ($this->rbac->hasPrivilege('scholarship', 'can_view')) { ?>
                     <a href="<?php echo base_url(); ?>admin/scholarship/assign/<?php echo $sch['id'] ?>" 
          class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('assign / view'); ?>">
                                                        <i class="fa fa-tag"></i>
                                                    </a>
    <?php } ?>
    <?php /*?><?php if ($this->rbac->hasPrivilege('fees_master', 'can_delete')) { ?>
                                                    <a href="<?php echo base_url(); ?>admin/feemaster/deletegrp/<?php echo $feegroup->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                        <i class="fa fa-remove"></i>
                                                    </a>
    <?php } ?><?php */?>

                                            </td>             
                     
                     
                     
                                   <td class="mailbox-date pull-right">
                                                <?php
                                                if ($this->rbac->hasPrivilege('scholarship', 'can_edit')) {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>admin/scholarship/edit/<?php echo $sch['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                <?php } ?>
                                                <?php
                                                if ($this->rbac->hasPrivilege('scholarship', 'can_delete')) {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>admin/scholarship/delete/<?php echo $sch['id'] ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
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
                    </div><!-- /.box-body -->
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
    $(document).ready(function () {
        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

        $('#date').datepicker({
            //  format: "dd-mm-yyyy",
            format: date_format,
            autoclose: true
        });

        $("#btnreset").click(function () {
            $("#form1")[0].reset();
        });

    });
</script>
<script>
    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });
</script>