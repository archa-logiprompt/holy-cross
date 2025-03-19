<style type="text/css">
    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }
        .excel-print * {
            display: block !important;
        }
    }
        .excel-print {
            display: none !important;
        }
</style>
<div class="content-wrapper" style="min-height: 946px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><i class="fa fa-sitemap"></i> <?php echo "Staff Attendance Report" ?></h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <form id='form1' action="<?php echo site_url('admin/staffattendance/attendancereport') ?>" method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
<?php /*
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('role'); ?></label>
                                        <select id="role" name="role" class="form-control">
                                            <option value="select"><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($role as $role_key => $value) {
                                            ?>
                                                <option value="<?php echo $value["type"] ?>" <?php
                                                                                                if ($role_selected == $value["type"]) {
                                                                                                    echo "selected =selected";
                                                                                                }
                                                                                                ?>><?php echo $value["type"]; ?></option>
                                            <?php
                                                $count++;
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('role'); ?></span>
                                    </div>
                                </div>
                                
                                */?>
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
                ?>
                    <div class="box box-info" id="attendencelist">
                        <div class="box-header with-border">
                            <div class="row">


                                <div class="col-md-4 col-sm-4">
                                    <h3 class="box-title"><i class="fa fa-users"></i> <?php echo $this->lang->line('staff'); ?> <?php echo $this->lang->line('attendance'); ?> <?php echo $this->lang->line('report'); ?></h3>
                                </div>
                                <div class="col-md-8 col-sm-8">

                                    <div class="pull-right">
                                        <?php
                                        foreach ($attendencetypeslist as $key_type => $value_type) {
                                        ?>
                                            &nbsp;&nbsp;
                                            <b>
                                                <?php
                                                $att_type = str_replace(" ", "_", strtolower($value_type['type']));
                                                echo $this->lang->line($att_type) . ": " . $value_type['key_value'] . "";
                                                ?>
                                            </b>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped table-bordered table-hover examplereportatt">
                                <thead>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Designation</th>
                                    <?php foreach ($days as $day => $date) {
                                    ?>
                                        <th class="text-center <?php if (date('w', strtotime($date)) == 0) {
                                                                    echo "bg-danger";
                                                                } ?>"><?php echo date('d', strtotime($date)) ?></th>

                                    <?php } ?>
                                </thead>
                                <tbody>
                                    <?php foreach ($staff as $index => $row) { ?>

                                        <tr>
                                            <td class="text-center"><?php echo $row['name']." ".$row['surname'] ?><br><?php echo $row['department_code'] ?></td>
                                            <td class="text-center"> <?php echo $row['designation'] ?><br><?php echo date('d-m-Y', strtotime($row['date_of_joining'])) ?></td>

                                            <?php foreach ($attendance[$index] as $att) {
                                            ?>


                                                <td class="text-center <?php echo ($att['type'] == 'P') ? 'text-success' :$att['type'] == 'OD'? 'text-success':'text-danger'; ?>" style="cursor: pointer;">
                                                    <?php if(isset($att['updated'])) { ?>
                                                        <span
                                                            data-toggle="popover"
                                                            class="detail_popover"
                                                            data-original-title="Attendance Details"
                                                            data-content="Updated"
                                                            title="">
                                                            <?php echo ($att['type']); ?>
                                                        </span>
                                                          <span class="excel-print"> 
                                                            Updated
                                                            </span>

                                                <?php  }
                                                    else if ($att['type'] == 'P') { ?>
                                                        <span
                                                            data-toggle="popover"
                                                            class="detail_popover"
                                                            data-original-title="Attendance Details"
                                                            data-content="IN: <?php echo date('h:i:s A', strtotime($att['in']->LogDate)); ?> OUT: <?php echo date('h:i:s A', strtotime($att['out']->LogDate)); ?>"
                                                            title="">
                                                            <?php echo ($att['type']); ?>
                                                        </span>
                                                        <span class="excel-print"> 
                                                            IN: <?php echo date('h:i:s A', strtotime($att['in']->LogDate)); ?> OUT: <?php echo date('h:i:s A', strtotime($att['out']->LogDate)); ?>
                                                        </span>
                                                    <?php } else { ?>
                                                        <?php echo ($att['type']); ?>


                                                    <?php } ?>
                                                </td>


                                            <?php } ?>
                                        </tr>


                                    <?php } ?>
                                </tbody>

                            </table>
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
        $('#date').datepicker({
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

$(document).ready(function () {
     var table = $('.examplereportatt').DataTable({
            "aaSorting": [],
           
            rowReorder: {
            selector: 'td:nth-child(2)'
            },
            responsive: 'true',
            dom: "Bfrtip",
            buttons: [

                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-files-o"></i>',
                    titleAttr: 'Copy',
                    title: $('.download_label').html(),
                    exportOptions: {
                        // columns: 'th:not(:last-child)'
                    }
                },

                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                   
                    title: $('.download_label').html(),
                    exportOptions: {
                    //   columns: 'th:not(:last-child)'
                     format: {
                        body: function (data, row, column, node) {
                            // Strip $ from salary column to make it numeric
                            
                               if ($(node).find('.excel-print').length) {
                            // Export the content of the `excel-print` span
                            return $(node).find('.excel-print').text();
                        } else {
                            // Return other content normally
                            return $(node).text();
                        }
                            
                        }
                     
                    
                }
                    }
                },

                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-file-text-o"></i>',
                    titleAttr: 'CSV',
                    title: $('.download_label').html(),
                    exportOptions: {
                    //   columns: 'th:not(:last-child)'
                    }
                },

                

               

                
            ]
        });
})

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