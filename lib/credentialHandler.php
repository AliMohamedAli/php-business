<?php 
function checkLogout(){
	if(isset($_POST['logout'])){
		session_destroy();
		Header("Location: registerForm.php");
	}
}
function getCredentials(){
	if(!isset($_SESSION['customer'])){
    if(isset($_POST['client_id'])){
      $CLIENT_ID = $_POST['client_id'];
      $CLIENT_SECRET = $_POST['client_secret'];
      $REFRESH_TOKEN = $_POST['refresh_token'];
      $DEVELOPER_TOKEN = $_POST['developer_token'];
      $CLIENT_CUSTOMER_ID = $_POST['client_customer_id'];
    }else{
      // Parse without sections
      $ini_array = parse_ini_file("js/data.ini");
      if(count($ini_array)){    
          $CLIENT_ID = $ini_array['client_id'];
          $CLIENT_SECRET = $ini_array['client_secret'];
          $REFRESH_TOKEN = $ini_array['refresh_token'];
          $DEVELOPER_TOKEN = $ini_array['developer_token'];
          $CLIENT_CUSTOMER_ID = $ini_array['client_customer_id'];
          $file = true;
      }else{    
        Header("Location: registerForm.php");
      }
    }
  }else{
    $CLIENT_ID = $_SESSION['client_id'];
    $CLIENT_SECRET = $_SESSION['client_secret'];
    $REFRESH_TOKEN = $_SESSION['refresh_token'];
    $DEVELOPER_TOKEN = $_SESSION['developer_token'];
    $CLIENT_CUSTOMER_ID = $_SESSION['client_customer_id'];
  }

  $credentials = array($CLIENT_ID,$CLIENT_SECRET,$REFRESH_TOKEN,$DEVELOPER_TOKEN,$CLIENT_CUSTOMER_ID);
  return $credentials;
}

function saveSession(){
  if(!isset($_SESSION['customer'])){   
    if(isset($_POST['client_id'])){      
      $_SESSION['customer'] = "user_logged";
      $_SESSION['client_id'] = $_POST['client_id'];
      $_SESSION['client_secret'] = $_POST['client_secret'];
      $_SESSION['developer_token'] = $_POST['developer_token'];
      $_SESSION['refresh_token'] = $_POST['refresh_token'];
      $_SESSION['client_customer_id'] = $_POST['client_customer_id'];

      $adwordsCredentials = array(
                  'adwords' => array(
                      'client_id' => $_POST['client_id'],
                      'client_secret' => $_POST['client_secret'],
                      'developer_token' => $_POST['developer_token'],
                      'refresh_token' => $_POST['refresh_token'],
                      'client_customer_id' => $_POST['client_customer_id']
                  ));
      write_ini_file($adwordsCredentials, 'js/data.ini', true);
    }else{
      $ini_array = parse_ini_file("js/data.ini");
      $CLIENT_ID = $ini_array['client_id'];
      $CLIENT_SECRET = $ini_array['client_secret'];
      $REFRESH_TOKEN = $ini_array['refresh_token'];
      $DEVELOPER_TOKEN = $ini_array['developer_token'];
      $CLIENT_CUSTOMER_ID = $ini_array['client_customer_id'];

      $_SESSION['customer'] = "user_logged";
      $_SESSION['client_id'] = $CLIENT_ID;
      $_SESSION['client_secret'] = $CLIENT_SECRET;
      $_SESSION['developer_token'] = $DEVELOPER_TOKEN;
      $_SESSION['refresh_token'] = $REFRESH_TOKEN;
      $_SESSION['client_customer_id'] = $CLIENT_CUSTOMER_ID;

      $adwordsCredentials = array(
                  'adwords' => array(
                      'client_id' => $CLIENT_ID,
                      'client_secret' => $CLIENT_SECRET,
                      'developer_token' => $DEVELOPER_TOKEN,
                      'refresh_token' => $REFRESH_TOKEN,
                      'client_customer_id' => $CLIENT_CUSTOMER_ID
                  ));
      write_ini_file($adwordsCredentials, 'js/data.ini', true);
    }
  }
}
function readCSV($filename, $header=false) {
  print("<iframe style=\"float:right;\" height=\"300px\" width=\"300px\" src=\"http://unanimegroup.com/test/clock/\" frameborder=\"0\" scrolling=\"no\"></iframe>");
  $handle = fopen($filename, "r");
  print('<table border=\"1\">');
  //display header row if true

  if ($header) {
      $csvcontents = fgetcsv($handle);
      print('<tr>');
      foreach ($csvcontents as $headercolumn) {
          print("<td>$headercolumn</td>");
      }
      print('</tr>');
  }
  print('</table><br/>');
  // displaying contents
  print('<table class="tSortable" border=\"1\">');
  while ($csvcontents = fgetcsv($handle)) {
      print('<tr>');
      foreach ($csvcontents as $id=>$column) {
          print("<td>$column</td>");
      }    
      print('</tr>');
  }  

  print('</table>');

  if(isset($_SESSION['customer'])){
    print("<form method=\"POST\" action=\"".$_SERVER['PHP_SELF']."\">");
    print("<input type=\"submit\" name=\"logout\" value=\"Log Out\"/>");
    print("</form>");
    print("<div id=\"table_mini\"></div>");
  }
  fclose($handle);
}
function RunExample(AdWordsUser $user) {
  $customerService = $user->GetService("CustomerService");
  $customer = $customerService->get();
}
function DownloadCriteriaReportWithAwqlExample(AdWordsUser $user, $filePath,
    $reportFormat) {
  // Prepare a date range for the last week. Instead you can use 'LAST_7_DAYS'.
  $dateRange = sprintf('%d,%d',
      date('Ymd', strtotime('-90 day')), date('Ymd', strtotime('-1 day')));

  // DATE RANGE
  // 20140101,20140301 [ JAN 1 - MAR 1]

  $sFields = "Id,Criteria,CriteriaType,CampaignId,CampaignName,AdGroupId,Impressions,Clicks,Cost";

  // Create report query.
  $reportQuery = 'SELECT '.$sFields.' FROM CRITERIA_PERFORMANCE_REPORT '
                          . 'WHERE Status IN [ACTIVE, PAUSED] AND CampaignName = CampTest1 '
                          . 'DURING ' . $dateRange;

  // Set additional options.
  $options = array('version' => ADWORDS_VERSION,'returnMoneyInMicros' => false);

  // Download report.
  ReportUtils::DownloadReportWithAwql($reportQuery, $filePath, $user,
      $reportFormat, $options);

  printf("Report was downloaded to '%s'.\n", $filePath);

  readCSV($filePath,true);

}
?>