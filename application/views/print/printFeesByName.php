<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<style type="text/css">
    @media print {
        .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
            float: left;
        }
        .col-sm-12 {
            width: 100%;
        }
        .col-sm-11 {
            width: 91.66666667%;
        }
        .col-sm-10 {
            width: 83.33333333%;
        }
        .col-sm-9 {
            width: 75%;
        }
        .col-sm-8 {
            width: 66.66666667%;
        }
        .col-sm-7 {
            width: 58.33333333%;
        }
        .col-sm-6 {
            width: 50%;
        }
        .col-sm-5 {
            width: 41.66666667%;
        }
        .col-sm-4 {
            width: 33.33333333%;
        }
        .col-sm-3 {
            width: 25%;
        }
        .col-sm-2 {
            width: 16.66666667%;
        }
        .col-sm-1 {
            width: 8.33333333%;
        }
        .col-sm-pull-12 {
            right: 100%;
        }
        .col-sm-pull-11 {
            right: 91.66666667%;
        }
        .col-sm-pull-10 {
            right: 83.33333333%;
        }
        .col-sm-pull-9 {
            right: 75%;
        }
        .col-sm-pull-8 {
            right: 66.66666667%;
        }
        .col-sm-pull-7 {
            right: 58.33333333%;
        }
        .col-sm-pull-6 {
            right: 50%;
        }
        .col-sm-pull-5 {
            right: 41.66666667%;
        }
        .col-sm-pull-4 {
            right: 33.33333333%;
        }
        .col-sm-pull-3 {
            right: 25%;
        }
        .col-sm-pull-2 {
            right: 16.66666667%;
        }
        .col-sm-pull-1 {
            right: 8.33333333%;
        }
        .col-sm-pull-0 {
            right: auto;
        }
        .col-sm-push-12 {
            left: 100%;
        }
        .col-sm-push-11 {
            left: 91.66666667%;
        }
        .col-sm-push-10 {
            left: 83.33333333%;
        }
        .col-sm-push-9 {
            left: 75%;
        }
        .col-sm-push-8 {
            left: 66.66666667%;
        }
        .col-sm-push-7 {
            left: 58.33333333%;
        }
        .col-sm-push-6 {
            left: 50%;
        }
        .col-sm-push-5 {
            left: 41.66666667%;
        }
        .col-sm-push-4 {
            left: 33.33333333%;
        }
        .col-sm-push-3 {
            left: 25%;
        }
        .col-sm-push-2 {
            left: 16.66666667%;
        }
        .col-sm-push-1 {
            left: 8.33333333%;
        }
        .col-sm-push-0 {
            left: auto;
        }
        .col-sm-offset-12 {
            margin-left: 100%;
        }
        .col-sm-offset-11 {
            margin-left: 91.66666667%;
        }
        .col-sm-offset-10 {
            margin-left: 83.33333333%;
        }
        .col-sm-offset-9 {
            margin-left: 75%;
        }
        .col-sm-offset-8 {
            margin-left: 66.66666667%;
        }
        .col-sm-offset-7 {
            margin-left: 58.33333333%;
        }
        .col-sm-offset-6 {
            margin-left: 50%;
        }
        .col-sm-offset-5 {
            margin-left: 41.66666667%;
        }
        .col-sm-offset-4 {
            margin-left: 33.33333333%;
        }
        .col-sm-offset-3 {
            margin-left: 25%;
        }
        .col-sm-offset-2 {
            margin-left: 16.66666667%;
        }
        .col-sm-offset-1 {
            margin-left: 8.33333333%;
        }
        .col-sm-offset-0 {
            margin-left: 0%;
        }
        .visible-xs {
            display: none !important;
        }
        .hidden-xs {
            display: block !important;
        }
        table.hidden-xs {
            display: table;
        }
        tr.hidden-xs {
            display: table-row !important;
        }
        th.hidden-xs,
        td.hidden-xs {
            display: table-cell !important;
        }
        .hidden-xs.hidden-print {
            display: none !important;
        }
        .hidden-sm {
            display: none !important;
        }
        .visible-sm {
            display: block !important;
        }
        table.visible-sm {
            display: table;
        }
        tr.visible-sm {
            display: table-row !important;
        }
        th.visible-sm,
        td.visible-sm {
            display: table-cell !important;
        }
    }
</style>

