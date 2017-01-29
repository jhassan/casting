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
                    <h1 class="page-header">Today Gold Rate</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row Main Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Today Gold Rate
                        </div>
                        <div class="alert alert-success" style="margin:15px; display:none;" id="msgAdvanceGoldSuccess"> Advance/Debit Gold added successfully!</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" name="myForm" id="TodayGoldRateForm" method="post" onsubmit="return false;">
                                        <div class="form-group col-lg-6">
                                            <label>Add Today Gold Rate</label>
                                            <input maxlength="8" class="form-control number_only" placeholder="Add Today Gold Rate" name="today_gold_rate" type="number" required>
                                        </div>
                                         <div class="clear"></div>   
                                        <div class="form-group col-lg-4">
                                            <input class="btn btn-default" id="btn" type="submit" value="Save">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group col-lg-6">
                                        <?php
                                        $rowRate = GetRecord("tbl_today_gold_rate", '');
                                        ?>
                                        <label>Today Gold Rate: <?php if(!empty($rowRate)) echo number_format($rowRate['today_rate']); ?></label>
                                    </div>
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
        $("#btn").click(function () {
            //Hide all other elements other than printarea.
            event.preventDefault();
            $.ajax({
                url:'action.php?action=TodayGoldRate',
                type:'POST',
                data:$("#TodayGoldRateForm").serialize(),
                success:function(response){
                    //console.log(response); return false;
                    window.location.href = 'today_rate';
                }
            });
        });
    });
    </script>
</body>

</html>