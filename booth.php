<?php
include_once("../session_mysql.php");
$booth = mysql_result(mysql_query("SELECT scoreboard_html FROM scoreboard WHERE pk_key_id = 3"),0);

if($_POST && isset($_POST["text"])) {
	mysql_query("UPDATE scoreboard SET scoreboard_html = '".trim($_POST[text])."' WHERE pk_key_id = 3");
	echo json_encode(array("success"=>true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
	<title>Booth</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="jquery.plugin.min.js"></script>
	<style type="text/css">
@import url(//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700);

#booth {
	position: relative;	
}
#commentator1, #commentator2 {
	position: absolute;
	left: 14.35%;
	top: 27px;
	width: 15.8%;
	text-align: center;
	text-shadow: 0px 0px 5px #162733;
	font-size: 120%;
	text-transform: capitalize;
}
#commentator2 {
	left: 70.4%;
}
body {
	font-family: "Open Sans", "Arial", sans-serif;
	color:#fff;
	font-size:100%;
	padding:0;
	font-weight: bold;
	margin:0;
}
body {
	background:#940101;
}
<?php if($_REQUEST["preview"]) { ?>
body {
	background:#fff url('scvopen-booth.png?v=23') no-repeat;
	background-size: 100%;
}
<?php } ?>
input {
	font-family: "Open Sans";
	font-weight: bold;
}
table {
	width: 100%;
	border-collapse: collapse;
	margin:0;
	padding:0;
}
em, i {
	font-style: normal;
}
table * {
	margin:0;
	padding:0;
}
#admin form tr {
	vertical-align: top;
}
tfoot td {
	padding-top: 20px;
}
#admin tfoot td {
	padding-top: 0px;
}
table th, table td {
	background: #142531;
}
table th {
	padding: 1% 0;
}

th.logo {

}
th.logo div {

}
th.logo i {
	font-style: italic;
	font-size: 40%;
	font-weight: normal;
	display: block;
	color:#fff228;
}
th.logo input[type="submit"] {
	background: green;
	border:1px solid #000;
	color: #fff;
	padding:5px 10px;
	border-radius: 5px;
	box-shadow: 0px 5px 5px #000;
}
th.logo input[type="submit"]:active {
	background: blue;
}
th.name {
	font-size:200%;
	width: 33.1%;
	text-align: right;
	text-transform: uppercase;
	line-height: 90%;
	padding-right: 1%;
}
th.name span {
	font-size: 50%;
	color:#fff228;
	margin-right: 2%;
}
th.name.booth2-name {
	text-align: left;
}
th.name.booth2-name span {
	margin-left: 2%;
	margin-right: 0;
}
th.name strong {
	font-family: "Hit the Road";
	font-size: 75%;
	display: block;
	color:#6dc1ff;
	text-transform: none;
	margin-top: 5px;
}
input[type='text'] {
	font-size: 80%;
}
input[type='text'].roundstats, input[name='booth1name'], input[name='booth2name'] {
	text-transform: capitalize;
}
input[type="text"].season-standings {
	font-size: 10px;
}
	</style>
</head>
<body id="admin">
	<div id="booth-wrapper">
		<?=$booth;?>
	</div>

	<form action="" method="post" autocomplete="off">
		<table style="position: absolute; bottom: 0%;">
			<thead>
			<tr>
				<th class="booth1-name name"><input type="text" name="booth1name" value="" placeholder="Kommentator #1" size="20" /></th>
				<th class="logo">
					<div>
						<input type="submit" value="Update!" /><i>(or press enter<br />when in a field)</i>
					</div></th>
				<th class="booth2-name name"><input type="text" name="booth2name" value="" placeholder="Kommentator #2" size="20" /></th>
			</tr>
			</thead>
		</table>
	</form>
<script type="text/javascript">
$(document).ready(function(){
	$("form").on('submit',function(event){
		event.preventDefault();
		update();
	});
	reset_from_db();
	function reset_from_db() {
		$("[name='booth1name']").val($("#booth #commentator1").text());
		$("[name='booth2name']").val($("#booth #commentator2").text());

	}
	window.setInterval(function() {
		$.get("booth.php #booth-wrapper", function(html) {
			var obj = $(html);
			$("#booth-wrapper #commentator1").replaceWith(obj.find("#commentator1"));
			$("#booth-wrapper #commentator2").replaceWith(obj.find("#commentator2"));
		});
	},5000);

	function update(){
		$("#booth #commentator1").text($("[name='booth1name']").val());
		$("#booth #commentator2").text($("[name='booth2name']").val());

		var html = $("#booth-wrapper").html();
	    $.ajax({
	        url: "booth.php",
	        type: "post",
	        data: { 
	            text: html
	        },
	        success: function(msg){

	        },
	        error:function(msg){
	            alert("failure, try again!");
	        }   
	    }); 


	}
});
</script>
</body>
</html>