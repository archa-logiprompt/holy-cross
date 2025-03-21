s<style type="text/css">
    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }

        .table-wrapper {
            margin: 20mm auto !important;
            /* Adds margin around the table */
            width: 90% !important;
            /* Adjusts table width to fit within margins */
        }
    }

    .download_label {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        padding: 10px;
    }
</style>
<style>
    .table th,
    .table td {
        padding: 10px;
        /* Increase padding for better spacing */
        text-align: center;
    }

    .table {
        width: 100%;
        table-layout: fixed;
        border-spacing: 5px;
        /* Adds space between table cells */
        border-collapse: separate;
        /* Ensures spacing works */
    }
</style>
<div class="content-wrapper" style="min-height: 946px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class="fa fa-sitemap"></i> <?php echo "Staff Attendance Report By Period" ?></h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <form id='form1' action="<?php echo site_url('admin/staff/yearwise_staff_leave_report') ?>" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('year'); ?></label>
                                        <select id="year" name="year" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($yearlist as $y_key => $year) {
                                            ?>
                                                <option value="<?php echo $year["year"] ?>" <?php
                                                                                            if ($year["year"] == $year_selected) {
                                                                                                echo "selected";
                                                                                            }
                                                                                            ?>><?php echo $year["year"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('year'); ?></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="search" value="search" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                        </div>
                    </form>
                </div>

                <?php

                if (isset($months)) {
                    //var_dump($resultlist);
                ?>
                    <div class="nav-tabs-custom">
                        <button type="button" style="margin-right: 10px; margin-top: 10px;" name="search"
                            id="collection_print"
                            data-class="collection_report"
                            class="btn btn-sm btn-primary login-submit-cs fa fa-print pull-right">
                            Print View
                        </button>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-list"></i> <?php echo $this->lang->line('list'); ?> <?php echo $this->lang->line('view'); ?></a></li>
                            <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-newspaper-o"></i> <?php echo $this->lang->line('details'); ?> <?php echo $this->lang->line('view'); ?></a></li>
                        </ul>



                        <div id='collection_report'>
                            <div id="printcontent">
                                <!--<div class="download_label">-->
                                <!--    <?php echo $this->Setting_model->getCurrentSchoolName(); ?>-->

                                <!--    <?php echo "LEAVE REPORT OF " . $staffname . " for the month of " . $month_selected . " " . $year_selected; ?>-->
                                <!--</div>-->
                                <div class="tab-pane active table-responsive no-padding" id="tab_1">
                                    <!--<h3 class="text-center"><?php echo $this->Setting_model->getCurrentSchoolName(); ?></h3>-->
                                    <h3 style="text-align:center">
                                        <br>
                                        <?php echo "LEAVE REPORT OF " . $staffname ?>
                                        <br><br>
                                    </h3>
                                    <div class="table-wrapper">
                                        <table class="table table-striped table-bordered table-hover  text-center" style="width:80%;margin:0 auto;" border="1">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2"><?php echo "Staff Name" ?></th>
                                                    <th colspan="<?php echo count($leaveType) ?>"><?php echo "Total Leave" ?></th>
                                                    <th colspan="<?php echo count($leaveType) ?>"><?php echo "Leave Taken" ?></th>
                                                    <th colspan="<?php echo count($leaveType) ?>"><?php echo "Balance Leave" ?></th>
                                                </tr>
                                                <tr>
                                                    <?php foreach ($leaveType as $type) { ?>
                                                        <th><?php echo $type['type'] ?></th>
                                                    <?php } ?>
                                                    <?php foreach ($leaveType as $type) { ?>
                                                        <th><?php echo $type['type'] ?></th>
                                                    <?php } ?>
                                                    <?php foreach ($leaveType as $type) { ?>
                                                        <th><?php echo $type['type'] ?></th>
                                                    <?php } ?>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                if (empty($months)) {
                                                ?>
                                                    <tr>
                                                        <td colspan="12" class="text-danger text-center"><?php echo $this->lang->line('no_record_found'); ?></td>
                                                    </tr>
                                                    <?php
                                                } else {

                                                    foreach ($months as $index => $month) {
                                                    ?>
                                                        <tr>
                                                            <td colspan="<?php echo count($leaveType) * 3 + 1 ?>"><?php echo $month ?></td>
                                                        </tr>
                                                        <?php if (!$leaves[$index]) { ?>
                                                            <tr>
                                                                <td colspan="<?php echo count($leaveType) * 3 + 1 ?>"><?php echo "No Leave Taken during this month" ?></td>
                                                            </tr>
                                                        <?php } else { ?>

                                                            <?php foreach ($leaves[$index] as  $leave) {
                                                                // var_dump($leave);
                                                                // exit;
                                                                // var_dump($alloted_leaves[$leave['staff_id']][$leave['leave_type_id']]);
                                                                // exit;

                                                                foreach ($leave as $row) {
                                                                    // var_dump($row);
                                                                    // exit;
                                                            ?>
                                                                    <tr>
                                                                        <td><?php echo $row['applied_by']; ?></td>
                                                                        <?php foreach ($alloted_leaves[$row['staff_id']] as $total_leave) { ?>
                                                                            <td><?php echo $total_leave; ?></td>
                                                                        <?php } ?>




                                                                    </tr>
                                                                <?php }
                                                                ?>

                                                            <?php
                                                            } ?>
                                                        <?php } ?>





                                                <?php

                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        var date_format = '<?php echo $result = strtr($this->customlib->getSchoolDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $('.date').datepicker({
            format: date_format,
            autoclose: true
        });

        $('.detail_popover').popover({
            placement: 'right',
            title: '',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function() {
                return $(this).closest('th').find('.fee_detail_popover').html();
            }
        });
    });
</script>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';

    function printDiv(elem) {
        Popup(jQuery(elem).html());
    }

    function Popup(data) {

        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({
            "position": "absolute",
            "top": "-1000000px"
        });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/bootstrap/css/bootstrap.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/font-awesome.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/ionicons.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/AdminLTE.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/skins/_all-skins.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/iCheck/flat/blue.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/morris/morris.css">');


        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/datepicker/datepicker3.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function() {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);


        return true;
    }
</script>
<script type="text/javascript">
    $(document).on('click', '#collection_print', function() {

        // Get the class value from the data attribute of the button
        let content = $('#printcontent').html();
        content = btoa(content);
        // Make an AJAX request to the 'printwithheaderandfooter' method
        $.ajax({
            url: '<?php echo base_url('admin/weeklycalendarnew/printwithheaderandfooter'); ?>',
            method: 'post',
            data: {
                data: content
            },
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Content-Encoding', 'gzip');
            },

            success: function(data) {
                console.log(data)
                data = data.replace(/['"]+/g, '')
                // Redirect to the generated PDF URL
                window.open("<?php echo base_url() ?>" + data, '_blank');
            },
            error: function(xhr, status, error) {
                console.error('xhr:', xhr);
                console.error('status:', status);
                console.error('error:', error);
            }
        });
    });
</script>