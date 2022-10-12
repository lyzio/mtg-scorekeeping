<?php
include_once("../session_mysql.php");
$scoreboard = mysql_result(mysql_query("SELECT scoreboard_html FROM scoreboard WHERE pk_key_id = 1"),0);
$booth = mysql_result(mysql_query("SELECT scoreboard_html FROM scoreboard WHERE pk_key_id = 3"),0);

if($_POST && isset($_POST["text"])) {
	mysql_query("UPDATE scoreboard SET scoreboard_html = '".trim($_POST[text])."' WHERE pk_key_id = 1");
	echo json_encode(array("success"=>true, "booth" => $booth));
	die();
}
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
<body id="admin">
	<div id="scoreboard-wrapper">
<?php 
$findbooth = strpos($scoreboard, '<td class="inthebooth" colspan="3"><strong>');
$findbooth_end = strpos(substr($scoreboard, $findbooth),"</td>");
$scoreboard = substr_replace($scoreboard, $booth, $findbooth+$findbooth_end, 0);
/*		
		<table id="scoreboard">
			<thead>
			<tr>
				<th class="player1-life life"><em>11</em><span class="poison" style="display: block;">5</span></th>
				<th class="player1-name name"><span>3-1-1</span><em>JONATAN WÃ„RNs</em><span class="season-standings">1</span><strong>Kiki Pod</strong></th>
				<th class="player1-score score">0</th>
				<th class="logo"></th>
				<th class="player2-score score">0</th>
				<th class="player2-name name"><span class="season-standings">1</span><em>Mattias anderson</em><span>4-1</span><strong>Robots</strong></th>
				<th class="player2-life life"><em>17</em><span class="poison" style="">5</span></th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<td class="inthebooth" colspan="3"><strong>In the booth:</strong> <span>Pelle &amp; Alex</span></td>
				<td class="time">13:00</td>
				<td class="scvopen-info" colspan="3"><em>Scandinavian Open</em> <span>#scvopen</span> <i>www.scvopen.com</i> <strong>Round 1 of 10</strong></td>
			</tr>
			</tfoot>
		</table>*/
?>
	<?php echo $scoreboard;?>

	</div>

	<form action="" method="post" autocomplete="off">
		<table style="position: absolute; bottom: 2%;">
			<thead>
			<tr>
				<th class="player1-life life"><input type="text" autocomplete="off" name="player1life" value="20" tabindex="1" size="2" />
					<span class="poison">Poison: <input type="text" autocomplete="off" name="player1poison" value="0" tabindex="12" size="1" /></span>
					<button type="button" class="quickbutton player1 plus1" data-modifier="1">+1</button><button type="button" class="quickbutton player1 minus1" data-modifier="-1">-1</button><button type="button" class="quickbutton player1 plus5" data-modifier="5">+5</button><button type="button" class="quickbutton player1 minus5" data-modifier="-5">-5</button></th>
				<th class="player1-name name"><span><input type="text" name="player1stats" value="3-1" size="5" /></span><input type="text" name="player1name" value="Jon Westberg" size="20" /><strong><input type="text" class="season-standings" name="player1seasonstandings" value="" placeholder="Season Standing #" size="15" /> <input type="text" name="player1deck" value="RG Beats" size="15" /></strong></th>
				<th class="player1-score score"><input type="text" name="player1score" value="0" size="1" /></th>
				<th class="logo">Round start:<br />
					<input type="text" name="roundstart" autocomplete="off" value="15:00" size="5" />
					<i>(leave empty to<br />disable counter)</i>
					<div>
						<input type="submit" value="Update!" /><i>(or press enter<br />when in a field)</i>
					</div></th>
				<th class="player2-score score"><input type="text" name="player2score" value="1" size="1" /></th>
				<th class="player2-name name"><input type="text" name="player2name" value="Joel Larsson" size="20" /><span><input type="text" name="player2stats" value="3-0-1" size="5" /></span><strong><input type="text" name="player2deck" value="Golgari Durdle" size="15" /> <input type="text" class="season-standings" name="player2seasonstandings" value="" placeholder="Season Standing #" size="15" /></strong></th>
				<th class="player2-life life"><input type="text" autocomplete="off" name="player2life" tabindex="2" value="20" size="2" />
					<span class="poison">Poison: <input type="text" autocomplete="off" name="player2poison" value="0" tabindex="13" size="1" /></span>
					<button type="button" class="quickbutton player2 minus1" data-modifier="-1">-1</button><button type="button" class="quickbutton player2 plus1" data-modifier="1">+1</button><button type="button" class="quickbutton player2 minus5" data-modifier="-5">-5</button><button type="button" class="quickbutton player2 plus5" data-modifier="5">+5</button></th>
				</th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<td class="inthebooth" colspan="3"><strong><input type="text" name="inthebooth-text" value="In the booth" size="15" /></strong></td>
				<td class="time" ></td>
				<td class="scvopen-info" colspan="3"><input type="text" name="event" value="Scandinavian Open" size="25" /> <input type="text" name="hashtag" value="#scvopen" size="10" /> <input type="text" name="website" value="www.scvopen.com" size="20" /> <strong><input type="text" name="roundstats" value="Round 5 of 12" size="15" /></strong></td>
			</tr>
			</tfoot>
		</table>
	</form>
