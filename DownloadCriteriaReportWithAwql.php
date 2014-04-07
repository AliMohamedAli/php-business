<?php
/**
 * This example downloads a criteria report to a file.
 *
 * Copyright 2012, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsAdWords
 * @subpackage v201402
 * @category   WebServices
 * @copyright  2012, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 * @author     Danial Klimkin <api.dklimkin@gmail.com>
 */

error_reporting(E_STRICT | E_ALL);

// Include the initialization file
require_once 'init.php';

require_once ADWORDS_UTIL_PATH . '/ReportUtils.php';

/**
 * Runs the example.
 * @param AdWordsUser $user the user to run the example with
 * @param string $filePath the path of the file to download the report to
 */
function DownloadCriteriaReportWithAwqlExample(AdWordsUser $user, $filePath,
    $reportFormat) {
  // Prepare a date range for the last week. Instead you can use 'LAST_7_DAYS'.
  $dateRange = sprintf('%d,%d',
      date('Ymd', strtotime('-90 day')), date('Ymd', strtotime('-1 day')));

  // DATE RANGE
  // 20140101,20140301 [ JAN 1 - MAR 1]

  $sFields = "CampaignId,CampaignName,AdGroupId,Id,Criteria,CriteriaType,Impressions,Clicks,Cost";

  // Create report query.
  $reportQuery = 'SELECT '.$sFields.' FROM CRITERIA_PERFORMANCE_REPORT '
                          . 'WHERE Status IN [ACTIVE, PAUSED] '
                          . 'DURING ' . $dateRange;

  // Set additional options.
  $options = array('version' => ADWORDS_VERSION);

  // Download report.
  ReportUtils::DownloadReportWithAwql($reportQuery, $filePath, $user,
      $reportFormat, $options);

  printf("Report was downloaded to '%s'.\n", $filePath);

  readCSV($filePath,true);

}

function readCSV($filename, $header=false) {
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
fclose($handle);
}

try {
  // Get AdWordsUser from credentials in "../auth.ini"
  // relative to the AdWordsUser.php file's directory.
  //$user = new AdWordsUser();
  /*
  $email="";
  $password="";
  $clientId="542-898-8567";
  $userAgent="";
  $developerToken="L6oLZINEd5p06CvWp99H1w";
  $applicationToken="";
  $user = new AdWordsUser(NULL, $email, $password, $developerToken,
      $applicationToken, $userAgent, $clientId);
  */
  $user = new AdWordsUser();

  // Log every SOAP XML request and response.
  $user->LogAll();

  // Download the report to a file in the same directory as the example.
  $filePath = dirname(__FILE__) . '/report.csv';
  $reportFormat = 'CSV';

  // Run the example.
  DownloadCriteriaReportWithAwqlExample($user, $filePath, $reportFormat);

  

} catch (Exception $e) {
  printf("An error has occurred: %s\n", $e->getMessage());
}

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="js/tableSorting.js"></script>

<style type="text/css">
table,td,th{border:1px solid black;border-collapse:collapse;padding:2px 10px;}
.tSortable tr:nth-child(1){cursor:n-resize;background-color:lightsteelblue;font-weight: bold;}
.tSortable td, .sortRow td{width:100px;}
.sortRow{font-weight: bold};
tr:nth-child(even) {background: #FFF }
tr:nth-child(odd) {background: cornsilk}
</style>

<script type="text/javascript">
(function($){
  $(function(){
    lastRow();
    sortCol();
  });
})(jQuery);

</script>