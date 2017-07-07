<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Facebook Like</title>
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=150851978301584&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like" data-href="<?php echo $_GET["shareURL"];?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
</body>
</html>