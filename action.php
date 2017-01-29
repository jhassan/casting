<?php
	include_once('functions.php');
	$action = $_REQUEST['action'];

	switch($action)
	{
		// Login User
		case "LoginUser":

			$data = json_decode(file_get_contents("php://input"));
			$username = $data->username;
			$password = sha1($data->password);
               $where = " user_name = '".$username."' AND password = '".$password."' ";
               $row = GetRecord("tbl_users", $where);
          	$token = "";
          	if(count($row) > 1 && !empty($row))
          	{
          		// Create Token
          		$token = $username . "|" . uniqid(). uniqid(). uniqid();
          		// Update token in database
              $array = array('remember_token' => $token );
              $where = " user_name = '".$username."' AND password = '".$password."' ";                    
              UpdateRec("tbl_users", $where, $array);
          		echo json_encode($token);
          	}
          	else
          		echo "Error";
          break;
               
          // Logout User
          case "Logout":
               $data = json_decode(file_get_contents("php://input"));
               $token = $data->token;
               // Remove token in database
               $array = array('remember_token' => '' );
               $where = " remember_token = ".$token." ";                    
               UpdateRec("tbl_users", $where, $array);
          break;   

          // Add New User 
          case "AddUser":
               $data = json_decode(file_get_contents("php://input"));
               $username = $data->username;
               $password = sha1($data->password);
               $user_type = $data->user_type;
               $where = " user_name = '".$username."' ";
               $row = GetRecord("tbl_users", $where); 
               $db_user = $row['user_name'];  
               if($db_user != $username)
               {
                    // Insert new user info
                    $array = array('user_name' => $username, 'password' => $password, 'user_type' => $user_type );
                    InsertRec("tbl_users", $array);
               }  
               else
                    echo "already";
          break;      

          // Add Advance Gold
          case "AddAdvance":
               $new_client    = $_POST['new_client'];
               $client_name   = $_POST['client_name'];
               $shop_name     = $_POST['shop_name'];
               $phone         = $_POST['phone'];
               $advance_gold  = $_POST['advance_gold'];
               $all_client    = $_POST['all_client'];
               // If client is new
               if(isset($new_client) && $new_client == 1) {
                    $ClientArray = array('client_name' => $client_name, 
                                         'shop_name' => $shop_name, 
                                         'phone' => $phone, 
                                         'date_created' => date("Y-m-d H:i:s") );
                    $all_client = InsertRec("tbl_clients", $ClientArray);
                    // create Client COA
                   $sql = "SELECT MAX(coa_code) AS ClientCOA FROM tbl_coa WHERE `coa_type` = 'c'";
                   $query = mysqli_query($conn,$sql);
                   $rowcount = mysqli_num_rows($query);
                   $array = mysqli_fetch_array($query);
                   if(count($array['ClientCOA']) > 0)
                    $coa_code = $array['ClientCOA'] + 1;
                   else
                    $coa_code = "200001";
                   $CoaArray = array('client_id' => $all_client, 
                                      'coa_code' => $coa_code,
                                      'coa_account' => $client_name,
                                      'coa_type' => "c",
                                      'date_created' => date("Y-m-d H:i:s") );
                    $gold_id = InsertRec("tbl_coa", $CoaArray);
               }
                // Add Advance Gold in Advance table
                $AdvanceArray = array('client_id' => $all_client, 
                                  'advance_gold' => $advance_gold,
                                  'date_created' => date("Y-m-d H:i:s") );
                $advance_id = InsertRec("tbl_advance", $AdvanceArray);
                // Get Client COA
                if(isset($new_client) && $new_client == 1) {
                  $coa_code = $coa_code;
                  $desc = "Advance Gold " . $_POST['client_name'];
                }
                else
                {
                  $coa_code = GetCOA( (int)$_POST['all_client'], "c");
                  $desc = "Advance Gold " . GetClientName($all_client);
                }
                $debitDescriptions = "Advance gold add in inventory";
                // Add Advance Gold in Accounts
                $strDebitAcc = GetCOA(1, "a"); // Inventory COA
                $strCreditAcc = $coa_code; // Client COA
                $arrTrans[] = array("coa" => $strDebitAcc, "desc" => $debitDescriptions,  "debit" => $advance_gold, "credit" => 0);
                $arrTrans[] = array("coa" => $strCreditAcc, "desc" => $desc,"debit" => 0, "credit" => $advance_gold);
                foreach($arrTrans as $tran)
                {
                  $GoldAccountArray = array(
                        "debit_gold" => $tran["debit"],
                        'client_id' => $all_client,
                        'advance_id' => $advance_id,
                        "coa_code" => $tran["coa"],
                        "is_advance" => 1,
                        "`desc`" => $tran["desc"],
                        "credit_gold" => $tran["credit"],
                        'date_created' => date("Y-m-d H:i:s"));
                  $gold_id = InsertRec("tbl_debit_credit_gold", $GoldAccountArray);
                }
              //header("Location: advance?msg=sent");
          break;

          // Get all client shows in advance gold
          case "GetAllClients":
               $data = array();    
               $sql = "SELECT * FROM tbl_clients";
               $query = mysqli_query($conn,$sql);
               $rowcount = mysqli_num_rows($query);
               if($rowcount > 0)
               {
                  while($array = mysqli_fetch_array($query))
                   {
                      $data[] = $array;
                   }
                   echo json_encode($data); 
               }
               
          break;

          // Get Advance Gold
          case "GetAdvanceGold":
               $client_id    = $_POST['client_id'];
               $gold = GetAdvanceGold($client_id);
               echo $gold;
          break;

          // Get Advance Gold
          case "GetAdvanceGold2555":
          //echo "adfadsfad"; die;
          //print_r($_POST); die;
               $client_id = $_POST['client_id'];
               //echo $client_id; die;
               $id = GetAdvanceGold2($client_id);
               echo $id['grand_total'];
          break;

          // Calculate Gold Castig
          case "CalculateGoldCastig":
               $arrayCalculation =  array();
               $casting_gold_weight = $_POST['casting_gold_weight'];
               $caret_type = $_POST['caret_cb'];
               $client_id  = $_POST['all_client'];
      			   $katpay = $_POST['katpay'];
      			   $mb_entry = $_POST['mb_entry'];
               $ArrayData = CalculateMixedIron($casting_gold_weight, $caret_type);
               $mixed_iron = $ArrayData['mixed_iron'];
               $str_caret_type = $ArrayData['str_caret_type'];
               $cat = number_format($casting_gold_weight/96*$caret_type,3);
               $cat = GoldExactWeight($cat);
      			   $hd_pure_weight_gold = $casting_gold_weight-$cat ;
      			   $kat_pay = ($casting_gold_weight/96)*$katpay;
              // $labor_fee = $casting_gold_weight*15;
      			   $advance_gold = GetAdvanceGold($client_id);
      			   $labor_fee = $casting_gold_weight*$mb_entry;
               $rowTodayRate = GetRecord("tbl_today_gold_rate", '');
      			   $hd_labore_fee_gold = ($labor_fee/$rowTodayRate['today_rate'])*11.664;
               $pure_gold = ($casting_gold_weight + $caret_type);
      			   $hd_pure_gold_with_kat = ($hd_pure_weight_gold + $kat_pay);
               if($advance_gold > 0)
                $hd_grand_total_gold = ($advance_gold) - ($hd_pure_gold_with_kat + $hd_labore_fee_gold);
               else 
                $hd_grand_total_gold = ($hd_pure_gold_with_kat + $hd_labore_fee_gold) - ($advance_gold);
               // if($advance_gold > 0)
               //  $advance_gold = '-'.$advance_gold;
              //echo $advance_gold; die;
                //print_r($advance_gold); die;
                // $where = " client_id = '".$client_id."' ";
                // $rowClient = GetRecord("tbl_accounts", $where);
                
                // if($rowClient['advance'] == 1)
                // {

                //   $hd_grand_total_gold = ($hd_pure_gold_with_kat + $hd_labore_fee_gold) - $advance_gold;
                //   //echo "adfa"; die;
                //   //var_dump($hd_grand_total_gold); die;
                // }
                // else if($rowClient['remaining'] == 1)
                // {
                //   $hd_grand_total_gold = ($hd_pure_gold_with_kat + $hd_labore_fee_gold) + $advance_gold;
                // }
                // else
                //   $hd_grand_total_gold = ($hd_pure_gold_with_kat + $hd_labore_fee_gold) + $advance_gold;
                 
      			    //$hd_grand_total_gold = ($hd_pure_gold_with_kat + $hd_labore_fee_gold) - $advance_gold;
                $data['grand_total_fee'] = str_replace("-", "", $data['grand_total_fee']);
                $data['grand_total_fee'] = str_replace(",", "", $data['grand_total_fee']);
                $hd_total_gold_weight = $hd_labore_fee_gold + $hd_pure_gold_with_kat;
                //$get_pure_gold = $_POST['get_pure_gold'];
                $arrayCalculation['casting_gold_weight']  =  number_format($casting_gold_weight,3);
                $arrayCalculation['mixed_iron']           =  $mixed_iron;
                $arrayCalculation['cat']                  =  $cat;
                $arrayCalculation['labor_fee']            =  "Rs. ".$labor_fee;
                $arrayCalculation['pure_gold']            =  number_format($pure_gold,3);
                $arrayCalculation['hd_total_gold_weight'] =  number_format($hd_total_gold_weight,3);
                $arrayCalculation['str_caret_type']       =  $str_caret_type;
        				$arrayCalculation['hd_pure_weight_gold']  =   number_format($hd_pure_weight_gold,3);
        				$arrayCalculation['kat_pay']              =   number_format($kat_pay,3);
        				$arrayCalculation['hd_pure_gold_with_kat'] =  number_format($hd_pure_gold_with_kat,3);
        				$arrayCalculation['hd_labore_fee_gold']   =   number_format($hd_labore_fee_gold,3);
        				$arrayCalculation['hd_grand_total_gold']  =   number_format($hd_grand_total_gold,3);
                $arrayCalculation['get_pure_gold']        =   number_format($hd_grand_total_gold - $_POST['get_pure_gold'],3);
                echo json_encode($arrayCalculation);
          break;

          // Add Gold Casting
          // case 'AddGoldCasting':
          //       //print_r($_POST); die;
          //       $casting_gold_weight  = RemoveComma($_POST['casting_gold_weight']);
          //       $caret_type           = $_POST['caret_cb'];
          //       $client_id            = $_POST['all_client'];
          //       $katpay               = $_POST['katpay'];
          //       $mb_entry             = $_POST['mb_entry'];
          //       $mixed_iron           = RemoveComma($_POST['hd_m_kat']);
          //       $cat                  = RemoveComma($_POST['hd_kat_pay']);
          //       $labour_gold          = RemoveComma($_POST['hd_labore_fee_gold']);
          //       $advance_data         = RemoveComma(GetAdvanceGold($client_id));
          //       $hd_pure_weight_gold  = RemoveComma($_POST['hd_pure_weight_gold']);
          //       $hd_pure_gold_with_kat= RemoveComma($_POST['hd_pure_gold_with_kat']); 
          //       $hd_labore_fee_gold   = RemoveComma($_POST['hd_labore_fee_gold']); 
          //       $hd_grand_total_gold  = RemoveComma($_POST['hd_grand_total_gold']);

          //       // Add Gold Casting Data
          //       $GoldArray = array('client_id' => $client_id, 
          //                           'caret_type' => $caret_type, 
          //                           'casting_weight' => $casting_gold_weight,
          //                           'gold_cut' => $cat,
          //                           'mix_iron' => $mixed_iron,
          //                           'pure_gold' => $hd_pure_weight_gold,
          //                           'pure_gold_with_kat' => $hd_pure_gold_with_kat, 
          //                           'casting_labour_fee' => $hd_labore_fee_gold,
          //                           'date_created' => date("Y-m-d H:i:s") );
          //       $casting_id = InsertRec("tbl_casting", $GoldArray);
          //       $data = GetAdvanceGold($client_id);
          //      $advance_gold = $data['grand_total'];
          //      if($advance_gold > 0)
          //       $advance_gold = '-'.$advance_gold;
          //       $get_pure_gold = $_POST['get_pure_gold'] - $advance_gold;
          //       //$debit_gold = $get_pure_gold - $hd_grand_total_gold;
          //       $debit_gold = $hd_grand_total_gold;
          //       // Accounts
          //       $arrTrans[] = array("debit" => $debit_gold, "credit" => 0.00);
          //       $arrTrans[] = array("debit" => 0.00, "credit" => $get_pure_gold);
          //       foreach($arrTrans as $tran)
          //       {
          //         $GoldAccountArray = array('client_id' => $client_id,
          //               "debit_gold" => $tran["debit"],
          //               'casting_id' => $casting_id,
          //               "credit_gold" => $tran["credit"],
          //               'date_created' => date("Y-m-d H:i:s"));
          //         $gold_id = InsertRec("tbl_debit_credit_gold", $GoldAccountArray);
          //       }
          //       // $GoldAccountArray = array('client_id' => $client_id, 
          //       //                     'debit_gold' => $debit_gold, 
          //       //                     'credit_gold' => $get_pure_gold,
          //       //                     'casting_id' => $casting_id,
          //       //                     'date_created' => date("Y-m-d H:i:s") );
                
          //       echo "success";
          // break;
          case 'AddGoldCasting2':
                //print_r($_POST); die;
                $casting_gold_weight  = RemoveComma($_POST['casting_gold_weight']);
                $caret_type           = $_POST['caret_cb'];
                $client_id            = $_POST['all_client'];
                $katpay               = $_POST['katpay'];
                $mb_entry             = $_POST['mb_entry'];
                $mixed_iron           = RemoveComma($_POST['hd_m_kat']);
                $cat                  = RemoveComma($_POST['hd_kat_pay']);
                $labour_gold          = RemoveComma($_POST['hd_labore_fee_gold']);
                $advance_data         = RemoveComma(GetAdvanceGold($client_id));
                $hd_pure_weight_gold  = RemoveComma($_POST['hd_pure_weight_gold']);
                $hd_pure_gold_with_kat= RemoveComma($_POST['hd_pure_gold_with_kat']); 
                $hd_labore_fee_gold   = RemoveComma($_POST['hd_labore_fee_gold']); 
                $hd_grand_total_gold  = RemoveComma($_POST['hd_grand_total_gold']);
                $hd_total_gold_weight  = RemoveComma($_POST['hd_total_gold_weight']);
                $get_pure_gold        = RemoveComma($_POST['get_pure_gold']);
                $remaining_gold       = RemoveComma($_POST['remaining_gold']);

                // Add Gold Casting Data
                $GoldArray = array('client_id' => $client_id, 
                                    'caret_type' => $caret_type, 
                                    'casting_weight' => $casting_gold_weight,
                                    'gold_cut' => $cat,
                                    'mix_iron' => $mixed_iron,
                                    'pure_gold' => $hd_pure_weight_gold,
                                    'pure_gold_with_kat' => $hd_pure_gold_with_kat, 
                                    'after_cast_pay_gold' => $get_pure_gold,
                                    'remaining_gold' => $hd_grand_total_gold,
                                    'casting_labour_fee' => $hd_labore_fee_gold,
                                    'date_created' => date("Y-m-d H:i:s") );

                $casting_id = InsertRec("tbl_casting", $GoldArray);
                // Add Gold after casting in Accounts
                // $WorkingProcessDebitAcc = GetCOA(2, "a"); // Working Process COA
                // $InventoryCreditAcc     = GetCOA(1, "a"); // Inventory COA
                // $FinishGoodsDebitAcc    = GetCOA(3, "a"); // Finish Goods COA
                // $WorkingProcessCreditAcc = GetCOA(2, "a"); // Finish Goods COA
                // $ClientDebitAcc         = GetCOA((int)$client_id, "c"); // Client Debit COA
                // $FinishGoodsCreditAcc   = GetCOA(3, "a"); // Finish Goods COA
                // $OwnerGoldDebitAcc      = GetCOA(4, "a"); // Owner Gold COA
                // $ClientCreditAcc        = GetCOA((int)$client_id, "c"); // Client Credit COA

                // $desc = "Casting Gold " . GetClientName($client_id);
                // $arrTrans[] = array("coa" => $WorkingProcessDebitAcc, "desc" => $desc,  "debit" => $hd_grand_total_gold, "credit" => 0);
                // $arrTrans[] = array("coa" => $InventoryCreditAcc, "desc" => $desc,"debit" => 0, "credit" => $hd_grand_total_gold);

                // $arrTrans[] = array("coa" => $FinishGoodsDebitAcc, "desc" => $desc,  "debit" => $hd_grand_total_gold, "credit" => 0);
                // $arrTrans[] = array("coa" => $WorkingProcessCreditAcc, "desc" => $desc,"debit" => 0, "credit" => $hd_grand_total_gold);

                // $arrTrans[] = array("coa" => $ClientDebitAcc, "desc" => $desc,  "debit" => $hd_grand_total_gold, "credit" => 0);
                // $arrTrans[] = array("coa" => $FinishGoodsCreditAcc, "desc" => $desc,"debit" => 0, "credit" => $hd_grand_total_gold);

                // $arrTrans[] = array("coa" => $OwnerGoldDebitAcc, "desc" => $desc,  "debit" => $hd_grand_total_gold, "credit" => 0);
                // $arrTrans[] = array("coa" => $ClientCreditAcc, "desc" => $desc,"debit" => 0, "credit" => $hd_grand_total_gold);
                // Add Advance Gold in Accounts
                $debitDescriptions = "Client take gold";
                $creditDescriptions = "Owner give gold";
                $coa_code = GetCOA( (int)$client_id, "c");
                $strDebitAcc = $coa_code; // Client COA
                $strCreditAcc = GetCOA(1, "a"); // Inventory COA
                $arrTrans[] = array("coa" => $strDebitAcc, "desc" => $debitDescriptions,  "debit" => $hd_total_gold_weight, "credit" => 0);
                $arrTrans[] = array("coa" => $strCreditAcc, "desc" => $creditDescriptions,"debit" => 0, "credit" => $hd_total_gold_weight);
                
                if(!empty($get_pure_gold))
                {
                // Add Advance Gold in Accounts
                $strDebitAcc = GetCOA(1, "a"); // Inventory COA
                $strCreditAcc = $coa_code; // Client COA
                $desc = "Advance Gold " . GetClientName($client_id);
                $debitDescriptions = "Advance gold add in inventory";  
                $arrTrans[] = array("coa" => $strDebitAcc, "desc" => $debitDescriptions,  "debit" => $get_pure_gold, "credit" => 0);
                $arrTrans[] = array("coa" => $strCreditAcc, "desc" => $desc,"debit" => 0, "credit" => $get_pure_gold);
                }

                foreach($arrTrans as $tran)
                {
                  $GoldAccountArray = array(
                        "debit_gold" => $tran["debit"],
                        'client_id' => $client_id,
                        'casting_id' => $casting_id,
                        'advance_id' => $advance_id,
                        "coa_code" => $tran["coa"],
                        "`desc`" => $tran["desc"],
                        "credit_gold" => $tran["credit"],
                        'date_created' => date("Y-m-d H:i:s"));
                  $gold_id = InsertRec("tbl_debit_credit_gold", $GoldAccountArray);
                }

                // foreach($arrTrans as $tran)
                // {
                //   $GoldAccountArray = array(
                //         "debit_gold" => $tran["debit"],
                //         'client_id' => $client_id,
                //         'advance_id' => $advance_id,
                //         "coa_code" => $tran["coa"],
                //         "`desc`" => $tran["desc"],
                //         "credit_gold" => $tran["credit"],
                //         'date_created' => date("Y-m-d H:i:s"));
                //   $gold_id = InsertRec("tbl_debit_credit_gold", $GoldAccountArray);
                // }
                
                echo "success";
          break;

          // Get All Debit Credit Clients
          case 'GetAllDebitCreditClients':
               $data = array();    
               $sql = "SELECT SUM(`debit_gold`) AS Debit, SUM(`credit_gold`) AS Credit, `client_name`,
                        SUM(`credit_gold`) - SUM(`debit_gold`) AS grand_total,
                        SUM(`labour_fee_credit`) - SUM(`labour_fee_debit`) AS labour_fee,
                        IF(SUM(`credit_gold`) - SUM(`debit_gold`)>=0, 'T', 'F') AS main_value,
                        IF(SUM(`labour_fee_credit`) - SUM(`labour_fee_debit`)>=0, 'T', 'F') AS labour_value
                        FROM `tbl_debit_credit_gold` 
                        INNER JOIN `tbl_clients` ON `tbl_clients`.`client_id` = `tbl_debit_credit_gold`.`client_id`
                        GROUP BY `tbl_clients`.`client_id`";
               $query = mysqli_query($conn,$sql);
               while($array = mysqli_fetch_array($query))
               {
                  $data[] = $array;
               }
               $data['records'] = $data;
               echo json_encode($data);
            break;

            // Calculate Labour Gold
            case 'CalculateLabourGold':
                $data = json_decode(file_get_contents("php://input"));
                $current_gold_rate    = $data->current_gold_rate;
                $labour_fee           = $data->labour_fee;
                $gold = LabourGold($current_gold_rate, $labour_fee, 'form');
                echo $gold;
            break;

            // Today Report
            case "TodayReport":
               $data = array();    
               $sql = "SELECT tbl_casting.*, client_name  FROM `tbl_casting`
                      INNER JOIN `tbl_clients` ON `tbl_clients`.`client_id` = `tbl_casting`.`client_id`
                      WHERE tbl_casting.`date_created` LIKE '".date('Y-m-d')."%'
                      ORDER BY `casting_id` DESC";
               $query = mysqli_query($conn,$sql);
               while($array = mysqli_fetch_array($query))
               {
                  $data[] = $array;
               }
               $data['records'] = $data;
               echo json_encode($data);
            break;

            // Today Gold Rate
            case 'TodayGoldRate':
              $today_gold_rate = $_POST['today_gold_rate'];
              $where = " id = 1 ";
              $rowClient = GetRecord("tbl_today_gold_rate", $where);
              $GoldRate = array('today_rate' => (int)$today_gold_rate);
              if(empty($rowClient['today_rate']))
              {
                $casting_id = InsertRec("tbl_today_gold_rate", $GoldRate);
              }
              else
              {
                UpdateRec("tbl_today_gold_rate", $where, $GoldRate);
              }
            break;

		
	}
      // Calculate Labour Gold
      function LabourGold($current_gold_rate, $labour_fee, $from = "")
      {
        if(!empty($current_gold_rate))
          {
            if($from == "form")
            {
              $labour_fee           = explode(" ", $labour_fee);
              $labour_fee           = $labour_fee[1];
              $labour_fee           = str_replace(",", "", $labour_fee);  
            }
            $pay_or_gold          = ($labour_fee / $current_gold_rate) * 11.664;
            $pay_or_gold          = GoldExactWeight($pay_or_gold);
            return $pay_or_gold;
          }
      }

     // Get Adance Gold
     function GetAdvanceGold($client_id)
     {
          $data = array();
          global $conn;
          // $sql = "SELECT SUM(`debit_gold`) - SUM(`credit_gold`)  AS grand_total
          //         FROM `tbl_debit_credit_gold` 
          //         INNER JOIN `tbl_clients` ON `tbl_clients`.`client_id` = `tbl_debit_credit_gold`.`client_id`
          //         WHERE `tbl_clients`.`client_id` = ".(int)$client_id."
          //         GROUP BY `tbl_clients`.`client_id`";
           $sql = "SELECT SUM(`debit_gold`) AS Debit, SUM(`credit_gold`) AS Credit,client_name,
                  (SUM(`credit_gold`) - SUM(`debit_gold`)) AS AvailBalance
                  FROM `tbl_coa` 
                  INNER JOIN `tbl_debit_credit_gold` ON `tbl_debit_credit_gold`.`coa_code` = `tbl_coa`.`coa_code`
                  INNER JOIN `tbl_clients` ON `tbl_clients`.`client_id` = `tbl_debit_credit_gold`.`client_id`
                  WHERE `coa_type` = 'c' AND tbl_coa.`client_id` = ".(int)$client_id."";      
           $query = mysqli_query($conn,$sql);
           $array = mysqli_fetch_array($query);
           $advance_gold = $array['AvailBalance']; 
           return $advance_gold;
     }
     //  function GetAdvanceGold($client_id)
     // {
     //      $data = array();
     //      global $conn;
     //      $sql = "SELECT * 
     //              FROM `tbl_accounts` 
     //              WHERE `tbl_accounts`.`client_id` = ".(int)$client_id."";
     //       $query = mysqli_query($conn,$sql);
     //       $array = mysqli_fetch_array($query);
     //       //$advance_gold = $array['balance']; 
     //       // if($array['grand_total'] > 0)
     //       //print_r($array); die;
     //       $data['advance_gold'] = $array['balance'];
     //       // $data['advance']      = $array['advance'];
     //       // $data['remaining']    = $array['remaining'];
     //       return $data;
     // }

     function GetAdvanceGold2($client_id)
     {
      //$client_id = $_POST['client_id'];
      //echo $client_id; die;
          $data = array();
          global $conn;
          $sql = "SELECT * 
                  FROM `tbl_accounts` 
                  WHERE `tbl_accounts`.`client_id` = ".(int)$client_id."";
           $query = mysqli_query($conn,$sql);
           $array = mysqli_fetch_array($query);
           //$advance_gold = $array['balance']; 
           // if($array['grand_total'] > 0)
           //print_r($array); die;
           $data['advance_gold'] = $array['balance'];
           $data['advance']      = $array['advance'];
           $data['remaining']    = $array['remaining'];
           echo json_encode($data);
     }

     // Calculate Mixed Iron
     function CalculateMixedIron($casting_gold_weight, $caret_type)
     {
          $mixed_iron = 0;
          $str_caret_type = "";
          $array = array();
          if($caret_type == 22) // 22K
          {
             $mixed_iron = ($casting_gold_weight/96)  * 8;
             $str_caret_type = "22K / 8 Rati";  
          }
          else if($caret_type == 21) // 21K
          {
             $mixed_iron = ($casting_gold_weight/96)  * 12;
             $str_caret_type = "21K / 12 Rati";
          }   
          else if($caret_type == 20) // 20K
          {
             $mixed_iron = ($casting_gold_weight/96)  * 16;
             $str_caret_type = "20K / 16 Rati";  
          }
          else if($caret_type == 19) // 19K
          {
             $mixed_iron = ($casting_gold_weight/96)  * 20; 
             $str_caret_type = "19K / 20 Rati"; 
          }   
          else if($caret_type == 18) // 18K
          {
             $mixed_iron = ($casting_gold_weight/96)  * 24;
             $str_caret_type = "18K / 24 Rati";   
          }   
          else if($caret_type == 17) // 17K
          {
             $mixed_iron = ($casting_gold_weight/96)  * 28;
             $str_caret_type = "17K / 28 Rati";
          }   
          else if($caret_type == 16) // 16K
          {
             $mixed_iron = ($casting_gold_weight/96)  * 32; 
             $str_caret_type = "16K / 32 Rati"; 
          }                  

        $mixed_iron = number_format($mixed_iron,3);
        $array['mixed_iron'] = $mixed_iron;
        $array['str_caret_type'] = $str_caret_type; 
       // $mixed_iron = round($mixed_iron, 0, PHP_ROUND_HALF_UP);
        return $array;
     }

     // Calculate gold exact weight
     function GoldExactWeight($gold_weight)
     {
          $gold_weight = str_replace(",", "", $gold_weight);
          $decimals = 2;
          $gold_weight = $gold_weight * pow(10,$decimals);
          $gold_weight = intval($gold_weight);
          $gold_weight = number_format($gold_weight / pow(10,$decimals), 3);
          return $gold_weight;
     }

     // Remove Comma
     function RemoveComma($str)
     {
      return $str = str_replace(",", "", $str);
     }

     // Remove Minus
     function RemoveMinus($str)
     {
      return $str = str_replace("-", "", $str);
     }
?>