<script type="text/javascript">
$(document).ready(function(){
	$( "input[name='player1life'], input[name='player2life'], input[name='player1poison'], input[name='player2poison']" ).keyup(function( event ) {
		if ( event.which == 40 ) {
			event.preventDefault();
			$(this).val(parseInt($(this).val())-1);
		}
		if ( event.which == 38 ) {
			event.preventDefault();
			$(this).val(parseInt($(this).val())+1);
		}
	});
	$("form").on('submit',function(event){
		event.preventDefault();
		update();
	});
	$(".quickbutton").on('click',function(event) {
		event.preventDefault();
		var player = "player1";
		if($(this).hasClass("player2")) player = "player2";
		$("[name='"+player+"life']").val(parseInt($("[name='"+player+"life']").val())+parseInt($(this).data("modifier")));
		update();
	});
	reset_from_db();
	function reset_from_db() {
		$("[name='player1life']").val($("#scoreboard .player1-life em").text());
		$("[name='player2life']").val($("#scoreboard .player2-life em").text());

		$("[name='player1poison']").val($("#scoreboard .player1-life .poison").text());
		$("[name='player2poison']").val($("#scoreboard .player2-life .poison").text());

		$("[name='player1seasonstandings']").val($("#scoreboard .player1-name .season-standings").text());
		$("[name='player2seasonstandings']").val($("#scoreboard .player2-name .season-standings").text());

		$("[name='player1stats']").val($("#scoreboard .player1-name span:first").text());
		$("[name='player2stats']").val($("#scoreboard .player2-name span:last").text());

		$("[name='player1name']").val($("#scoreboard .player1-name em").text());
		$("[name='player2name']").val($("#scoreboard .player2-name em").text());

		$("[name='player1deck']").val($("#scoreboard .player1-name strong").text());
		$("[name='player2deck']").val($("#scoreboard .player2-name strong").text());

		$("[name='player1score']").val($("#scoreboard .player1-score").text());
		$("[name='player2score']").val($("#scoreboard .player2-score").text());

		$("[name='inthebooth-text']").val($("#scoreboard .inthebooth strong").text());

		$("[name='roundstats']").val($("#scoreboard .scvopen-info strong").text());
		$("[name='event']").val($("#scoreboard .scvopen-info em").text());
		$("[name='hashtag']").val($("#scoreboard .scvopen-info span").text());
		$("[name='website']").val($("#scoreboard .scvopen-info i").text());

		if($("[name='player1poison']").val() == "" || $("[name='player1poison']").val() == "0") {
			$("#scoreboard .player1-life .poison").hide();
		} else {
			$("#scoreboard .player1-life .poison").show();
		}
		if($("[name='player2poison']").val() == "" || $("[name='player2poison']").val() == "0") {
			$("#scoreboard .player2-life .poison").hide();
		} else {
			$("#scoreboard .player2-life .poison").show();
		}
		if($("[name='player1seasonstandings']").val() == "" || $("[name='player1seasonstandings']").val() == "0") {
			$("#scoreboard .player1-name .season-standings").hide();
		} else {
			$("#scoreboard .player1-name .season-standings").show();
		}
		if($("[name='player2seasonstandings']").val() == "" || $("[name='player2seasonstandings']").val() == "0") {
			$("#scoreboard .player2-name .season-standings").hide();
		} else {
			$("#scoreboard .player2-name .season-standings").show();
		}

		$("[name='roundstart']").val($("#scoreboard .time").text());

		$("#booth").addClass("both-here");
		$("#scoreboard-wrapper #booth div").each(function(){
			if($(this).html() == "") {
				$("#booth").removeClass("both-here");
			}
		});

		var starttime = $(".time:first").html();
		$(".time:first").countdown('destroy');
		if(starttime != "") {
			var liftoffTime = new Date();
			liftoffTime.setHours(starttime.substr(0, 2));
			liftoffTime.setMinutes(starttime.substr(3, 2));
			liftoffTime.setSeconds(00);
			$(".time:first").countdown({compact: true, since: liftoffTime, format: 'MS'});
		}

	}
	function update(){
		$("#scoreboard .player1-life em").text($("[name='player1life']").val());
		$("#scoreboard .player2-life em").text($("[name='player2life']").val());

		$("#scoreboard .player1-life .poison").text($("[name='player1poison']").val());
		$("#scoreboard .player2-life .poison").text($("[name='player2poison']").val());
		if($("[name='player1poison']").val() == "" || $("[name='player1poison']").val() == "0") {
			$("#scoreboard .player1-life .poison").hide();
		} else {
			$("#scoreboard .player1-life .poison").show();
		}
		if($("[name='player2poison']").val() == "" || $("[name='player2poison']").val() == "0") {
			$("#scoreboard .player2-life .poison").hide();
		} else {
			$("#scoreboard .player2-life .poison").show();
		}

		$("#scoreboard .player1-name .season-standings").text($("[name='player1seasonstandings']").val());
		$("#scoreboard .player2-name .season-standings").text($("[name='player2seasonstandings']").val());
		if($("[name='player1seasonstandings']").val() == "" || $("[name='player1seasonstandings']").val() == "0") {
			$("#scoreboard .player1-name .season-standings").hide();
		} else {
			$("#scoreboard .player1-name .season-standings").show();
		}
		if($("[name='player2seasonstandings']").val() == "" || $("[name='player2seasonstandings']").val() == "0") {
			$("#scoreboard .player2-name .season-standings").hide();
		} else {
			$("#scoreboard .player2-name .season-standings").show();
		}

		$("#scoreboard .player1-name span:first").text($("[name='player1stats']").val());
		$("#scoreboard .player2-name span:last").text($("[name='player2stats']").val());

		$("#scoreboard .player1-name em").text($("[name='player1name']").val());
		$("#scoreboard .player2-name em").text($("[name='player2name']").val());

		$("#scoreboard .player1-name strong").text($("[name='player1deck']").val());
		$("#scoreboard .player2-name strong").text($("[name='player2deck']").val());

		$("#scoreboard .player1-score").text($("[name='player1score']").val());
		$("#scoreboard .player2-score").text($("[name='player2score']").val());

		
		$("#scoreboard .inthebooth strong").text($("[name='inthebooth-text']").val());
		$("#scoreboard .scvopen-info strong").text($("[name='roundstats']").val());
		$("#scoreboard .scvopen-info em").text($("[name='event']").val());
		$("#scoreboard .scvopen-info span").text($("[name='hashtag']").val());
		$("#scoreboard .scvopen-info i").text($("[name='website']").val());
		$("#scoreboard .time:first").removeClass("is-countdown").text($("[name='roundstart']").val());
		$("#scoreboard .inthebooth div").remove();

		var html = $("#scoreboard-wrapper").html();
	    $.ajax({
	        url: "admin.php",
	        type: "post",
	        data: { 
	            text: html
	        },
	        success: function(data){
	        	var obj = $.parseJSON(data);
	        	$(obj.booth).insertAfter(".inthebooth:first strong:first");
	        	console.log(obj.booth);

				$("#booth").addClass("both-here");
				$("#scoreboard-wrapper #booth div").each(function(){
					if($(this).html() == "") {
						$("#booth").removeClass("both-here");
					}
				});

				var starttime = $("[name='roundstart']").val();
				$(".time:first").countdown('destroy');
				if(starttime != "") {
					var liftoffTime = new Date();
					liftoffTime.setHours(starttime.substr(0, 2));
					liftoffTime.setMinutes(starttime.substr(3, 2));
					liftoffTime.setSeconds(00);
					$(".time:first").countdown({compact: true, since: liftoffTime, format: 'MS'});
				}
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