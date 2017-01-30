<!DOCTYPE html>
<html lang="en">
<!-- include head section -->
<?php include_once('include/head.php');
include_once('include/functions.php'); ?>
<body>
    <div id="wrapper">
        <!-- include left side bar -->
        <?php include_once('include/left_sidebar.php') ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Today Report</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Today Report
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive" style="overflow-x:hidden !important;">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Client Name</th>
                                            <th>Caret Type</th>
                                            <th>Casting Weight</th>
                                            <th>KAT</th>
                                            <th>Mix Iron</th>
                                            <th>Pure Gold</th>
                                            <th>Laboure Fee Gold</th>
                                            <th>Remain Gold</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $date = date("Y-m-d");
                                        $SQL = "SELECT tbl_casting.*,client_name
                                                FROM `tbl_casting` 
                                                INNER JOIN `tbl_clients` ON `tbl_clients`.`client_id` = `tbl_casting`.`client_id`
                                                WHERE tbl_casting.date_created LIKE '%$date%'
                                                ORDER BY tbl_casting.`casting_id` DESC";
                                         $result = MySQLQuery($SQL);
                                         while($row = mysqli_fetch_array($result)) { // ,MYSQL_ASSOC
                                        ?>
                                        <tr>
                                            <td><?php echo date("d/m/Y",strtotime($row['date_created'])); ?></td>
                                            <td><?php echo $row['client_name']; ?></td>
                                            <td class="text-center"><?php echo $row['caret_type']; ?></td>
                                            <td class="text-center"><?php echo $row['casting_weight']; ?></td>
                                            <td class="text-center"><?php echo $row['gold_cut']; ?></td>
                                            <td class="text-center"><?php echo $row['mix_iron']; ?></td>
                                            <td class="text-center"><?php echo $row['pure_gold']; ?></td>
                                            <td class="text-center"><?php echo $row['casting_labour_fee_gold']; ?></td>
                                            <td class="text-center"><?php echo $row['remaining_gold']; ?></td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                    <div class="clear"></div>
                                        <?php
                                        $date = date("Y-m-d");
                                        $SQL = "SELECT SUM(casting_weight) AS casting_weight,SUM(gold_cut) AS gold_cut,SUM(mix_iron) AS mix_iron,SUM(pure_gold) AS pure_gold,
                                                SUM(casting_labour_fee_gold) AS casting_labour_fee_gold,SUM(remaining_gold) AS remaining_gold
                                                FROM `tbl_casting` 
                                                WHERE tbl_casting.date_created LIKE '%$date%'
                                                ORDER BY tbl_casting.`casting_id` DESC";
                                         $result = MySQLQuery($SQL);
                                         $row = mysqli_fetch_array($result);
                                        ?>
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><?php echo $row['casting_weight']; ?></th>
                                            <th><?php echo $row['gold_cut']; ?></th>
                                            <th><?php echo $row['mix_iron']; ?></th>
                                            <th><?php echo $row['pure_gold']; ?></th>
                                            <th><?php echo $row['casting_labour_fee_gold']; ?></th>
                                            <th><?php echo $row['remaining_gold']; ?></th>
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
    
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>

</body>

</html>
