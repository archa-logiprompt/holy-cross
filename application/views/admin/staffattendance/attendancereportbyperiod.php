<style type="text/css">
    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }
        .table-wrapper {
            margin: 20mm auto !important; /* Adds margin around the table */
            width: 90% !important; /* Adjusts table width to fit within margins */
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
    .table th, .table td {
        padding: 10px; /* Increase padding for better spacing */
        text-align: center;
    }
    .table {
        width: 100%;
        table-layout: fixed;
        border-spacing: 5px; /* Adds space between table cells */
        border-collapse: separate; /* Ensures spacing works */
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
                    <form id='form1' action="<?php echo site_url('admin/staffattendance/attendancereportbyperiod') ?>" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo "Teacher List" ?></label>
                                        <select id="staff" name="staff" class="form-control">
                                            <option value="select"><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($staff_list as $staff_list => $value) {
                                            ?>
                                                <option value="<?php echo $value["employee_id"] ?>" <?php
                                                                                                    if ($staff_id == $value["employee_id"]) {
                                                                                                        echo "selected =selected";
                                                                                                    }
                                                                                                    ?>><?php echo $value["name"]; ?></option>
                                            <?php
                                                $count++;
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('role'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('month'); ?></label><small class="req"> *</small>
                                        <select id="month" name="month" class="form-control">
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($monthlist as $m_key => $month) {
                                            ?>
                                                <option value="<?php echo $m_key ?>" <?php
                                                                                        if ($month_selected == $m_key) {
                                                                                            echo "selected =selected";
                                                                                        }
                                                                                        ?>><?php echo $month; ?></option>
                                            <?php
                                                $count++;
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('month'); ?></span>
                                    </div>
                                </div>
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

                if (isset($resultlist)) {
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
                        <div  id="printcontent">
                            <!--<div class="download_label">-->
                            <!--    <?php echo $this->Setting_model->getCurrentSchoolName(); ?>-->

                            <!--    <?php echo "Attendance Report of " . $staffname . " for the month of " . $month_selected . " " . $year_selected; ?>-->
                            <!--</div>-->
                            <div class="tab-pane active table-responsive no-padding" id="tab_1">
                                <!--<h3 class="text-center"><?php echo $this->Setting_model->getCurrentSchoolName(); ?></h3>-->
                                <h3 style="text-align:center">
                                    <br>
                                    <?php echo "Attendance Report of " . $staffname . 
                                    " for the month of " . $month_selected . " " . $year_selected; ?>
                                    <br><br>
                                </h3>
                                <div class="table-wrapper">
                                    <table class="table table-striped table-bordered table-hover  text-center" style="width:80%;margin:0 auto;" border="1">
                                    <thead>
                                        <tr>
                                            <th><?php echo "Date" ?></th>
                                            <th><?php echo "P/A" ?></th>
                                            <th><?php echo "In" ?></th>
                                            <th><?php echo "Out" ?></th>
                                            <th><?php echo "Duration" ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (empty($attendance)) {
                                        ?>
                                            <!-- <tr>
                                                                <td colspan="12" class="text-danger text-center"><?php echo $this->lang->line('no_record_found'); ?></td>
                                                            </tr> -->
                                            <?php
                                        } else {
                                            $count = 1;
                                            // var_dump($attendance);exit;
                                            foreach ($attendance as $index=> $staff) {
                                            ?>
                                          
                                                <tr class="<?php echo (date('w', strtotime($days[$index]))==0?'bg-danger':'')?>">
                                                    <td style="text-align:center"><?php echo date('d/m/Y', strtotime($days[$index]))?></td>
                                                 <td style="text-align:center">
    <?php
    if (date('w', strtotime($days[$index])) == 0) {
        echo 'Sunday';
    } 
    // elseif (empty($staff['in']->LogDate) && empty($staff['out']->LogDate)) {
    //     echo 'A';
    // }
    else {
        echo $staff['type'];
    }
    ?>
</td>
                                                    <!-- <td><?php echo date('H:i:s', strtotime($staff['in']->LogDate)); ?></td> -->
                                                    <td style="text-align:center"><?php echo $staff['in']->LogDate ? date('H:i:s', strtotime($staff['in']->LogDate)) : "-"; ?></td>
                                                    <td style="text-align:center"><?php echo $staff['out']->LogDate ? date('H:i:s', strtotime($staff['out']->LogDate)) : "-"; ?></td>
                                                    <td style="text-align:center">
                                                        <?php
                                                        $in_time = strtotime($staff['in']->LogDate);
                                                        $out_time = strtotime($staff['out']->LogDate);

                                                        if ($in_time && $out_time) {
                                                            $difference = $out_time - $in_time; // Difference in seconds
                                                            echo gmdate('H:i:s', $difference); // Format the difference as HH:MM:SS
                                                        } else {
                                                            echo '-'; // Handle cases where in or out time is missing
                                                        }
                                                        ?>
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
$(document).on('click', '#collection_print', function () {
    
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
         beforeSend: function (xhr) {
        xhr.setRequestHeader('Content-Encoding', 'gzip');
    },
        
        success: function (data) {
            console.log(data)
           data =  data.replace(/['"]+/g, '')
            // Redirect to the generated PDF URL
           window.open("<?php echo base_url() ?>" + data, '_blank');
        },
        error: function (xhr, status, error) {
            console.error('xhr:', xhr);
            console.error('status:', status);
            console.error('error:', error);
        }
    });
});

</script>