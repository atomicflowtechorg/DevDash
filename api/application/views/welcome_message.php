<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to DevDashAPI</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>
</head>
<body>

<h1>Welcome to DevDashAPI!</h1>

<p>The page you are looking at is being generated dynamically by DevDashAPI.</p>

<ul>
	<li><a href="<?php echo site_url('api/users');?>">Users</a> - defaulting to XML</li>
	<li><a href="<?php echo site_url('api/users/format/csv');?>">Users</a> - get it in CSV</li>
	<li><a href="<?php echo site_url('api/user/username/lucasmp');?>">User lucasmp</a> - defaulting to JSON</li>
	<li><a href="<?php echo site_url('api/user/username/lucasmp/format/xml');?>">User lucasmp</a> - get it in XML</li>
	<li><a id="ajax" href="<?php echo site_url('api/users/format/json');?>">Users</a> - get it in JSON (AJAX request)</li>
</ul>

<p>If you are exploring DevDashAPI for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>

<p><br />Page rendered in {elapsed_time} seconds</p>

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	// Bind a click event to the 'ajax' object id
	$("#ajax").bind("click", function( evt ){
		// Javascript needs totake over. So stop the browser from redirecting the page
		evt.preventDefault();
		// AJAX request to get the data
		$.ajax({
			// URL from the link that was clicked on
			url: $(this).attr("href"),
			// Success function. the 'data' parameter is an array of objects that can be looped over
			success: function(data, textStatus, jqXHR){
				alert('Successful AJAX request!');
			}, 
			// Failed to load request. This could be caused by any number of problems like server issues, bad links, etc. 
			error: function(jqXHR, textStatus, errorThrown){
				alert('Oh no! A problem with the AJAX request!');
			}
		});
	});
});
</script>

</body>
</html>