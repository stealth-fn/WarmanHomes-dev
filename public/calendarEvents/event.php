<?php

require_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/calendar/calendarEvents.php");

$calendarEventObj = new calendarEvent(false);



if(isset($_GET['id'])){

	$query_result = $calendarEventObj->getRecordByID($_GET['id']);

}

elseif(isset($_GET['year'])){

	$queryDate = date("Y-n-d",mktime(0,0,0,$_GET['month'],$_GET['day'],$_GET['year']));

	$query_result = $calendarEventObj->getConditionalRecord(array("event_date",$queryDate,true));

}

while ($info = mysqli_fetch_array($query_result)){

    $date = date ("l, jS F Y",mktime(0,0,0,$_GET['month'],$_GET['day'],$_GET['year']));

    $time_array = preg_split("[:]", $info['event_time']);

    $time = date ("g:ia", mktime($time_array['0'],$time_array['1'],0,$_GET['month'],$_GET['day'],$_GET['year']));

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<title>PHPCalendar - <?php echo $info['event_title']; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="images/cal.css" rel="stylesheet" type="text/css">

</head>



<body>

<table width="480" height="180" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td height="100">

<table width="480" border="0" cellpadding="0" cellspacing="0">

        <tr> 

          <td><span class="eventwhen"><u><?php echo $date . " at " . $time; ?></u></span><br> 

            <br> <br> </td>

        </tr>

        <tr> 

          <td><span class="event">Event Title</span></td>

        </tr>

        <tr> 

          <td><span class="eventdetail"><?php echo $info['event_title']; ?></span><br> 

            <br></td>

        </tr>

        <tr> 

          <td><span class="event">Event Description</span></td>

        </tr>

        <tr> 

          <td><span class="eventdetail"><?php echo $info['event_desc']; ?></span><br></td>

        </tr>

      </table></td>

  </tr>

</table>

</body>

</html>

<?php } ?>