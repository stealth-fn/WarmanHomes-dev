<?php

	header("Content-Type: application/xml; charset=ISO-8859-1");

?>

<rss version="2.0">

	<?php

		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/rss/rssChannel.php");

		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/rss/rssItem.php");

		

		$rssChannelObj = new rssChannel(false);

		$rssItemObj = new rssItem(false);

		

		$rssChannel = $rssChannelObj->getRecordByID($_GET["rssChannelID"]);

		$rssItems = $rssItemObj->getConditionalRecord("rssChannelID",$_GET["rssChannelID"],true);

		

		/*first build the items string, then insert into the channels string*/

		$items = "";

		while($row = mysqli_fetch_array($rssItems)){

		 $items = $items . "<item>

			<title>" . $row["title"] . "</title>

			<link>". $row["linkURL"] ."</link>

			<description>" . $row["description"] . "</description>

			<guid>" . $row["guid"] . "</guid>

		 </item>"; 	

		}

		

		$channel = "";

		while($row = mysqli_fetch_array($rssChannel)){

			$channel = $channel . "<channel>

				<title>" . $row["title"] . "</title>

				<link>". $row["linkURL"] ."</link>

				<description>" . $row["description"] . "</description>

				" . $items . "

			</channel>";

		}

		

		echo $channel;		

	?>

</rss>