<!DOCTYPE html>
<html lang="en">
<!-- include head section -->
<?php include_once('include/head.php');
include_once('include/functions.php'); ?>
<body>
    <div id="wrapper">
        <!-- include left side bar -->
        <?php include_once('include/left_sidebar.php') ?>
        <form role="form" name="myForm" id="GoldCastingForm" onsubmit="return false;">
          <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12" id="headin_div">
                    <h2 class="page-header">Ghouri Brother Casting Center</h2>
                    <div class="col-lg-4" style="text-align:left; padding-left:0px;"><b>Proprietor:</b></div>
                    <div class="clear"></div>
                    <h5><b>Sajjad Ghouri Tel: 0307-7700695</b></h5>
                    <h5><b>Akhtar Ghouri Tel: 0333-6107765</b></h5>
                    <h5><b>Shop Tel: +92-61-4506708</b></h5>
                    <div class="clear"></div>
                    <h5><b>Sarafa Bazar Opposite Darbar Mosa Pak, Near Ghouri Gold Laboratory Multan.</b></h5>
                    <br />
                    <h5><b>Date: <?php echo date('m-d-Y');?></b></h5>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row" id="main_top_div">
                <div class="col-lg-12">
                    <div class="panel panel-default scrolling_div" id="main_div">
                        <div class="panel-heading no-print">
                            Gold Casting
                            <?php $rowRate = GetRecord("tbl_today_gold_rate", ''); ?>
                            <label class="pull-right">Today Gold Rate: <?php if(!empty($rowRate)) echo number_format($rowRate['today_rate']); ?></label>
                        </div>
                        <div class="alert alert-success hide" id="show_message" style="margin:15px;"> Gold Casting added successfully!</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12" id="inner_div">
                                    

                                        <div class="form-group col-lg-3 no-print">
                                            <label>Casting Gold Weight</label>
                                            <input maxlength="8" class="form-control number_only" placeholder="Casting Gold" name="casting_gold_weight" required>
                                        </div>
                                        <div class="form-group col-lg-3 no-print">
                                            <label class="urdu-text"><?php echo TextUrud(1);?></label>
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
                                        <div class="form-group col-md-2 no-print">
                                        <label>C B</label>
                                          <input type="text" maxlength="6" class="form-control number_only" name="caret_cb" id="caret_cb" style="width:100px;" > 
                                        </div>
                                        <div class="form-group col-md-2 no-print">
                                        <label>Kat Pay</label>
                                          <input type="text" maxlength="6" class="form-control number_only" name="katpay" style="width:100px;" >  
                                        </div>
                                        <div class="form-group col-md-2 no-print">
                                        <label>M.B</label>
                                          <input type="text" maxlength="6" class="form-control number_only" name="mb_entry" style="width:100px;" >
                                        </div>
                                        <label>&nbsp;</label>
                                        <div class="clear"></div>
                                        <button style="margin-left: 6px;" class="btn btn-primary no-print" id="calulate_bill" >Get Bill</button>
                                        <div class="clear"></div><br />
                                        <div class="form-group col-lg-3 no-print">
                                            <label class="urdu-text"><?php echo TextUrud(2);?></label>
                                            <input maxlength="8" class="form-control number_only" placeholder="Pure Gold" name="get_pure_gold" id="get_pure_gold">
                                        </div>
                                        <div class="clear"></div>    
                                        <div class="form-group col-lg-4 no-print">
                                            <input class="btn btn-default" type="submit" id="btn" value="Save">
                                        </div>
                                    <!-- </form> -->
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
            <div class="panel-body col-lg-4" id="inner_printer_div">
                                            <div class="table-responsive" id="print_div">
                                                <table class="table table-striped table-bordered table-hover" id="DivPrint">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" id="client_full_name" class="hide"></th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:200px;">Cast Weight</td>
                                                            <td id="td_cast_weight"></td>
                                                            <input type="hidden" id="hd_cast_weight" name="hd_cast_weight" value="">
                                                        </tr>
                                                        <tr>
                                                            <td>M KAT <span id="m_kat" style="font-weight: bold;"></span></td>
                                                            <td id="td_m_kat"></td>
                                                            <input type="hidden" name="hd_m_kat" id="hd_m_kat" value="">
                                                        </tr>
                                                        <tr>
                                                            <td>Pure Weight Gold</td>
                                                            <td id="td_pure_weight_gold"></td>
                                                            <input type="hidden" name="hd_pure_weight_gold" id="hd_pure_weight_gold" value="">
                                                        </tr>
                                                        <tr>
                                                        <tr>
                                                            <td>KAT Pay</td>
                                                            <td id="td_kat_pay"></td>
                                                            <input type="hidden" id="hd_kat_pay" name="hd_kat_pay" value="">
                                                        </tr>
                                                        <tr>
                                                            <td>Total Pure Gold With KAT</td>
                                                            <td id="td_pure_gold_with_kat"></td>
                                                            <input type="hidden" name="hd_pure_gold_with_kat" id="hd_pure_gold_with_kat" value="">
                                                        </tr>
                                                        <tr>
                                                            <td>Labor Fee Gold</td>
                                                            <td id="td_labore_fee_gold"></td>
                                                            <input type="hidden" name="hd_labore_fee_gold" id="hd_labore_fee_gold" value="">
                                                        </tr>
                                                        <tr>
                                                            <td>Total Gold Weight</td>
                                                            <td id="td_total_gold_weight"></td>
                                                            <input type="hidden" name="hd_total_gold_weight" id="hd_total_gold_weight" value="">
                                                        </tr>
                                                        <tr>
                                                            <td>Advance Gold <strong id="PlusMinus"></strong></td>
                                                            <td id="td_advance_gold"></td>
                                                            <input type="hidden" id="hd_advance_gold" name="hd_advance_gold" value="">
                                                        </tr>
                                                        <tr>
                                                            <td>Grand Total Gold</td>
                                                            <td id="td_grand_total_gold"></td>
                                                            <input type="hidden" id="hd_grand_total_gold"  name="hd_grand_total_gold" value="">
                                                        </tr>
                                                        <tr>
                                                            <td>Pay Pure Gold</td>
                                                            <td id="td_pay_pure_gold"></td>
                                                            <input type="hidden" id="hd_pay_pure_gold"  name="hd_pay_pure_gold" value="">
                                                        </tr>
                                                        <tr id="tr_remains_gold" class="">
                                                            <td>Total Remaining Gold</td>
                                                            <td id="td_total_remaining_gold"></td>
                                                            <input type="hidden" id="hd_total_remaining_gold"  name="hd_total_remaining_gold" value="">
                                                        </tr>
                                                        <tr id="tr_remains_advance_gold" class="hide">
                                                            <td>Total Remaining Advance Gold</td>
                                                            <td id="td_total_remaining_advance_gold"></td>
                                                            <input type="hidden" id="hd_total_remaining_advance_gold"  name="hd_total_remaining_advance_gold" value="">
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
            </div>
            <!-- /.row -->
        </div>
    </form>
    </div>    
    <style>
    @media print
	{    
		.no-print, .no-print *
		{
			display: none !important;
		}
        #main_div, #headin_div, #inner_div{ width: 400px;}
        #DivPrint, #print_div{ width: 350px;}
        .scrolling_div {
             overflow: hidden;
        }
        #DivPrint{padding-top: 0px !important; margin-top: 0px !important;}
        #main_div {margin: 0 !important;} 
        #main_top_div { display: none !important;}
        #inner_printer_div {margin: 0!important; font-size: 16px !important;}
        #headin_div{margin-left: 10px !important; font-size: 16px !important;}
	}
    </style>
    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#all_response').val('');

        // $("#GoldCastingForm").click(function(event){
        //     event.preventDefault();

        //     $.ajax({
        //             url:'action.php?action=CalculateGoldCastig',
        //             type:'GET',
        //             data:$(this).serialize(),
        //             success:function(response){
        //                 console.log(response); return false;
        //                 $("#response").text(result);

        //             }

        //     });
        // });

        // Calculate bill
        $("#calulate_bill").click(function(event){
            event.preventDefault();
            $.ajax({
                    url:'action.php?action=CalculateGoldCastig',
                    type:'POST',
                    data:$("#GoldCastingForm").serialize(),
                    success:function(response){
                        console.log(response); //return false;
                        var obj = eval( "(" + response + ")" ) ;
                        
                        $("#td_cast_weight").html(obj.casting_gold_weight);
                        $("#hd_cast_weight").val(obj.casting_gold_weight);

                        $("#td_m_kat").html(obj.cat);
                        $("#hd_m_kat").val(obj.cat);

                        $("#td_labore_fee_gold").html(obj.hd_labore_fee_gold);
                        $("#hd_labore_fee_gold").val(obj.hd_labore_fee_gold);

                        $("#td_total_gold_weight").html(obj.hd_total_gold_weight);
                        $("#hd_total_gold_weight").val(obj.hd_total_gold_weight);

                        $("#td_pure_gold_with_kat").html(obj.hd_pure_gold_with_kat);
                        $("#hd_pure_gold_with_kat").val(obj.hd_pure_gold_with_kat);

                        $("#td_kat_pay").html(obj.kat_pay);
                        $("#hd_kat_pay").val(obj.kat_pay);

                        $("#td_grand_total_gold").html(obj.hd_grand_total_gold);
                        $("#hd_grand_total_gold").val(obj.hd_grand_total_gold);

                        $("#td_pure_weight_gold").html(obj.hd_pure_weight_gold);
                        $("#hd_pure_weight_gold").val(obj.hd_pure_weight_gold);

                        $("#td_total_remaining_gld").html(obj.get_pure_gold);

                        // Show hide advance and remains gold
                        var PlusMinus = $("#PlusMinus").html();
                        if(PlusMinus == "+")
                        {
                            $("#tr_remains_advance_gold").removeClass('hide');
                            $("#tr_remains_gold").addClass('hide');
                            var total_remain_advance = $("#td_advance_gold").html() - $("#td_total_gold_weight").html();
                            console.log(total_remain_advance);
                            $("#td_total_remaining_advance_gold").html(total_remain_advance.toFixed(3));
                            $("#hd_total_remaining_advance_gold").val(total_remain_advance.toFixed(3));
                        }
                        else
                        {
                            $("#td_total_remaining_gold").html(obj.hd_grand_total_gold);
                            $("#hd_total_remaining_gold").val(obj.hd_grand_total_gold);
                        }
                    }

            });
        });

        // Numeric only control handler
    jQuery.fn.ForceNumericOnly =
    function()
    {
      return this.each(function()
      {
        $(this).keydown(function(e)
        {
          var key = e.charCode || e.keyCode;
          // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
          // home, end, period, and numpad decimal
          return (
            key == 8 || 
            key == 9 ||
            key == 13 ||
            key == 46 ||
            key == 110 ||
            key == 190 ||
            (key >= 35 && key <= 40) ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105));
        });
      });
    };   
    
    // Call Only numbers
    $(".number_only").ForceNumericOnly();
		
		$("#btn").click(function () {
			//Hide all other elements other than printarea.
			event.preventDefault();

            $.ajax({
                url:'action.php?action=AddGoldCasting',
                type:'POST',
                data:$("#GoldCastingForm").serialize(),
                success:function(response){
                    //console.log(response); return false;
                    if(response == 'success')
                    {
                        $("#show_message").removeClass('hide');
                        window.location.href = 'gold_casting';
                    }
                        
                    
                    //$("#response").text(result);
                }
            });
   //          $("#DivPrint").show();
			// window.print();
		});

    // Get value of Rati
    $("#caret_cb").on('keyup', function (){
        $("#m_kat").html($(this).val());
    });

    // Calculate pure gold after casting
    $("#get_pure_gold").on('keyup', function (){
        var pure_gold = $(this).val();
        $("#td_pay_pure_gold").html(pure_gold);
        var grand_total_gold = $("#td_grand_total_gold").html();
        console.log(grand_total_gold); 
        var current_total = grand_total_gold - pure_gold;
        console.log(current_total); 
        $("#td_total_remaining_gold").html(current_total.toFixed(3));
        $("#hd_total_remaining_gold").val(current_total.toFixed(3));
        // td_grand_total_gold
    });

    // Get Client Advance or remaining gold
    $("#all_client").on('change', function (){
        var client_id = $(this).val();
        $("#client_full_name").html($("#all_client option:selected").text());
        $("#client_full_name").removeClass('hide');
        //console.log(client_id); return false;
        event.preventDefault();

            $.ajax({
                url:'action.php?action=GetAdvanceGold',
                type:'POST',
                data:{client_id: client_id},
                success:function(response){
                    // PlusMinus
                    //console.log(response); return false;
                    //var obj1 = eval( "(" + response + ")" ) ;
                    //console.log(response); return false;
                    $("#PlusMinus").html('');
                    if (response > 0)
                    {
                        //console.log('find +');
                        $("#PlusMinus").html('+');
                    }
                    else
                    {
                        //console.log('find -');
                        $("#PlusMinus").html('-');
                    }
                     $("#td_advance_gold").html(response);   
                    return false;
                    
                    // if(obj1.advance == 1)
                    // {
                    //     $("#PlusMinus").html('+');
                    // }
                    // else
                    //     $("#PlusMinus").html('-');   
                    // $("#td_advance_gold").html(obj1.advance_gold);
                }
            });
    });

    }); // end state

    </script>
    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- Include Angular js -->

</body>

</html>