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
                    <h1 class="page-header">Advance Gold</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row Main Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                    <?php if($_GET['msg'] == "sent") {?>
                    <div class="alert alert-success">Client added successfully.</div>
                    <?php } ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Advance Gold
                        </div>
                        <div class="alert alert-success" style="margin:15px; display:none;" id="msgAdvanceGoldSuccess"> Advance/Debit Gold added successfully!</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" name="myForm" id="AdvanceGoldForm" method="post" onsubmit="return false;">
                                        <div class="form-group col-lg-2">
                                            <label class="checkbox-inline">
                                                <input id="new_client" name="new_client" value="1" type="checkbox">Add new client
                                            </label>
                                        </div>
                                        <div id="UserDiv" style="display: none;">
                                            <div class="form-group col-lg-3">
                                                <label>Client Name</label>
                                                <input class="form-control" placeholder="Client Name" name="client_name" required>
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Shop Name</label>
                                                <input class="form-control" placeholder="Shop Name" name="shop_name">
                                            </div>
                                            <div class="form-group col-lg-3">
                                                <label>Phone</label>
                                                <input class="form-control" placeholder="Phone" name="phone">
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="form-group col-lg-3">
                                            <label>All Clients</label>
                                            <select class="form-control" id="all_client" name="all_client"  required>
                                                <option value="">Select Client</option>
                                                <?php
                                                $SQL = "SELECT * 
                                                        FROM tbl_clients 
                                                        ORDER BY client_name DESC"; 
                                                        //echo $SQL;          
                                                 $result = MySQLQuery($SQL);
                                                 while($row = mysqli_fetch_array($result)) { // ,MYSQL_ASSOC
                                                ?>
                                                <option value="<?php echo $row['client_id']; ?>"><?php echo $row['client_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                           </div>
                                        <div class="form-group col-lg-3">
                                            <label>Advance Gold</label>
                                            <input maxlength="8" class="form-control" placeholder="Advance Gold" name="advance_gold" type="number" required>
                                        </div>
                                         <div class="clear"></div>   
                                        <div class="form-group col-lg-4">
                                            <input class="btn btn-default" id="btn" type="submit" value="Save">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>	
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
    </div>    
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
    <script type="text/javascript">
    $(document).ready(function(){
        $("#new_client").click(function(){
            //$("#UserDiv").toggle();
            if ($(this).is(":checked")) {
              $("#all_client").prop("disabled", true);
              $("#UserDiv").toggle();
           } else {
              $("#all_client").prop("disabled", false);
              $("#UserDiv").toggle();  
           }
        });

        $("#btn").click(function () {
            //Hide all other elements other than printarea.
            event.preventDefault();

            $.ajax({
                url:'action.php?action=AddAdvance',
                type:'POST',
                data:$("#AdvanceGoldForm").serialize(),
                success:function(response){
                    //console.log(response); return false;
                    window.location.href = 'advance';
                }
            });
            //$("#DivPrint").show();
            //window.print();
        });
    });
    </script>
</body>

</html>