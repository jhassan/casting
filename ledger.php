<!DOCTYPE html>
<html lang="en">
<!-- include head section -->
<?php include_once('include/head.php') ?>
<body>
    <div id="wrapper">
        <!-- include left side bar -->
        <?php include_once('include/left_sidebar.php') ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">General Ledger</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            General Ledger
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12 p-0">
                                    <form role="form" name="myForm" id="AdvanceGoldForm" method="get" action="">
                                            <div class="form-group col-lg-3 p-0">
                                                <label>Date From</label>
                                                <input class="form-control date_picker" placeholder="Date From" name="date_from" required>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Date To</label>
                                                <input class="form-control date_picker" placeholder="Date To" name="date_to">
                                            </div>
                                            <div class="form-group col-lg-3">
                                            <label>All Clients</label>
                                            <select class="form-control" id="all_client" name="all_client"  required>
                                                <option value="">Select Client</option>
                                                <?php
                                                $SQL = "SELECT client_name, client_id 
                                                        FROM tbl_clients 
                                                        GROUP BY tbl_clients.client_id
                                                        ORDER BY client_name DESC"; 
                                                        //echo $SQL;          
                                                 $result = MySQLQuery($SQL);
                                                 while($row = mysqli_fetch_array($result)) { // ,MYSQL_ASSOC
                                                ?>
                                                <option value="<?php echo $row['client_id']; ?>" <?php if($row['client_id'] == $_GET['all_client']) echo 'selected="selected"'  ?>><?php echo $row['client_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                           </div>
                                        <div class="form-group col-lg-2 m-t-25">
                                            <input class="btn btn-default" id="btn" type="submit" value="Search">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                            <?php if(!empty($_GET['date_from']) && !empty($_GET['date_to']) && !empty($_GET['all_client'])) { 
                                $date_from = $_GET['date_from'];
                                $date_to = $_GET['date_to'];
                                $client_id = $_GET['all_client'];
                                $client_name = GetClientName($client_id);
                                $coa_code = GetCOA($client_id, 'c');
                                // Get Opening Balance
                                $op_sql = "SELECT  (SUM(`coa_credit`+`coa_debit`) + SUM(debit_gold)) - SUM(credit_gold) AS OpeningBalace FROM `tbl_casting` 
                                            JOIN `tbl_debit_credit_gold` ON `tbl_debit_credit_gold`.`casting_id` = `tbl_casting`.`casting_id`
                                            JOIN `tbl_coa` ON tbl_coa.`coa_code` = `tbl_debit_credit_gold`.`coa_code`
                                            WHERE tbl_casting.`date` < '".$date_from."' AND tbl_debit_credit_gold.`coa_code` = '".$coa_code."'";
                                            //echo $op_sql; die;
                                $op_result = MySQLQuery($op_sql);
                                $op_row = mysqli_fetch_array($op_result); // ,MYSQL_ASSOC  
                                $op_balance = $op_row['OpeningBalace'];
                                if(empty($op_balance))
                                {
                                    $where = " coa_code = '".$coa_code."' AND coa_type = 'c'";
                                    $row = GetRecord("tbl_coa", $where);
                                    $coa_credit = $row['coa_credit'];
                                    $coa_debit = $row['coa_debit'];
                                    if($coa_credit != 0)
                                    {
                                      $op_balance = $coa_credit;
                                      $account_type = "Cr";  
                                    }
                                    else
                                      {
                                        $op_balance = $coa_debit;
                                        $account_type = "Dr";
                                      }         
                                }          
                                ?>
                            <div class="table-responsive" style="overflow-x:hidden !important;">
                                <table width="100%" class="table table-bordered table-hover" id="example2">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" width="25%" valign="top" align="left"><strong><?php echo $client_name; ?></strong></td>
                                      <td width="11%"><strong>Date From</strong></td>
                                      <td width="14%" align="left"><?php echo date("d-M-Y", strtotime($date_from)); ?></td>
                                      <td width="8%" align="left"><strong>Date To</strong></td>
                                      <td width="13%"><?php echo date("d-M-Y", strtotime($date_to)); ?></td>
                                    </tr>
                                    <tr class="hide">
                                      <td colspan="2">&nbsp;</td>
                                      <td colspan="3"><strong>Opening Balance</strong></td>
                                      <td><?php echo number_format($op_balance,3); ?><strong style="padding-left:10px">(<?php echo $account_type;?>)</strong></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table width="100%" class="table table-bordered table-hover" id="heading_div">
                                  <tbody>

                                    <tr>
                                      <td width="10%" align="center"><b>Date</b></td>
                                      <td width="40%" align="center"><b>Details</b></td>
                                      <td width="10%" align="center"><b>Debit</b></td>
                                      <td width="10%" align="center"><b>Credit</b></td>
                                      <td width="10%" align="center"><b>Balance</b></td>
                                    </tr>
                                    <?php
                                    $op_balance = 0;
                                    $total_balance = 0;
                                    $total_debit = 0;
                                    $total_credit = 0;
                                    $SQL = "SELECT tbl_casting.date, tbl_debit_credit_gold.* 
                                                    FROM tbl_casting 
                                                    INNER JOIN tbl_debit_credit_gold ON tbl_debit_credit_gold.casting_id = tbl_casting.casting_id
                                                    INNER JOIN tbl_coa ON tbl_coa.coa_code = tbl_debit_credit_gold.coa_code
                                                    WHERE tbl_coa.coa_code = '".$coa_code."' AND `date` >= '".$date_from."' AND `date` <= '".$date_to."'
                                                    ORDER BY tbl_casting.casting_id DESC"; 
                                             $result = MySQLQuery($SQL);
                                             while($row = mysqli_fetch_array($result)) { // ,MYSQL_ASSOC
                                             $total_balance += $op_balance + ($row['debit_gold'] - $row['credit_gold']);  
                                              // if($account_type == "Dr")  
                                              //   $total_balance += $op_balance + ($row['debit_gold'] - $row['credit_gold']); 
                                              // else
                                              //   $total_balance += $op_balance + ($row['debit_gold'] - $row['credit_gold']);       
                                              $total_debit += $row['debit_gold'];
                                              $total_credit += $row['credit_gold'];             
                                    ?>
                                        <tr>
                                            <td align="center"><?php echo date("m/d/Y", strtotime($row['date'],3)) ?></td>      
                                            <td><?php echo $row['desc']; ?></td>        
                                            <td align="right"><?php echo number_format($row['debit_gold'],3); ?></td>       
                                            <td align="right"><?php echo number_format($row['credit_gold'],3); ?></td>        
                                            <td align="right"><?php echo number_format($total_balance,3); ?></td>  
                                        </tr> 
                                    <?php } ?>      
                                        <tr>        
                                            <td colspan="2" align="right"><strong>Total</strong></td>
                                            <td align="right"><strong><?php echo number_format($total_debit,3);?></strong></td>
                                            <td align="right"><strong><?php echo number_format($total_credit,3);?></strong></td>
                                            <td align="right"><strong><?php echo number_format($total_balance,3);?></strong></td>
                                        </tr>
                                        </tbody>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <link rel="stylesheet" href="js/jquery-ui.css">
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="js/jquery-ui.js"></script>


    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
        //$( ".date_picker" ).datepicker();
         var dateToday = new Date(); 

         $( ".date_picker" ).datepicker({ dateFormat: 'yy-mm-dd' }).datepicker("setDate",new Date());
    });    
    </script>
</body>
</html>
