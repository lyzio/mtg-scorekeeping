<?php
include_once("../session_mysql.php");
$bracket = mysql_result(mysql_query("SELECT scoreboard_html FROM scoreboard WHERE pk_key_id = 7"),0);

if($_POST && isset($_POST["text"])) {
	mysql_query("UPDATE scoreboard SET scoreboard_html = '".trim($_POST[text])."' WHERE pk_key_id = 7");
	echo json_encode(array("success"=>true, "booth" => $booth));
	die();
}
$x = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
	<title>Invitational Top3</title>
    <link type="text/css" rel="stylesheet" href="bracket.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="jquery.plugin.min.js"></script>
	<script src="jquery.countdown.min.js"></script>
</head>
<body id="admin">
	<img src="scv-inv.png" alt="" id="logo" style="width: auto; margin-top: -20px; margin-bottom: -40px;"/>
	<form action="" method="post">
	<div id="bracket-wrapper">
		<?php echo $bracket;?>
		<?php /*
		<table>
			<tr>
				<td class="player" style="border: none;">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
					<em><input spellcheck="false" type="text" class="deckname" name="deckname[<?=$x++;?>]" value="" /></em>
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td class="player right" style="border: none;">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
					<em><input spellcheck="false" type="text" class="deckname" name="deckname[<?=$x++;?>]" value="" /></em>
				</td>
			</tr>
			<tr>
				<td class="border-right" style="border: none;"></td>
				<td class="player semifinal">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
				</td>
				<td></td>
				<td></td>
				<td class="player semifinal right" style="border: none;">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
				</td>
				<td></td>
			</tr>
			<tr>
				<td class="player no-right-border" style="border: none;">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
					<em><input spellcheck="false" type="text" class="deckname" name="deckname[<?=$x++;?>]" value="" /></em>
				</td>
				<td class="border-right"></td>
				<td></td>
				<td></td>
				<td class=""></td>
				<td class="player right no-left-border">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
					<em><input spellcheck="false" type="text" class="deckname" name="deckname[<?=$x++;?>]" value="" /></em>
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="border-right"></td>
				<td class="player final"><p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></td>
				<td class="player final right" style="border: none!important;"><p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="player" style="border: none;">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
					<em><input spellcheck="false" type="text" class="deckname" name="deckname[<?=$x++;?>]" value="" /></em>
				</td>
				<td class="border-right"></td>
				<td></td>
				<td></td>
				<td class="no-left-border"></td>
				<td class="player right" style="border: none;">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
					<em><input spellcheck="false" type="text" class="deckname" name="deckname[<?=$x++;?>]" value="" /></em>
				</td>
			</tr>
			<tr>
				<td class="border-right" style="border: none;"></td>
				<td class="player semifinal no-right-border">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
				</td>
				<td></td>
				<td></td>
				<td class="player semifinal right no-left-border">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
				</td>
				<td class="no-left-border"></td>
			</tr>
			<tr>
				<td class="player no-right-border" style="border: none;">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
					<em><input spellcheck="false" type="text" class="deckname" name="deckname[<?=$x++;?>]" value="" /></em>
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td class="player right no-left-border">
					<p><input spellcheck="false" type="text" class="player-input" name="player[<?=$x;?>]" value="" /></p>
					<em><input spellcheck="false" type="text" class="deckname" name="deckname[<?=$x++;?>]" value="" /></em>
				</td>
			</tr>
		</table>
		*/ ?>

	</div>
	<input type="submit" style="position: absolute; top: -99999px;" value="Submit" />
	</form>
	

	</div>
	<style type="text/css">
	td:not(.final, .semifinal) {
		opacity: 0;
	}
	.right:not(.final) {
		opacity: 0;
		border: none;
	}
	</style>

<script type="text/javascript">
$(document).ready(function(){
	$("form").on('submit',function(event){
		event.preventDefault();
		update();
	});
	reset_from_db();
	function reset_from_db() {

	}
	$("input").each(function(){
		if($(this).closest("td").css("opacity") == 0) {
			$(this).remove();
		}
	})
	$("input:visible").on('blur',function(){
		$("form").submit();
	});
	function update(){
		$("input").each(function(){
			$(this).attr("value",$(this).val());
		})
		var html = $("#bracket-wrapper").html();
	    $.ajax({
	        url: "top3.php",
	        type: "post",
	        data: { 
	            text: html
	        },
	        success: function(data){
	        	var obj = $.parseJSON(data);
	        	console.log(obj);
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