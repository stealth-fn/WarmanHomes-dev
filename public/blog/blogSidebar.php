<?php
if(!isset($_REQUEST["pmpm"])) {
	$activeCat = "0";
	$activeYear = "0";
	$activeMonth = "0";
}
else {	
	$tempJson = json_decode($_REQUEST["pmpm"],true);
	if(isset($tempJson[$priModObj[0]->blogListPmpmID]["blogCategoryID"])) {
		$activeCat = $tempJson[$priModObj[0]->blogListPmpmID]["blogCategoryID"];
	}
	else {
		$activeCat = "0";
	}
	
	if(isset($tempJson[$priModObj[0]->blogListPmpmID]["viewBlogYear"])) {
		$activeYear = $tempJson[$priModObj[0]->blogListPmpmID]["viewBlogYear"];
	}
	else {
		$activeYear = "0";
	}
	
	if(isset($tempJson[$priModObj[0]->blogListPmpmID]["viewBlogMonth"])) {
		$activeMonth = $tempJson[$priModObj[0]->blogListPmpmID]["viewBlogMonth"];
	}
	else {
		$activeMonth = "0";
	}
}
?>

<div 
	class="blogSideBar blogSideBar-<?php echo $priModObj[0]->className; ?>"
	id="blogSideBar-<?php echo $priModObj[0]->className; ?>"
>
	<?php
		#empty h tags aren't w3 valid
		if(strlen($priModObj[0]->headerText) > 0){
	?>
	<h2 class="mfh" id="mfh-<?php echo $priModObj[0]->className;?>">
    	<?php echo $priModObj[0]->headerText;?>
    </h2>
	<?php
		}
	?>
<?php
	if($priModObj[0]->blogSearchOn){
?>
	<div id="blogSearchContainer">
		<form name="blogSearchForm" id="blogSearchForm" action="#" onsubmit="searchBlogs();return false">
			<input 
				id="blogSearchTerm" 
				name="blogSearchTerm"
                onfocus="clearField($s('blogSearchTerm'))" 
                onblur="backToDefault($s('blogSearchTerm'))"
				type="text" 
				<?php 
					if(isset($_REQUEST["blogSearchTerm"])) {
				?>
					value="<?php echo $_REQUEST["blogSearchTerm"]; ?>" 
				<?php
					}
					else {
				?>
					value="<?php echo $priModObj[0]->searchInputValue; ?>" 
				<?php
					}
				?>
				maxlength="100"
			/>
			<input
				id="blogSearchPageID"
				name="blogSearchPageID"
				type="hidden"
				value="<?php echo $priModObj[0]->searchResultsPageID;?>"
			/>
			<div
				id="blogSearchBtn"
				onclick="searchBlogs()"
			>
				
			</div>
		</form>
	</div>
<?php
	}
	if($priModObj[0]->rssEmailSubscribeOn){
?>
	<div id="rssEmailSubscribe">
		<form 
			action="http://feedburner.google.com/fb/a/mailverify" 
			method="post" target="popupwindow" 
			onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=IsaskMortgageRssFeed', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"
		>
			<input 
				type="text" 
				name="email"
				value="Subscribe By Email"
			/>
			<input 
				type="hidden" 
				value="IsaskMortgageRssFeed" 
				name="uri"
			/>
			<input 
				type="hidden" 
				name="loc" 
				value="en_US"
			/>
			<input 
				type="submit" 
				value="Subscribe" 
			/>
		</form>
	</div>

<?php
	}
