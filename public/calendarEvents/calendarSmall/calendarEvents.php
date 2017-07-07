<?php

require_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/calendar/calendarEvents.php");

$calendarEventObj = new calendarEvent(false);



function getmicrotime(){ 

    list($usec, $sec) = explode(" ",microtime()); 

    return ((float)$usec + (float)$sec); 

} 



$time_start = getmicrotime();



if(!isset($_REQUEST['year'])){

    $_REQUEST['year'] = date("Y");

}

if(!isset($_REQUEST['month'])){

    $_REQUEST['month'] = date("n");

}



$beforeDate = date("Y-n-d",mktime(0,0,0,$_REQUEST['month'],1,$_REQUEST['year']));

$afterDate = date("Y-n-d",mktime(0,0,0,$_REQUEST['month']+1,1,$_REQUEST['year']));



$calendarEvents = $calendarEventObj->getConditionalRecord(array("event_date",$beforeDate,"greatEqual","event_date",$afterDate,"less"));



while ($info = mysqli_fetch_array($calendarEvents))

{

    $day = date("j",strtotime($info['event_date']));

    $event_id = $info['priKeyID'];

    $events[$day][] = $info['priKeyID'];

    $event_info[$event_id]['0'] = substr($info['event_title'], 0, 8);;

    $event_info[$event_id]['1'] = $info['event_time'];

}



$todays_date = date("j");

$todays_month = date("n");



$days_in_month = date ("t", mktime(0,0,0,$_REQUEST['month'],0,$_REQUEST['year']));

$first_day_of_month = date ("w", mktime(0,0,0,$_REQUEST['month'],1,$_REQUEST['year']));

$first_day_of_month = $first_day_of_month + 1;

$count_boxes = 0;

$days_so_far = 0;



if($_REQUEST['month'] == 13){

    $next_month = 2;

    $next_year = $_REQUEST['year'] + 1;

} else {

    $next_month = $_REQUEST['month'] + 1;

    $next_year = $_REQUEST['year'];

}



if($_REQUEST['month'] == 2){

    $prev_month = 13;

    $prev_year = $_REQUEST['year'] - 1;

} else {

    $prev_month = $_REQUEST['month'] - 1;

    $prev_year = $_REQUEST['year'];

}







?>

