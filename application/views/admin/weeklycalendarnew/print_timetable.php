<style type="text/css">
    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }
    }

    .print,
    .print * {
        display: none;
    }

    .page-break {
        page-break-before: always;
    }

    .tabledesign td {
        width: 30px;
        border-collapse: separate;
        /* Separate cell spacing */
        border-spacing: 5px;
        page-break-inside: avoid;
    }

    .tabledes td {
        width: 30px;
        height: 80px;
        text-align: center;
        border-collapse: separate;
        /* Separate cell spacing */
        border-spacing: 5px;
    }


    .div_pdf_footer_img {
        position: fixed;
        bottom: 0;
        width: 100%;
        /* page-break-before: always; */
    }
</style>

<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1><i class="fa fa-mortar-board"></i>
            <?php echo "Weekly Calendar" ?>
            <small>
                <?php echo $this->lang->line('student_fees1'); ?>
            </small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-search"></i>
                            <?php echo $this->lang->line('select_criteria'); ?>
                        </h3>
                    </div>

                    <form action="<?php echo site_url('admin/weeklycalendarnew/printtimetable') ?>" method="post"
                        accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <?php echo $this->lang->line('class'); ?>
                                        </label><small class="req"> *</small>
                                        <select autofocus="" id="class_id" name="class_id" class="form-control">
                                            <option value="">
                                                <?php echo $this->lang->line('select'); ?>
                                            </option>
                                            <?php foreach ($classlist as $class) { ?>
                                                <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id'])
                                                                                                echo "selected=selected"; ?>>
                                                    <?php echo $class['class'] ?>
                                                </option>
                                            <?php $count++;
                                            } ?>
                                        </select>
                                        <span class="text-danger">
                                            <?php echo form_error('class_id'); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <?php echo $this->lang->line('section'); ?>
                                        </label><small class="req"> *</small>
                                        <select id="section_id" name="section_id" class="form-control">
                                            <option value="">
                                                <?php echo $this->lang->line('select'); ?>
                                            </option>
                                        </select>
                                        <span class="text-danger">
                                            <?php echo form_error('section_id'); ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <?php echo "From " . $this->lang->line('date'); ?>
                                        </label>
                                        <input name="from_date" id='month_id' type="text" class="form-control date-picker"
                                            value="<?php echo date('d-m-Y') ?>" />
                                        <span class="text-danger">
                                            <?php echo form_error('date'); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">
                                            <?php echo "To " . $this->lang->line('date'); ?>
                                        </label>
                                        <input name="to_date" id='month_id' type="text" class="form-control date-picker"
                                            value="<?php echo date('d-m-Y') ?>" />
                                        <span class="text-danger">
                                            <?php echo form_error('date'); ?>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right btn-sm"><i class="fa fa-search"></i>
                                <?php echo $this->lang->line('search'); ?>
                            </button>
                        </div>
                    </form>
                </div>
                <?php if ($result) { ?>
                    <div class="box box-primary">
                        <h3 class="titless pull-left"><i class="fa fa-money"></i>
                            <?php
                            echo "Weekly Report";

                            ?>

                        </h3>

                        <button type="button" style="margin-right: 10px; margin-top: 10px;" name="search"
                            id="collection_print"
                            data-class="collection_report"
                            class="btn btn-sm btn-primary login-submit-cs fa fa-print pull-right">
                            Print View
                        </button>



                        <div class="box-body" id="collection_report">

                            <div class="row">

                                <div class="col-md-12 ">
                                    <!-- header  -->
                                    <div class="box-header print with-border">
                                        <div class="row">

                                            <div>
                                                <!-- <img src="<?php echo base_url(); ?>\uploads\header.png" alt="Header Image" style="width: 100%;">                                              -->
                                            </div>

                                        </div>

                                    </div>
                                    <!-- #region -->
                                    <div id='printcontent' >
                                        <div>
                                            <p style="margin: 0;padding-top:50px"><span>Programme And Batch: </span><b> <?php echo "$class_name $section_name" ?></b></p>
                                            <div>
                                                <div style="width: 100%; overflow-x: auto;margin-top: 1rem;">



                                                    <table class="tabledes" style="width:100%; table-layout: fixed;" border="1" h>

                                                        <h4 style="text-align:center"> Week: <?php echo $date ?></h4>
                                                        <thead>
                                                            <tr >
                                                                <td style="text-align:center">Date</td>
                                                                <td style="text-align:center">I<sup>st</sup>Period <br><?php echo $periodTiming['period_one_from'] ?>-<br><?php echo $periodTiming['period_one_to'] ?></td>
                                                                <td style="text-align:center">II<sup>nd</sup>Period<br><?php echo $periodTiming['period_two_from'] ?>-<br><?php echo $periodTiming['period_two_to'] ?></td>
                                                                <td style="text-align:center">III<sup>rd</sup>Period<br><?php echo $periodTiming['period_three_from'] ?>-<br><?php echo $periodTiming['period_three_to'] ?></td>
                                                                <td style="text-align:center">IV<sup>th</sup>Period<br><?php echo $periodTiming['period_four_from'] ?>-<br><?php echo $periodTiming['period_four_to'] ?></td>
                                                                <td style="text-align:center">V<sup>th</sup>Period<br><?php echo $periodTiming['period_five_from'] ?>-<br><?php echo $periodTiming['period_five_to'] ?></td>
                                                                <td style="text-align:center">VI<sup>th</sup>Period<br><?php echo $periodTiming['period_six_from'] ?>-<br><?php echo $periodTiming['period_six_to'] ?></td>
                                                                <td style="text-align:center">VII<sup>th</sup>Period<br><?php echo $periodTiming['period_seven_from'] ?>-<br><?php echo $periodTiming['period_seven_to'] ?></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($result as $row) {
                                                                
                                                            ?>
                                                                <tr >
                                                                    <?php $date = $daysvalue[$day]; // Date in DD/MM/YYYY format
                                                                            $timestamp = DateTime::createFromFormat('d/m/Y', $row['date'])->getTimestamp(); ?>
                                                                    <td style="text-align:center"><?php echo date('d/m/Y', $timestamp)."<br>(". date('l', $timestamp).")" ?></td>
                                                                    
                                                                    <?php if ($row['eight_to_nine_activity']) {
                                                                    ?>
                                                                        <td><?php echo $row['eight_to_nine_activity'] ?><br>
                                                                        <!--<?php echo getperiodtime($row['period_id'], 'period_one') ?></td>-->
                                                                    <?php
                                                                    } else { ?>
                                                                        <td style="text-align:center"><?php echo getsubjectname($row['eight_to_nine_subject']) ?><br>
                                                                        <!--<?php echo getteacheranme($row['eight_to_nine_teacher'])[0]->name ?>-->
                                                                            <!-- <br><?php echo getperiodreport($row['id'], 'eight_to_nine') ?> -->
                                                                            <!--<br><?php echo getperiodtime($row['period_id'], 'period_one') ?>-->
                                                                        </td>
                                                                    <?php } ?>

                                                                    <?php if ($row['nine_to_ten_activity']) {
                                                                    ?>
                                                                        <td style="text-align:center"><?php echo $row['nine_to_ten_activity'] ?><br>
                                                                        <!--<?php echo getperiodtime($row['period_id'], 'period_two') ?></td>-->
                                                                    <?php
                                                                    } else { ?>
                                                                        <td><?php echo getsubjectname($row['nine_to_ten_subject']) ?><br><?php echo getteacheranme($row['nine_to_ten_teacher'])[0]->name ?>
                                                                            <!-- <br><?php echo getperiodreport($row['id'], 'nine_to_ten') ?> -->
                                                                            <!--<br><?php echo getperiodtime($row['period_id'], 'period_two') ?>-->
                                                                        </td>
                                                                    <?php } ?>
                                                                    <?php if ($row['ten_to_eleven_activity']) {
                                                                    ?>
                                                                        <td style="text-align:center"><?php echo $row['ten_to_eleven_activity'] ?><br>
                                                                        <!--<?php echo getperiodtime($row['period_id'], 'period_three') ?></td>-->
                                                                    <?php
                                                                    } else { ?>
                                                                        <td><?php echo getsubjectname($row['ten_to_eleven_subject']) ?><br>
                                                                            <!-- <br><?php echo getperiodreport($row['id'], 'ten_to_eleven') ?> -->
                                                                            <!--<br><?php echo getperiodtime($row['period_id'], 'period_three') ?>-->
                                                                        </td>
                                                                    <?php } ?>
                                                                    <?php if ($row['eleven_to_twelve_activity']) {
                                                                    ?>
                                                                        <td style="text-align:center"><?php echo $row['eleven_to_twelve_activity'] ?><br>
                                                                        <!--<?php echo getperiodtime($row['period_id'], 'period_four') ?></td>-->
                                                                    <?php
                                                                    } else { ?>
                                                                        <td style="text-align:center"><?php echo getsubjectname($row['eleven_to_twelve_subject']) ?><br>
                                                                        <!--<?php echo getteacheranme($row['eleven_to_twelve_teacher'])[0]->name ?>-->
                                                                            <!-- <br><?php echo getperiodreport($row['id'], 'eleven_to_twelve') ?> -->
                                                                            <!--<br><?php echo getperiodtime($row['period_id'], 'period_four') ?>-->
                                                                        </td>
                                                                    <?php } ?>
                                                                    <?php if ($row['twelve_to_one_activity']) {
                                                                    ?>
                                                                        <td style="text-align:center"><?php echo $row['twelve_to_one_activity'] ?><br>
                                                                        <!--<?php echo getperiodtime($row['period_id'], 'period_five') ?></td>-->
                                                                    <?php
                                                                    } else { ?>
                                                                        <td style="text-align:center"><?php echo getsubjectname($row['twelve_to_one_subject']) ?><br>3
                                                                        <!--<?php echo getteacheranme($row['twelve_to_one_teacher'])[0]->name ?>-->
                                                                            <!-- <br><?php echo getperiodreport($row['id'], 'twelve_to_one') ?> -->
                                                                            <!--<br><?php echo getperiodtime($row['period_id'], 'period_five') ?>-->
                                                                        </td>
                                                                    <?php } ?>
                                                                    <?php if ($row['two_to_three_activity']) {
                                                                    ?>
                                                                        <td style="text-align:center"><?php echo $row['two_to_three_activity'] ?>
                                                                            <!--<br><?php echo getperiodtime($row['period_id'], 'period_six') ?>-->
                                                                        </td>
                                                                    <?php
                                                                    } else { ?>
                                                                        <td style="text-align:center"><?php echo getsubjectname($row['two_to_three_subject']) ?><br>
                                                                        <!--<?php echo getteacheranme($row['two_to_three_teacher'])[0]->name ?>-->
                                                                            <!-- <br><?php echo getperiodreport($row['id'], 'two_to_three') ?> -->
                                                                            <!--<br><?php echo getperiodtime($row['period_id'], 'period_six') ?>-->
                                                                        </td>
                                                                    <?php } ?>
                                                                    <?php if ($row['three_to_four_activity']) {
                                                                    ?>
                                                                        <td style="text-align:center"><?php echo $row['three_to_four_activity'] ?><br>
                                                                        <!--<?php echo getperiodtime($row['period_id'], 'period_seven') ?></td>-->
                                                                    <?php
                                                                    } else { ?>
                                                                        <td style="text-align:center"><?php echo getsubjectname($row['three_to_four_subject']) ?><br><?php echo getteacheranme($row['three_to_four_teacher'])[0]->name ?>
                                                                            <!-- <br><?php echo getperiodreport($row['id'], 'three_to_four') ?> -->
                                                                            <!--<br><?php echo getperiodtime($row['period_id'], 'period_seven') ?>-->
                                                                        </td>
                                                                    <?php } ?>


















                                                                </tr>
                                                            <?php } ?>

                                                        </tbody>

                                                    </table>

                                                </div>


                                            </div>

                                            <table style="width:100%;margin-top:50px">
                                                <tr>
                                                    <td>Signature Class Coordinator</td>
                                                
                                                    <td style="text-align: right;">Signature Principal</td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                            <?php } ?>
                            </div>


    </section>
