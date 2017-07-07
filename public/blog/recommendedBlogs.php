				<?php

				#turn related articles on/off

				if($instanceBlog->recommendedArticlesOnOff == 1){

					include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/blog/blogRecommendedMap.php");

					$blogRecommendedMapObj = new blogRecommendedMap(false);

					#get this blog ID from the blog_recommended_map table

					$recommendedArticles = $blogRecommendedMapObj->getConditionalRecord('blogID',$_GET["queryResults"]["priKeyID"],true);

					if(mysqli_num_rows($recommendedArticles) > 0){

						#we set a variable counting the number of related articles if the number of recommended articles is less than what's in the instance_blog table

						#so the mysqli_data_seek doesn't get an error

						if(mysqli_num_rows($recommendedArticles) < $instanceBlog->recommendedArticlesCnt){

							$numRecommendedArts = mysqli_num_rows($recommendedArticles) -1;

						} else{

							$numRecommendedArts = $instanceBlog->recommendedArticlesCnt;

						}

					?>

						<div

							class="blogRecommendedArticlesContainer blogRecommendedArticlesContainer-<?php echo $_GET['className'];?>"

						>

						<?php

						#we only display the number of related articles set in the instance_blog table

						for($recommendedCounter = 0; $recommendedCounter <= $numRecommendedArts; $recommendedCounter++){

								mysqli_data_seek($recommendedArticles,$recommendedCounter);

								$recommendedArtQ = mysqli_fetch_array($recommendedArticles);

								#gets the recommended blog's title based off the ID in the blog_recommended_map table

								$recommendedArticleData = $blogObj->getConditionalRecord('priKeyID',$recommendedArtQ['recommendedBlogID'],true);

								

								

								$recommendedArticleDataQ = mysqli_fetch_array($recommendedArticleData);

						?>

								<div 

									class="recommendedArticle recommendedArticle-<?php echo $_GET['className'];?>"

									onclick="updatePageCopy(<?php echo $priModObj[0]->specificBlogPageID;?>,

															'viewBlogID=<?php echo $recommendedArtQ['recommendedBlogID'];?>'

															)"

								>

									<h2 

										class="recommendedArticleTitle"

									>

										<?php echo $recommendedArticleDataQ['blogTitle'];?>

									</h2>

						<?php

									#gallery

									if(is_numeric($instanceBlog->instanceGalleryID)){

										

										#get gallery id's for this blog

										$mappedGallery = $blogGalleryMapObj->getConditionalRecord("blogID",$recommendedArticleDataQ["priKeyID"],true);

					

										if(mysqli_num_rows($mappedGallery) > 0){

											

											$tempClassName = $_GET['className'];

											#increase module level

											++;

											

											#temp blog query

											$tempBlogQuery = $_GET["queryResults"];

													

											#get galleries for this blog

											$mapGal = mysqli_fetch_array($mappedGallery);

											

											#general instance properties

											include_once($_SERVER['DOCUMENT_ROOT']."/cmsAPI/module/publicModulePageMap.php");

											$pageModuleMapObj = new pageModuleMap(false);

											$galleryInstance = $pageModuleMapObj->getConditionalRecord(

																										"pageID",$_GET["pageID"],true,

																										"moduleID",56,true,

																										"instanceID",$instanceBlog->instanceGalleryID,true

																									  );

											$g = mysqli_fetch_array($galleryInstance);

											$_GET["headerText"] = $g["headerText"];

											$_GET["instanceDisplayType"] = $g["instanceDisplayType"];

											$_GET["displayQty"] = $g["displayQty"];

											$_GET["clickScroll"] = $g["clickScroll"];

											

											#gallery instance properties

											$_GET["galleryID"] = $mapGal["galleryID"];

											$_GET["className"] = $tempClassName . "-blogGallery-" . $tempBlogQuery["priKeyID"];

											$_GET["includeFile"] = "/public/galleries/gallery.php";

											$_GET["secondaryIncludeFile"] = "";

															

											$_GET["instanceID"] = $instanceBlog->instanceGalleryID;

											

											include($_SERVER['DOCUMENT_ROOT']."/public/moduleFrame/moduleFrame.php");

											

											#bring module level back to this module

											--;

											

											#set the primaryModuleQuery again

											$_GET["queryResults"] = $tempBlogQuery;

										}

									}

									

								?>

								</div>

						<?php

								

							}

							?>

							</div>

							<?php

						}

					}

				?>

					</div>

			<?php

				}	

			?>