<div class="mfmc" id="calendarContainer">

	<h2 class="mfh" id="upcomingEventHeader">Upcoming Events</h2>

	<div id="calendarEventContainer">

		<div id="currDateDiv"><span class="currentdate"><?php echo date ("F Y", mktime(0,0,0,$_REQUEST['month'],1,$_REQUEST['year'])); ?></span><br />

		  <br />

		</div>

		<div id="calTopDate"><br />

		  <table border="0" cellspacing="0" cellpadding="0">

		    <tr> 

		      <td><div id="dateLeft" align="right"><a href="#" onclick="getCalendar(<?php echo "$prev_month,$prev_year";?>);return false;">&lt;&lt;</a></div></td>

		      <td><div align="center">

		          <select name="month" id="month" onchange="getCalendar(this.value,document.getElementById('year').value)">

		            <?php

					for ($i = 1; $i <= 12; $i++) {

					

						if($_REQUEST['month'] == $i){

							$selected = "selected='selected'";

						} else {

							$selected = "";

						}

						

						if(strlen($i) == 1){

							$i = "0".$i;

						}

						

						echo "<option value=\"$i\" $selected>" . date ("F", mktime(0,0,0,$i,1,$_REQUEST['year'])) . "</option>\n";

					}

					?>

		          </select>

		          <select name="year" id="year" onchange="getCalendar(document.getElementById('month').value,this.value)">

				  <?php

				  for ($i = 2000; $i <= 2015; $i++) {

				  	if($i == $_REQUEST['year']){

						$selected = "selected='selected'";

					} else {

						$selected = "";

					}

				  	echo "<option value=\"$i\" $selected>$i</option>\n";

				  }

				  ?>

		          </select>

		        </div></td>

		      <td><div id="dateRight" align="left"><a href="#" onclick="getCalendar(<?php echo "$next_month,$next_year";?>);return false;">&gt;&gt;</a></div></td>

		    </tr>

		  </table>

		  <br />

		</div>

		<table id="calTable">

		  <tr>

		    <td><table width="100%" border="0" cellpadding="0" cellspacing="1">

		        <tr class="topdays"> 

		          <td><div align="center">Su</div></td>

		          <td><div align="center">Mo</div></td>

		          <td><div align="center">Tu</div></td>

		          <td><div align="center">We</div></td>

		          <td><div align="center">Th</div></td>

		          <td><div align="center">Fr</div></td>

		          <td><div align="center">Sa</div></td>

		        </tr>

				<tr> 

				<?php

				for ($i = 1; $i <= $first_day_of_month-1; $i++) {

					$days_so_far = $days_so_far + 1;

					$count_boxes = $count_boxes + 1;

					echo "<td class=\"beforedayboxes\"></td>\n";

				}

				for ($i = 1; $i <= $days_in_month; $i++) {

		   			$days_so_far = $days_so_far + 1;

		    			$count_boxes = $count_boxes + 1;

					if($_REQUEST['month'] == $todays_month+1){

						if($i == $todays_date){

							$class = "highlighteddayboxes";

						} else {

							$class = "dayboxes";

						}

					} else {

						if($i == 1){

							$class = "highlighteddayboxes";

						} else {

							$class = "dayboxes";

						}

					}

					if(isset($events[$i])){

						echo "<td class=\"$class dayWithEvent\">\n";

					}

					else{

						echo "<td class=\"$class\">\n";

					}

					$link_month = $_REQUEST['month'];

					echo "<div align=\"right\"><span class=\"toprightnumber\">\n<a href=\"javascript:MM_openBrWindow('/public/calendarEvents/event.php?day=$i&amp;month=$link_month&amp;year=$_REQUEST[year]','','width=500,height=300');\">$i</a>&nbsp;</span></div>\n";

					if(isset($events[$i])){

						echo "<div align=\"left\"><span class=\"eventinbox\">\n";

						while (list($key, $value) = each ($events[$i])) {

							echo "&nbsp;<a href=\"javascript:MM_openBrWindow('/public/calendarEvents/event.php?id=$value','','width=500,height=200');\">" . $event_info[$value]['1'] . " " . $event_info[$value]['0']  . "</a>\n<br />\n";

						}

						echo "</span></div>\n";

					}

					echo "</td>\n";

					if(($count_boxes == 7) AND ($days_so_far != (($first_day_of_month-1) + $days_in_month))){

						$count_boxes = 0;

						echo "</tr><tr>\n";

					}

				}

				$extra_boxes = 7 - $count_boxes;

				for ($i = 1; $i <= $extra_boxes; $i++) {

					echo "<td class=\"afterdayboxes\"></td>\n";

				}

				$time_end = getmicrotime();

				$time = round($time_end - $time_start, 3);

				?>

		        </tr>

		      </table></td>

		  </tr>

		</table>

		

			<?php

				$recentDate = date("Y-n-d",mktime(0,0,0,date("m"),date("d"),date("Y")));

		

				$upcomingEvents = $calendarEventObj->getConditionalRecord(array("event_date",$recentDate,"greatEqual","event_date","ASC"));

				$upEvents = mysqli_fetch_array($upcomingEvents);

			?>

			

			<div id="topTwo">

				<?php if(mysqli_num_rows($upcomingEvents) >= 1){ ?>

				<div>

				<div class="upComingDate" id="topDate" onclick="MM_openBrWindow('/public/calendarEvents/event.php?id=<?php echo $upEvents["priKeyID"] ?>','','width=500,height=200')">

					<div class="eventDateMonth"><?php echo date("M",strtotime($upEvents["event_date"])); ?></div>

					<div class="eventDateDate"><?php echo date("d",strtotime($upEvents["event_date"])); ?></div>

				</div>

				<div class="eventDateTitle"><?php echo $upEvents["event_title"]; ?></div>

				</div>

				<?php } ?>

			

			

			<?php

				if(mysqli_num_rows($upcomingEvents) >= 2){

				$upEvents = mysqli_fetch_array($upcomingEvents);

			?>

			<div>

			<div class="upComingDate" id="bottomDate" onclick="MM_openBrWindow('/public/calendarEvents/event.php?id=<?php echo $upEvents["priKeyID"] ?>','','width=500,height=200')">

				<div class="eventDateMonth"><?php echo date("M",strtotime($upEvents["event_date"])); ?></div>

				<div class="eventDateDate"><?php echo date("d",strtotime($upEvents["event_date"])); ?></div>

			</div>

			<div class="eventDateTitle"><?php echo $upEvents["event_title"]; ?></div>

			</div>

			<?php } ?>

			

			<?php

				if(mysqli_num_rows($upcomingEvents) == 0){

					echo "No upcoming events.";

				} 

			?>

		</div>

	</div>

</div>