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
               $data = json_decode(file_get_contents("php://input"));
               $new_client    = $data->new_client;
               $client_name   = $data->client_name;
               $shop_name     = $data->shop_name;
               $phone         = $data->phone;
               $advance_gold  = $data->advance_gold;
               $all_client    = $data->all_client;
               $debit_gold    = $data->debit_gold;
               $labour_fee_credit    = $data->labour_fee_credit;
               // If client is new
               if ($new_client == 1) {
                    $ClientArray = array('client_name' => $client_name, 
                                         'shop_name' => $shop_name, 
                                         'phone' => $phone, 
                                         'date_created' => date("Y-m-d H:i:s") );
                    $all_client = InsertRec("tbl_clients", $ClientArray);
               }
               else
               {
               }
              // Debit Credit Gold
              $GoldArray = array('client_id' => $all_client, 
                                  'debit_gold' => $debit_gold, 
                                  'credit_gold' => $advance_gold,
                                  'labour_fee_credit' => $labour_fee_credit,
                                  'date_created' => date("Y-m-d H:i:s") );
              $gold_id = InsertRec("tbl_debit_credit_gold", $GoldArray);
              echo $gold_id;
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
               $data = json_decode(file_get_contents("php://input"));
               $client_id    = $data->client_id;
               $id = GetAdvanceGold($client_id);
               echo $id['grand_total'];
          break;

          // Calculate Gold Castig
          case "CalculateGoldCastig":
               $arrayCalculation =  array();
               $data = json_decode(file_get_contents("php://input"));
               $casting_gold_weight = $data->casting_gold_weight;
               $caret_type = $data->caret_type;
               $client_id  = $data->all_client;
               $ArrayData = CalculateMixedIron($casting_gold_weight, $caret_type);
               $mixed_iron = $ArrayData['mixed_iron'];
               $str_caret_type = $ArrayData['str_caret_type'];
               $cat = number_format($casting_gold_weight/96,3);
               $cat = GoldExactWeight($cat);
               $labor_fee = number_format($casting_gold_weight*13);
               $pure_gold = ($casting_gold_weight + $cat) - $mixed_iron;
                $data = GetAdvanceGold($client_id);
                $advance_gold = $data['grand_total'];
                $data['grand_total_fee'] = str_replace("-", "", $data['grand_total_fee']);
                $data['grand_total_fee'] = str_replace(",", "", $data['grand_total_fee']);
                $labor_fee = str_replace(",", "", $labor_fee);
                //echo $data['grand_total_fee'] ."----". $labor_fee; die;
                $labor_fee = $data['grand_total_fee'] + $labor_fee;
                $total_gold = $advance_gold - $pure_gold;
                $arrayCalculation['casting_gold_weight']  =  GoldExactWeight($casting_gold_weight);
                $arrayCalculation['mixed_iron']           =  $mixed_iron;
                $arrayCalculation['cat']                  =  $cat;
                $arrayCalculation['labor_fee']            =  "Rs. ".$labor_fee;
                $arrayCalculation['pure_gold']            =  GoldExactWeight($pure_gold);
                $arrayCalculation['total_gold']           =  GoldExactWeight($total_gold);
                $arrayCalculation['str_caret_type']       =  $str_caret_type;
                echo json_encode($arrayCalculation);
          break;

          // Add Gold Casting
          case 'AddGoldCasting':
                $data = json_decode(file_get_contents("php://input"));
                // print_r($data); die;
                $casting_gold_weight  = $data->entityId->casting_gold_weight;
                $mixed_iron           = $data->entityId->mixed_iron;
                $cat                  = $data->entityId->cat;
                $labor_fee            = str_replace("Rs. ", "", $data->entityId->labor_fee);
                $labor_fee            = str_replace(",", "", $labor_fee);
                $pure_gold            = str_replace(",", "", $data->entityId->pure_gold);
                $total_gold           = $data->entityId->total_gold;
                $str_caret_type       = $data->entityId->str_caret_type;
                $all_client           = $data->all_client;
                $get_pure_gold        = $data->get_pure_gold;
                $advance_data         = GetAdvanceGold($all_client);
                $advance_gold         = $advance_data['grand_total'];
                // $labor_fee            = $advance_data['grand_total_fee'] + $labor_fee;
                $labour_fee_credit    = $data->labour_fee_credit;
                $current_gold_rate    = $data->current_gold_rate;
                $pay_or_gold          = $data->pay_or_gold;
                $labour_gold          = LabourGold($current_gold_rate, $labor_fee, "");
                if($pay_or_gold == 1)
                  $labor_fee = 0;
                // Add Gold Casting Data
                $GoldArray = array('client_id' => $all_client, 
                                    'caret_type' => $str_caret_type, 
                                    'casting_weight' => $casting_gold_weight,
                                    'gold_cut' => $cat,
                                    'mix_iron' => $mixed_iron,
                                    'pure_gold' => $pure_gold,
                                    'casting_labour_fee' => $labor_fee,
                                    'date_created' => date("Y-m-d H:i:s") );
                $casting_id = InsertRec("tbl_casting", $GoldArray);

                if(empty($get_pure_gold))
                {
                  $pure_gold = str_replace(",", "", $pure_gold);
                  if($pay_or_gold == 1)
                  {
                    //echo $pure_gold ."-------". $labour_gold; die;
                    $debit_gold = $pure_gold + $labour_gold;
                    $labor_fee = 0;
                    $labour_fee_credit = 0;
                    // Update laboure fee
                    $array = array('labour_fee_debit' => '0', 'labour_fee_credit' => '0' );
                    $where = " client_id = ".$all_client." ";                    
                    UpdateRec("tbl_debit_credit_gold", $where, $array);
                  }
                  else
                    $debit_gold = $pure_gold;
                }
                else
                {
                  //echo $labour_gold; die;
                  //echo $pure_gold ."-------". $labour_gold; die;
                  $pure_gold = str_replace(",", "", $pure_gold);
                  if($pay_or_gold == 1)
                  {
                    $debit_gold = $pure_gold + $labour_gold;
                    $labor_fee = 0;
                    $labour_fee_credit = 0;
                    // Update laboure fee
                    $array = array('labour_fee_debit' => '0', 'labour_fee_credit' => '0' );
                    $where = " client_id = ".$all_client." ";                    
                    UpdateRec("tbl_debit_credit_gold", $where, $array);
                  }
                  else
                    $debit_gold = $pure_gold;
                  $get_pure_gold = str_replace(",", "", $get_pure_gold);
                  // if($pay_or_gold == 1)
                  //   $credit_gold = $get_pure_gold;
                  // else
                    $credit_gold = $get_pure_gold;
                }
                $GoldArray = array('client_id' => $all_client, 
                                    'debit_gold' => $debit_gold, 
                                    'credit_gold' => $credit_gold,
                                    'casting_id' => $casting_id,
                                    'labour_fee_debit' => $labor_fee,
                                    'labour_fee_credit' => $labour_fee_credit,
                                    'date_created' => date("Y-m-d H:i:s") );
                $gold_id = InsertRec("tbl_debit_credit_gold", $GoldArray);

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
          $sql = "SELECT SUM(`credit_gold`) - SUM(`debit_gold`) AS grand_total,
                  SUM(`labour_fee_credit`) - SUM(`labour_fee_debit`) AS grand_total_fee
                  FROM `tbl_debit_credit_gold` 
                  INNER JOIN `tbl_clients` ON `tbl_clients`.`client_id` = `tbl_debit_credit_gold`.`client_id`
                  WHERE `tbl_clients`.`client_id` = ".(int)$client_id."
                  GROUP BY `tbl_clients`.`client_id`";
           $query = mysqli_query($conn,$sql);
           $array = mysqli_fetch_array($query);
           $advance_gold = $array['grand_total']; 
           $data['grand_total'] = $array['grand_total'];
           $data['grand_total_fee'] = $array['grand_total_fee'];
           return $data;
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
          $decimals = 2;
          $gold_weight = $gold_weight * pow(10,$decimals);
          $gold_weight = intval($gold_weight);
          $gold_weight = number_format($gold_weight / pow(10,$decimals), 3);
          return $gold_weight;
     }
?>