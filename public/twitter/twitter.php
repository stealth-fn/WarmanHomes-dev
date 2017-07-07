<div id="mfmc-leadTwitter" class="mfmc">
	<h2 id="tweetHeader" class="mfh">
	</h2>
	<div id="tweetsDiv">
		<?php 
			for ( $i = 0; $i < 1; $i++) {
			echo "<div class='tweet'>";
			//echo "<div class='tweetImg' id='tweetImg" . $i . "'><img src='' alt='" . $i . "'/></div>";
			echo "<div class='tweetInfo' id='tweetInfo" . $i . "'><a href='http://twitter.com/StealthDesigns' target='blank'></a></div>";
			echo "</div>";
			echo '<a
					class="homeTweetBlogLink"
					href="http://twitter.com/StealthDesigns"
					target="_blank"
				>
					@StealthDesigns
				</a>';
			echo "<div class='tweetTime' id='tweetTime" . $i . "'></div>";
		}
		?>
	</div>
</div>
