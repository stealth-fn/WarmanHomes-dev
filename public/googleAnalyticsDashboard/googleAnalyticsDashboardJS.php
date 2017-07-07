/*load javascript google api*/
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));

function precise_round(num,decimals){
	var sign = num >= 0 ? 1 : -1;
	return (Math.round((num*Math.pow(10,decimals))+(sign*0.001))/Math.pow(10,decimals)).toFixed(decimals);
}

function secondsToHms(d) {
	d = Number(d);
	var h = Math.floor(d / 3600);
	var m = Math.floor(d % 3600 / 60);
	var s = Math.floor(d % 3600 % 60);
	return ((h > 0 ? h + ":" + (m < 10 ? "0" : "") : "") + m + ":" + (s < 10 ? "0" : "") + s); 
}

//call back for when our analytics loads
setupAnalytics = function() {
	
	//authorize our user
	gapi.analytics.auth.authorize({
		'serverAuth': {
			'access_token': '<?php echo $_SESSION["access_token"]; ?>'
		}
	});
  
  	//define what site we want access to
	var request = gapi.client.analytics.management.profiles.list({
		'accountId': '<?php echo $_SESSION["googleAccountID"]; ?>',
		'webPropertyId': '<?php echo $_SESSION["googleAnalyticsCode"]; ?>'
	});
	request.execute(printViews);
	
	function printViews(results) {
		if (results && !results.error) {
			var profiles = results.items;
			for (var i = 0, profile; profile = profiles[i]; i++) {
			
			//create our graph	
  			var dataChart1 = new gapi.analytics.googleCharts.DataChart({
				query: {
					'ids': 'ga:' + profile.id, // The Demos & Tools website view.
					'start-date': '30daysAgo',
					'end-date': 'yesterday',
					'metrics': 'ga:sessions,ga:users',
					'dimensions': 'ga:date'
				},
				chart: {
					'container': 'chart-1-container',
					'type': 'LINE',
					'options': {
						'width': '85%'
				  	}
				}
			});
		 
			dataChart1.execute();
			
			//get our page views, users, etc
			var report = new gapi.analytics.report.Data({
				query: {
					'ids': 'ga:' + profile.id, 
					metrics: 'ga:sessions,ga:users,ga:pageviews,ga:pageViewsPerSession,ga:avgSessionDuration,ga:bounceRate,ga:percentNewSessions',
					'start-date': '30daysAgo',
					'end-date': 'yesterday',
				}
			});
				
			report.on('success', function(response) {	
				$("#stat0").append(response.rows[0][0]);
				$("#stat1").append(response.rows[0][1]);
				$("#stat2").append(response.rows[0][2]);
				$("#stat3").append(precise_round(response.rows[0][3],2));
				$("#stat4").append(secondsToHms(response.rows[0][4]));
				$("#stat5").append(precise_round(response.rows[0][5],2));
				$("#stat6").append(precise_round(response.rows[0][6],2));
			});
					
			report.execute();
			
			//get our events... forms, phone, social media etc		
			var report2 = new gapi.analytics.report.Data({
				query: {
					'ids': 'ga:' + profile.id, 
					metrics: 'ga:totalEvents',
					dimensions: 'ga:eventCategory',
					'start-date': '30daysAgo',
					'end-date': 'yesterday',
				}
			});
					
			report2.on('success', function(response) {
				if(typeof response.rows !== "undefined"){
					for (var i = 0, gEvent; gEvent = response["rows"][i]; i++) {
						$("#googleStatsContainer").append(
							'<div><span>' + gEvent[0] + ":</span>" + gEvent[1] +'</div>'
						);
					}
				}
			});
					
			report2.execute();

			}
		}
	}
};

gapi.analytics.ready(setupAnalytics);