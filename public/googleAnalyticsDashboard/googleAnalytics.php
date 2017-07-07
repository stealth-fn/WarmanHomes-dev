<?php
	if(!isset($_SESSION)) session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Google Analytics</title>
	<style>
		<?php
			require($_SERVER['DOCUMENT_ROOT'] . '/css/public/googleAnalyticsDashboard/googleAnalyticsDashboard.php');
		?>
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>

<body>
	<?php
		require($_SERVER['DOCUMENT_ROOT'] . '/public/googleAnalyticsDashboard/googleAnalyticsDashboard.php');
	?>
	<script>
		<?php
			require($_SERVER['DOCUMENT_ROOT'] . '/public/googleAnalyticsDashboard/googleAnalyticsDashboardJS.php');
		?>
	</script>
</body>
</html>