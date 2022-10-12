<?php
include_once("../session_mysql.php");

$scoreboard = mysql_result(mysql_query("SELECT scoreboard_html FROM scoreboard WHERE pk_key_id = 1"),0);
$booth = mysql_result(mysql_query("SELECT scoreboard_html FROM scoreboard WHERE pk_key_id = 3"),0);

$findbooth = strpos($scoreboard, '<td class="inthebooth" colspan="3"><strong>');
$findbooth_end = strpos(substr($scoreboard, $findbooth),"</td>");
$scoreboard = substr_replace($scoreboard, $booth, $findbooth+$findbooth_end, 0);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
	<title>Scoreboard</title>
    <link type="text/css" rel="stylesheet" href="scoreboard.css?v=201" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="jquery.plugin.min.js"></script>
	<script src="jquery.countdown.min.js"></script>
</head>
<body id="index">
	<div id="scoreboard-wrapper">
		<?php echo $scoreboard;?>
	</div>

<script type="text/javascript">
var fixFooter = function() {
	$("tfoot td").css("padding-top",$(window).height()-$("thead").height()-34);
};
$(document).ready(function(){
	fixFooter();
	$(window).resize(function(){
		fixFooter();
	});

	$("#scoreboard-wrapper .poison").each(function(){
		if($(this).html() != "0" && $(this).html() != "") {
			$(this).css("display","block");
		}
	});
	$("#booth").addClass("both-here");
	$("#scoreboard-wrapper #booth div").each(function(){
		if($(this).html() == "") {
			$("#booth").removeClass("both-here");
		}
	});

	var starttime = $(".time").html();
	var liftoffTime = new Date();
	liftoffTime.setHours(starttime.substr(0, 2));
	liftoffTime.setMinutes(starttime.substr(3, 2));
	liftoffTime.setSeconds(00);
	$("#scoreboard-wrapper").attr("id","wrapz0rz");
	window.setInterval(function() {
		$.get("index.php #scoreboard-wrapper", function(html) {
			var obj = $(html);
			$("#wrapz0rz thead").replaceWith(obj.find("thead"));
			$("#wrapz0rz .poison").each(function(){
				if($(this).html() != "0" && $(this).html() != "") {
					$(this).css("display","block");
				}
			})
			$("#wrapz0rz tfoot td:first").html(obj.find("tfoot td:first").html());
			$("#wrapz0rz tfoot td:last").html(obj.find("tfoot td:last").html());
			$("#wrapz0rz #booth").addClass("both-here");
			$("#wrapz0rz #booth div").each(function(){
				if($(this).html() == "") {
					$("#wrapz0rz #booth").removeClass("both-here");
				}
			});
			//time changed?
			if(starttime != obj.find(".time").html()) {
				starttime = obj.find(".time").html();
				$(".time").countdown('destroy');

				if(starttime != "") {
					var liftoffTime = new Date();
					liftoffTime.setHours(starttime.substr(0, 2));
					liftoffTime.setMinutes(starttime.substr(3, 2));
					liftoffTime.setSeconds(00);
					$(".time").countdown({compact: true, since: liftoffTime, format: 'MS'});
				}
			}
		});
	},2000);
	if(starttime != "") {
		$(".time").countdown({compact: true, since: liftoffTime, format: 'MS'});
	}
});
</script>
</body>
</html>