<html lang="en">
    <head>
        <title><?php echo $this->lang->line('fees_receipt'); ?></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/bootstrap/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/AdminLTE.min.css">
    </head>
    <body>       
        <div class="container">
            <div class="row">
                <div id="content" class="col-lg-12 col-sm-12 ">
                    <div class="invoice">
                        <div class="row header text-center" style="margin-top:30px;">
                            <div class="col-sm-2">
                                <?php
                                if ($settinglist[0]['image'] != "") {
                                    ?>

                                    <img style="height:70px; " src="<?php echo base_url(); ?>/uploads/school_content/logo/<?php echo $settinglist[0]['image']; ?>">
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="col-sm-8">

                                <strong style="font-size: 20px;"><?php echo strtoupper ($settinglist[0]['name']); ?><br>
                          <?php echo strtoupper ($settinglist[0]['address']); ?></strong>
<!--   Email: <?php echo $settinglist[0]['email']; ?> <br> -->
                                

                            </div><!--/col-->
                        </div>
                        <div class="row">                           
                            <div class="col-xs-5">
                                <br/>
                               <label style="font-size:20px">No.---</label>
                            </div>
                            
                             <div class="col-xs-4">
                                <br/>
                              <label style="font-size:20px">RECEIPT</label>
                            </div>
                            
                             <div class="col-xs-3">
                                <br/>
                             <label style="font-size:20px">DATE: <?php $date= date('d-m-Y');  echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($date)); ?></label>
                            </div>
                            
                            <!--<div class="col-xs-6 text-right">
                                <br/>
                                <address>
                                    <strong>Date: <?php
                                        //$date = date('d-m-Y');

                                        //echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($date));
                                        ?></strong><br/>
                                    <strong> <?php //echo $this->lang->line('payment_id'); ?>:  <?php //echo  $sub_invoice_id; ?></strong>
                                </address>                               
                            </div>-->
                        </div>
                        <!--<hr style="margin-top: 0px;margin-bottom: 0px;" />-->
                        <div class="row" >
                            <?php
                            if (!empty($feeList)) {
								
								$amount=json_decode($feeList->amount_detail);
								
							 
								$total_amount=0;
								foreach($amount as $am)
								{
								$total_amount=$total_amount + $am->amount;
								$date=$am->date;
								$paymentid=$am->inv_no;	
								}
								
								
                                ?>
                                 <div class="col-xs-12" style="margin-top:25px;">
                                 
                          
                                 <p style="font-size:25px;line-height:45px;"> Received with thanks from &nbsp <?php echo strtoupper($feeList->firstname.' '.$feeList->lastname); ?> &nbsp&nbsp  sum of rupees  <?php echo  $total_amount ?>&nbsp being payment of &nbsp&nbsp <?php echo $feeList->type  ?> . &nbsp&nbsp cash/cheque/transfer <br/>
  </p>                    </div>  
          <div class="col-xs-6" >
           <br/>                      
         <strong style="font-size:20px;">  Ref.no: <?php echo $paymentid ?></strong>  
         </div>
                                 
                                 
   <div class="col-xs-6 text-right" >
   <br/>
  <strong style="font-size:20px;"> Dated: <?php echo $date ?> </strong>
  </div>
 </div>
  <br/>                               
<strong style="font-size:20px;">Received by............</strong>
<div class="col-xs-12 text-right">

<strong style="font-size:20px;">for............<br><?php echo $settinglist[0]['name']; ?></strong>

</div>





                                 
                                 
                              
                                 
                                 
                                <!--<table style="border-left: 1px solid; border-bottom: 1px solid; border-right: 1px solid; border-top: 1px solid;" width="100%">
                                    <thead style="border-bottom: 1px solid;">
                                        <tr style="height:25px;">

                                            <th><?php echo $this->lang->line('date'); ?></th>

                                          
                                            <th><?php echo $this->lang->line('fee_type'); ?></th>
                                            <th><?php echo $this->lang->line('mode'); ?></th>
                                            <th class="text text-right"><?php echo $this->lang->line('amount'); ?></th>
                                            <th class="text text-right"><?php echo $this->lang->line('discount'); ?></th>
                                            <th class="text text-right"><?php echo $this->lang->line('fine'); ?></th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $amount = 0;
                                        $discount = 0;
                                        $fine = 0;
                                        $total = 0;
                                        $grd_total = 0;
                                        if (empty($feeList)) {
                                            ?>
                                            <tr >
                                                <td colspan="11" class="text-danger text-center">
                                                    <?php echo $this->lang->line('no_transaction_found'); ?>
                                                </td>
                                            </tr>
                                            <?php
                                        } else {
                                            $count = 1;

                                            $a = json_decode($feeList->amount_detail);
                                            $record = $a->{$sub_invoice_id};
                                            ?>
                                            <tr style="height:50px;">

                                                <td>
                                                    <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($record->date)); ?>

                                                </td> 
 
                                                <td>
                                                    <?php echo $feeList->code; ?>
                                                </td>
                                                <td>
                                                    <?php echo $record->payment_mode; ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php
                                                    $amount = number_format($record->amount, 2, '.', '');
                                                    echo $currency_symbol . $amount;
                                                    ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php
                                                    $amount_discount = number_format($record->amount_discount, 2, '.', '');
                                                    echo $currency_symbol . $amount_discount;
                                                    ?>
                                                </td>
                                                <td class="text text-right">
                                                    <?php
                                                    $amount_fine = number_format($record->amount_fine, 2, '.', '');
                                                    echo $currency_symbol . $amount_fine;
                                                    ?>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>-->
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>  
            </div>
        </div>
        <div class="clearfix"></div>
        <footer>           
        </footer>
    </body>
</html>
