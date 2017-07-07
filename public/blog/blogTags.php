<div

	class="blogTagContainer blogTagContainer-<?php echo $_GET["className"]; ?>"

>

	<div id="blogTagHeader">

		<?php echo $instanceBlog->sideBarTagsHeader;?>

	</div>

	

	<?php

		include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogTag.php");

		$blogTagObj = new blogTag(false);

		

		$blogTags = $blogTagObj->getConditionalRecord("tagText","ASC");

		

		while($x = mysqli_fetch_array($blogTags)){

	?>

			<div 

				class="blogTag blogTag-<?php echo $_GET["className"]; ?>" 

				id="blogTag<?php echo $x["priKeyID"] ?>"

			>

				<a 

					href="/index.php?pageID=<?php echo $instanceBlog->sortByTagPageID;?>&amp;viewBlogTagID=<?php echo $x["priKeyID"] ?>"

					onclick="updatePageCopy(<?php echo $instanceBlog->sortByTagPageID;?>),'viewBlogTagID=<?php echo $x["priKeyID"] ?>'); jsCSSStateChange(this,this);return false"

					class="blogTagText-<?php echo $_GET["className"];?> blogTagText navChoose standardButton"

				>

					<?php echo $x["tagText"]; ?>

				</a>

			</div>

	<?php

		}

	?>

</div>