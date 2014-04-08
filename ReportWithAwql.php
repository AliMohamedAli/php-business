<?php
session_start();

error_reporting(E_STRICT | E_ALL);

// Include the initialization file
include 'config.php';
include 'lib/getCampaigns.php';
include 'lib/tables.php';
require_once 'lib/class/KeywordData.class.php';
require_once 'lib/class/AdWordsAdapter.class.php';
require_once 'lib/credentialHandler.php';
require_once 'init.php';

require_once ADWORDS_UTIL_PATH . '/ReportUtils.php';

try {
  
  checkLogout();
  $credentials = getCredentials();
  $CLIENT_ID = $credentials[0];
  $CLIENT_SECRET = $credentials[1];
  $REFRESH_TOKEN = $credentials[2];
  $DEVELOPER_TOKEN = $credentials[3];
  $CLIENT_CUSTOMER_ID = $credentials[4];

  $adwordsData = new AdWordsAdapter($CLIENT_ID,$CLIENT_SECRET,$REFRESH_TOKEN,$DEVELOPER_TOKEN,$CLIENT_CUSTOMER_ID);

  saveSession();

  $oauth2Info = array(
    'client_id' => $CLIENT_ID,
    'client_secret' => $CLIENT_SECRET,
    'refresh_token' => $REFRESH_TOKEN
  );

  // See AdWordsUser constructor
  $user = new AdWordsUser(NULL, NULL, NULL, $DEVELOPER_TOKEN, NULL, NULL,
      $CLIENT_CUSTOMER_ID, NULL, NULL, $oauth2Info);

  $user->LogAll();

  // Get the OAuth2 credential.
  RunExample($user);

  // Download the report to a file in the same directory as the example.
  $filePath = dirname(__FILE__) . '/report.xml';
  $reportFormat = 'XML';

  // Run the example.
  $keyData = DownloadCriteriaReportWithAwqlExample($user, $filePath, $reportFormat);

  drawTable($keyData);

  print('<select name="charts" style="float:left">
    <option name="null" value="null" disabled selected>Select Criteria: </option>
    <option name="costs" value="Costs">Costs</option>
    <option name="clicks" value="Clicks">Clicks</option>
    <option name="impressions" value="Impressions">Impressions</option>
    </select>
    <div id="chart_div" style="float:left;top: 23px;left: -113px;"></div>');
} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
  session_destroy();
  Header("Location: registerForm.php");
}


?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="js/tableSorting.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="js/graphGoogle.js"></script>
<style type="text/css">
table,td,th{border:1px solid black;border-collapse:collapse;padding:2px 10px;}
.tSortable tr:nth-child(1){cursor:n-resize;background-color:lightsteelblue;font-weight: bold;}
.tSortable td, .sortRow td{width:100px;}
.sortRow{font-weight: bold};
tr:nth-child(even) {background: #FFF }
tr:nth-child(odd) {background: cornsilk}
</style>
<script type="text/javascript">
  // Load the Visualization API and the piechart package.
  google.load('visualization', '1.0', {'packages':['corechart']});
  
  (function($){
    $(function(){
      //lastRow();
      sortCol();
      $('select').on('change', function() {
        loadGoogleCharts();
      });
      
    });
  })(jQuery);
</script>