?>
<?php
	if($priModObj[0]->categoriesOn){
		/*blog category menu*/
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogCategory.php");
		$blogCategoryObj = new blogCategory(false);
		$blogCategories = $blogCategoryObj->getAllRecords();
		
		if(mysqli_num_rows($blogCategories) > 0){
			
		
?>
			<div class="blogCatContainer blogCatContainer-<?php echo $priModObj[0]->className; ?>" >
				<div class="blogCatHeader blogCatHeader-<?php echo $priModObj[0]->className; ?>" >
					<?php echo $priModObj[0]->categoriesHeader; ?>
				</div>
<?php
			if ($priModObj[0]->blogCategoryFormat == 0) {
				while($x = mysqli_fetch_assoc($blogCategories)){ 
					$activeClass = "";
					
					if ($activeCat == $x["priKeyID"]) {
						$activeClass = 'active';
					}	
					if (1 == $x["includeInSidebar"]) {
			?>
			
					<div 
						class="blogCat blogCat-<?php echo $priModObj[0]->className.' '.$activeClass;?>" 
						id="blogCat-<?php echo $priModObj[0]->className;?>-<?php echo $x["priKeyID"];?>"
					>
						<a 
							class="blogCatText blogCatText-<?php echo $priModObj[0]->className . ' '; ?> nc sb" 
							href="/index.php?pageID=<?php echo $priModObj[0]->viewCategoriesPageID;?>&amp;blogCategoryID=<?php echo $x["priKeyID"];?>"
							onclick="upc(<?php echo $priModObj[0]->viewCategoriesPageID;?>,'pmpm={\'<?php echo $priModObj[0]->blogListPmpmID;?>\':{\'overrideRequests\':\'false\',\'blogCategoryID\':\'<?php echo $x["priKeyID"]; ?>\'}}'); return false"
						>
							<?php echo $x["blogCatTitle"];?>
						</a>
					</div>
<?php
					} // end of if
				} //end of while
			} // end of if
			else {
?>
				<select id="categories" onchange="<?php echo $priModObj[0]->className;?>.srchCat(this,<?php echo $priModObj[0]->viewCategoriesPageID;?>,<?php echo $priModObj[0]->blogListPmpmID;?>);">
				<option value="0">View All Categories</option>
<?php
				while($x = mysqli_fetch_assoc($blogCategories)){
						if ($activeCat == $x["priKeyID"]) {
							echo "<option selected value='" , $x["priKeyID"] , "'>" , $x["blogCatTitle"], "</option>";
						}
						else {
							echo "<option value='" , $x["priKeyID"] , "'>" , $x["blogCatTitle"], "</option>";
						}
						
				} // end of while
?>
				</select>
<?php
			}
?>
			</div>
<?php
		}
	}
	#recent blogs container
	if($priModObj[0]->recentBlogsOn){
		/*blog category menu*/
		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blog.php");
		$blogObj = new blog(false);
		$recentBlogs = $blogObj->getCheckQuery("SELECT * FROM blog ORDER BY postDate DESC LIMIT 3");
		
		if(mysqli_num_rows($recentBlogs) > 0){
	?>
			<div class="recentBlogsContainer recentBlogsContainer-<?php echo $priModObj[0]->className; ?>" >
				<div class="recentBlogsHeader recentBlogsHeader-<?php echo $priModObj[0]->className; ?>" >
					<?php echo $priModObj[0]->recentBlogsHeader; ?>
				</div>
	<?php
			while($x = mysqli_fetch_assoc($recentBlogs)){ 
				$activeClass = "";
				
				if(isset($priModObj[0]->blogKeyID)){
					if($priModObj[0]->blogKeyID == $x['priKeyID']){
						$activeClass = 'active';
					}
				}
	?>
				<div class="recentBlog recentBlog-<?php echo $priModObj[0]->className . " " .$activeClass;?>" >
					<div 
						class="recentBlogName recentBlogName-<?php echo $priModObj[0]->className; ?> nc sb" 
					>
						<?php echo $x["blogName"];?>
					</div>
					<div
						class="recentBlogDate recentBlogDate-<?php echo $priModObj[0]->className; ?>"
					>
						<?php echo date($priModObj[0]->blogDateFormat,strtotime($x["postDate"]));?>
					</div>
					<a 
						class="recentBlogLink recentBlogLink-<?php echo $priModObj[0]->className; ?>"
						href="/index.php?pageID=<?php echo $priModObj[0]->viewRecentBlogPageID;?>&amp;pmpm=%28%22<?php echo $priModObj[0]->blogPmpmID;?>%22%3A%28%22overrideRequests%22%3A%22false%22,%22blogKeyID%22%3A%22<?php echo $x["priKeyID"]; ?>%22%29%29"
						onclick="upc(<?php echo $priModObj[0]->viewRecentBlogPageID;?>,'pmpm={\'<?php echo $priModObj[0]->blogPmpmID;?>\':{\'overrideRequests\':\'false\',\'blogKeyID\':\'<?php echo $x["priKeyID"]; ?>\'}}'); return false"
					>
						<img src="/js/blank.gif" alt="blank" />
					</a>
				</div>
	<?php
			}
	?>
			</div>
	<?php
		}
	}
	#blog tag container
	if($priModObj[0]->tagsOn){
?>
	<div
		class="blogTagContainer blogTagContainer-<?php echo $priModObj[0]->className; ?>"
	>
		<div 
			class="blogTagHeader blogTagHeader-<?php echo $priModObj[0]->className; ?>"
		>
			<?php echo $priModObj[0]->tagsHeader;?>
		</div>
		
<?php
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogTag.php");
			$blogTagObj = new blogTag(false);
			$blogTags = $blogTagObj->getConditionalRecord(array("tagText","ASC",true));
			
			while($x = mysqli_fetch_assoc($blogTags)){
?>
				<div 
					class="blogTag blogTag-<?php echo $priModObj[0]->className; ?>" 
					id="blogTag<?php echo $x["priKeyID"] ?>"
				>
					<a 
						href="/index.php?pageID=<?php echo $priModObj[0]->viewTagsPageID; ?>&amp;viewBlogTagID=<?php echo $x["priKeyID"]; ?>"
						onclick="upc(<?php echo $priModObj[0]->viewTagsPageID; ?>),'viewBlogTagID=<?php echo $x["priKeyID"]; ?>'); jsCSSStateChange(this,this);return false"
						class="blogTagText-<?php echo $priModObj[0]->className; ?> blogTagText nc sb"
					>
                    
                    <a 
						class="recentBlogLink recentBlogLink-<?php echo $priModObj[0]->className; ?>"
						href="/index.php?pageID=<?php echo $priModObj[0]->viewRecentBlogPageID;?>&amp;pmpm={'<?php echo $priModObj[0]->blogPmpmID;?>':{'overrideRequests':'false','blogKeyID':'<?php echo $x["priKeyID"]; ?>'}}"
						onclick="upc(<?php echo $priModObj[0]->viewRecentBlogPageID;?>,'pmpm={\'<?php echo $priModObj[0]->blogPmpmID;?>\':{\'overrideRequests\':\'false\',\'blogKeyID\':\'<?php echo $x["priKeyID"]; ?>\'}}'); return false"
					>
						<?php echo $x["tagText"]; ?>
					</a>
				</div>
<?php
			}
?>
	</div>
	
<?php
	}
	#previous blogs menu
	if($priModObj[0]->datesOn){
	#previous 5 months and earlier
	?>
    <div class="pastBlogEnteries pastBlogEntries-<?php echo $priModObj[0]->className; ?>" >
		<div class="pastBlogEntriesHeader pastBlogEntriesHeader-<?php echo $priModObj[0]->className; ?>" >
        	<?php echo $priModObj[0]->datesHeader;?>
        </div>
	
	<?php 
		if (0 == $priModObj[0]->archiveFormat) {
		#get the current year, and go back 4 previous years
		
		$activeYearClass = '';
		if (date('Y') == $activeYear) {
			$activeYearClass = 'activeYear';
		}
	?>
		<div 
        	class="blogYear blogYear-<?php echo $priModObj[0]->className; ?> blogYear1 <?php echo $activeYearClass; ?>" 
        >
            <div 
            	class="yearText yearText-<?php echo $priModObj[0]->className;?> nc sb" 
                onclick="<?php echo $priModObj[0]->className;?>.showMonths(this); return false"
            >
            	<?php echo date('Y');?>
            </div>
           
            <div class="months" style="display:none">
            	<?php for($m = 1;$m <= date("m"); $m++){ 
                    $month =  date("F", mktime(0, 0, 0, $m)); 
				?>
					<a 
                        class="dateText dateText-<?php echo $priModObj[0]->className;?> nc sb"  
                        href="/index.php?pageID=<?php echo $priModObj[0]->viewDatesPageID;?>&amp;pmpm=%7B%27<?php echo $priModObj[0]->blogListPmpmID;?>'%3A%7B'viewBlogMonth'%3A'<?php echo date("m", mktime(0, 0, 0, $m))?>'%2C'viewBlogYear'%3A'<?php echo date("Y",mktime(0,0,0,0,0,date('Y')+1))?>'%7D%7D"
                        onclick="upc(<?php echo $priModObj[0]->viewDatesPageID;?>,'pmpm={\'<?php echo $priModObj[0]->blogListPmpmID;?>\':{\'viewBlogMonth\':\'<?php echo date("m", mktime(0, 0, 0, $m));?>\',\'viewBlogYear\':\'<?php echo date('Y',mktime(0,0,0,0,0,date('Y')+1))?>\'}}'); return false"
                    >
                        <?php echo $month;?>
                    </a>
                <?php
                } 
            	?>
            
            </div>
        </div>
		<?php
        $year = array(date('Y'), date('Y')-1, date('Y')-2, date('Y')-3, date('Y')-4);
        ?>
        
        <?php
			for ($i=2; $i <= 5; $i++) {
				$activeYearClass = '';
				if ($year[$i-1] == $activeYear) {
					$activeYearClass = 'activeYear';
				}
		?>
			<div 
				class="blogYear blogYear-<?php echo $priModObj[0]->className; ?> blogYear<?php echo $i;?>" 
			>
				<div 
					class="yearText yearText-<?php echo $priModObj[0]->className;?> nc sb <?php echo $activeYearClass; ?>"  
					onclick="<?php echo $priModObj[0]->className;?>.showMonths(this); return false"
				>
					<?php echo $year[$i-1];?>
				</div>
				<div class="months" style="display:none">
					<?php for($m = 1;$m <= 12; $m++){ 
						$month =  date("F", mktime(0, 0, 0, $m)); 
					?>
						<a 
							class="dateText dateText-<?php echo $priModObj[0]->className;?> nc sb"  
							href="/index.php?pageID=<?php echo $priModObj[0]->viewDatesPageID;?>&amp;pmpm=%7B'<?php echo $priModObj[0]->blogListPmpmID;?>'%3A%7B'viewBlogMonth'%3A'<?php echo date("m", mktime(0, 0, 0, $m)); ?>'%2C'viewBlogYear'%3A'<?php echo date("Y",mktime(0,0,0,0,0,$year[$i-2]))?>'%7D%7D"
							onclick="upc(<?php echo $priModObj[0]->viewDatesPageID;?>,'pmpm={\'<?php echo $priModObj[0]->blogListPmpmID;?>\':{\'viewBlogMonth\':\'<?php echo date("m", mktime(0, 0, 0, $m));?>\',\'viewBlogYear\':\'<?php echo date('Y',mktime(0,0,0,0,0,$year[$i-2]))?>\'}}'); return false"
						>
							<?php echo $month;?>
						</a>
					<?php
					} 
					?>

				</div>
			</div>
		<?php
				
			}
		?>
         
        <div 
            class="blogYear blogYear-<?php echo $priModObj[0]->className; ?> blogYearEarlier" 
        >
             <a 
             	id="earlier"
             	class="dateText dateText-<?php echo $priModObj[0]->className;?> nc sb"
             	href="/index.php?pageID=<?php echo $priModObj[0]->viewDatesPageID;?>&amp;pmpm=%7B'<?php echo $priModObj[0]->blogListPmpmID;?>'%3A%7B'viewEarlier'%3A'1'%7D%7D"
             	onclick="upc(<?php echo $priModObj[0]->viewDatesPageID;?>,'pmpm={\'<?php echo $priModObj[0]->blogListPmpmID;?>\':{\'viewEarlier\':\'1\'}}'); return false"
             >
                Earlier
            </a>
        </div>
        <?php
			}
		# display only active years and months
		else {
			
			# get all blog posts
			
			include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blog.php");
			$blogObj = new blog(false);
			$blogPosts = $blogObj->getConditionalRecord(
				array("blog.isActive",1,true,"blog.postDate","DESC")
			);

			# keeps only years
			$activeYears = array();
			
			# keeps years and months 
			# for example $activeDates["2016"] is an array of all active months for 2016
			$activeDates = array();
			
			if(mysqli_num_rows($blogPosts) > 0){
				
				# loop through all blog posts and get active years and months, store it in 2 arrays
				while($x = mysqli_fetch_assoc($blogPosts)){ 
					$postYear = date("Y", strtotime($x["postDate"]));
					$postMonth = date("F", strtotime($x["postDate"]));
					
					# add the post year if it hasn't been added so far
					if (!in_array($postYear,$activeYears)) {
						array_push($activeYears, $postYear);
						$activeDates[$postYear][0] = $postMonth;
					}
					# post years isn't new buth post month is
					else if (!in_array($postMonth,$activeDates[$postYear])) {
						array_push($activeDates[$postYear], $postMonth);
					}
				}
			}
			
			for ($j=0; $j < count($activeYears); $j++) {
				$activeYearClass = '';
				if ($activeYears[$j] == $activeYear) {
					$activeYearClass = 'activeYear';
				}
				
				echo '<div 
				class="blogYear blogYear-'.$priModObj[0]->className.'blogYear'.$j.'" 
			>
				<div 
					class="yearText yearText-'.$priModObj[0]->className.'nc sb '. $activeYearClass .'"  
					onclick="'.$priModObj[0]->className.'.showMonths(this); return false"
				>
					'. $activeYears[$j] .'
				</div><div class="months" style="display:none">';
				
				for($m = count($activeDates[$activeYears[$j]])-1; $m > -1; $m--){ 
					
					$tempMonth = $activeDates[$activeYears[$j]][$m];
					
				?>
					<a 
							class="dateText dateText-<?php echo $priModObj[0]->className;?> nc sb"  
							href="/index.php?pageID=<?php echo $priModObj[0]->viewDatesPageID;?>&amp;pmpm=%7B'<?php echo $priModObj[0]->blogListPmpmID;?>'%3A%7B'viewBlogMonth'%3A'<?php echo date("m", strtotime($tempMonth)); ?>'%2C'viewBlogYear'%3A'<?php echo $activeYears[$j];?>'%7D%7D"
							onclick="upc(<?php echo $priModObj[0]->viewDatesPageID;?>,'pmpm={\'<?php echo $priModObj[0]->blogListPmpmID;?>\':{\'viewBlogMonth\':\'<?php echo date("m", strtotime($tempMonth));?>\',\'viewBlogYear\':\'<?php echo $activeYears[$j];?>\'}}'); return false"
						>
							<?php echo $tempMonth;?>
						</a>
				<?php
				}
				echo '</div></div>';
			} // end of for
		} // end of else
		?>
	</div>
<?php
	}
	
	$dateOne = date("F Y",mktime(0,0,0,date("m")-0,0,date('Y')));
	$dateTwo = date("F Y",mktime(0,0,0,date("m")-1,0,date('Y')));
	$dateThree = date("F Y",mktime(0,0,0,date("m")-2,0,date('Y')));
	$dateFour = date("F Y ",mktime(0,0,0,date("m")-3,0,date('Y')));
?>
</div>