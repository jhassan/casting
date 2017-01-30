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
                    <h1 class="page-header">Gold Debit/Credit</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Gold Debit/Credit
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive" style="overflow-x:hidden !important;">
                                Search:<input ng-model="search" class="form-group" type="text" value=""/>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th class="text-center">Debit Gold</th>
                                            <th class="text-center">Credit Gold</th>
                                            <th class="text-center">Advance/Remaining Gold</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $SQL = "SELECT SUM(`debit_gold`) AS Debit, SUM(`credit_gold`) AS Credit,client_name,
                                                (SUM(`debit_gold`) - SUM(`credit_gold`)) AS AvailBalance
                                                FROM `tbl_coa` 
                                                INNER JOIN `tbl_debit_credit_gold` ON `tbl_debit_credit_gold`.`coa_code` = `tbl_coa`.`coa_code`
                                                INNER JOIN `tbl_clients` ON `tbl_clients`.`client_id` = `tbl_debit_credit_gold`.`client_id`
                                                WHERE `coa_type` = 'c'
                                                GROUP BY tbl_coa.`client_id`";
                                         $result = MySQLQuery($SQL);
                                         while($row = mysqli_fetch_array($result)) { // ,MYSQL_ASSOC
                                            if ($row['AvailBalance'] > 0) {
                                                
                                                $bg_color = "red"; 
                                                $color = "red";
                                            }
                                            else
                                            {
                                                $bg_color = "none";
                                                $color = "none";
                                            }
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $row['client_name']; ?></td>
                                            <td class="text-center"><?php echo $row['Debit']; ?></td>
                                            <td class="text-center"><?php echo $row['Credit']; ?></td>
                                            <td  class="text-center" style="font-weight: bold; color: <?php echo $color; ?>; font-size: 15px; "><?php echo $row['AvailBalance']; ?></td>
                                        </tr>
                                        <?php } ?>
                                        <?php
                                        $SQL = "SELECT SUM(`debit_gold`) AS Debit, SUM(`credit_gold`) AS Credit,
                                                (SUM(`debit_gold`) - SUM(`credit_gold`)) AS AvailBalance
                                                FROM `tbl_coa` 
                                                INNER JOIN `tbl_debit_credit_gold` ON `tbl_debit_credit_gold`.`coa_code` = `tbl_coa`.`coa_code`
                                                INNER JOIN `tbl_clients` ON `tbl_clients`.`client_id` = `tbl_debit_credit_gold`.`client_id`
                                                WHERE `coa_type` = 'c'";
                                         $result = MySQLQuery($SQL);
                                         $row = mysqli_fetch_array($result);
                                         if ($row['AvailBalance'] > 0) {
                                                
                                                $bg_color = "red"; 
                                                $color = "red";
                                            }
                                            else
                                            {
                                                $bg_color = "none";
                                                $color = "none";
                                            }
                                        ?>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-center"><?php echo $row['Debit']; ?></th>
                                            <th class="text-center"><?php echo $row['Credit']; ?></th>
                                            <th class="text-center" style="font-weight: bold; color: <?php echo $color; ?>; font-size: 15px; "><?php echo $row['AvailBalance']; ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

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
    });    
    </script>
</body>
</html>