</div>




<?php

function getdateformat($date)
{

    $date_string = $date;
    $date_format = 'd/m/Y';
    $dateformat = DateTime::createFromFormat($date_format, $date_string);
    return $dateformat->format('l') . ' (' . $dateformat->format('d/m/Y') . ')';
}
function getDateWithoutDay($date)
{
    $date_format = 'd/m/Y';
    $dateformat = DateTime::createFromFormat($date_format, $date);
    return $dateformat->format('d/m/Y');
}



?>


<script type="text/javascript">
    $(document).on('ready', function() {
        $(function() {

            $(".date-picker").datepicker({
                format: "dd-mm-yyyy",
            })


        });

    });

    function getSectionByClass(class_id, section_id) {
        if (class_id != "" && section_id != "") {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {
                    'class_id': class_id
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {
                        var sel = "";
                        if (section_id == obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section +
                            "</option>";
                    });

                    $('#section_id').append(div_data);
                }
            });
        }
    }
    $(document).ready(function() {
        $(document).on('change', '#class_id', function(e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {
                    'class_id': class_id
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {
                        div_data += "<option value=" + obj.section_id + ">" + obj
                            .section + "</option>";
                    });

                    $('#section_id').append(div_data);
                }
            });
        });
        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id') ?>';
        getSectionByClass(class_id, section_id);
        $(document).on('change', '#feecategory_id', function(e) {
            $('#feetype_id').html("");
            var feecategory_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "feemaster/getByFeecategory",
                data: {
                    'feecategory_id': feecategory_id
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {
                        div_data += "<option value=" + obj.id + ">" + obj.type +
                            "</option>";
                    });

                    $('#feetype_id').append(div_data);
                }
            });
        });
    });

    $(document).on('change', '#section_id', function(e) {
        $("form#schedule-form").submit();
    });
</script>

<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';

    function printDiv(elem) {
        var cls = $("#class_id option:selected").text();
        var sec = $("#section_id option:selected").text();
        $('.cls').html(cls + '(' + sec + ')');
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
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0]
            .contentDocument.document : frame1[0].contentDocument;
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


        frameDoc.document.write('<link rel="stylesheet" href="' + base_url +
            'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url +
            'backend/plugins/datepicker/datepicker3.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url +
            'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
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


<!-- <script type="text/javascript">
   $(document).on('click', '#collection_print', function () {
    var printContents = '<link rel="stylesheet" type="text/css" href="print.css" media="print">' + document.getElementById('collection_report').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
});


     
</script>  -->


<script>
    // function redirectToPrintPage() {
    //     window.location.href = 'http://localhost/caritas/admin/weeklycalendarnew/index2';
    // }
</script>

<script type="text/javascript">
    $(document).on('click', '#collection_print', function() {

        // Get the class value from the data attribute of the button
        let content = $('#printcontent').html();
        content = btoa(content);
        // Make an AJAX request to the 'printwithheaderandfooter' method
        $.ajax({
            url: '<?php echo base_url('admin/weeklycalendarnew/printwithheaderandfooterLandscape'); ?>',
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