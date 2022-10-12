<?php
include_once("../session_mysql.php");
include_once("../include/kortparm_functions.php");
if($_REQUEST["cardname"]) {
    $id = mysql_result(mysql_query("SELECT id FROM cards
	INNER JOIN exp_info ON cards.exp = exp_info.exp
	WHERE name = '".$_REQUEST["cardname"]."' AND cards.exp != 'Oversize Cards' ORDER BY exp_info.release DESC"), 0);
}
else if($_REQUEST["id"]) $id = intval($_REQUEST["id"]);
elseif($_GET["reload"]) {
    $id = mysql_result(mysql_query("SELECT scoreboard_html FROM scoreboard WHERE pk_key_id = 2"),0);
    if($_GET["getid"]) {
        echo json_encode(array("id"=>$id));
        die();
    }
}
$kort_sql = mysql_query("SELECT * FROM cards
	INNER JOIN exp_info ON cards.exp = exp_info.exp
	LEFT OUTER JOIN illustrators ON pk_illustrator_id = fk_illustrator_id
	WHERE id = '$id' AND cards.exp != 'Oversize Cards' ORDER BY exp_info.release DESC");
if(mysql_num_rows($kort_sql)) $kort = mysql_fetch_array($kort_sql);
$bildurl = getCardPic($kort);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
	<title>Card viewer<?php if(mysql_num_rows($kort_sql)) echo " - ".$kort[name]; if($kort[exps]) echo " (".$kort[exp].")";?></title>
    <link type="text/css" rel="stylesheet" href="scoreboard.css?v=201" />
    <style type="text/css">
    body {
    	background-image: none;
    	text-align: center;
    	color: #222;
        font-family: "Open Sans";
        margin: 0;
        padding: 0;
    }
    #shadow {
        box-shadow: 0px 1px 10px 5px #000;
        width: 100%;
        height: 0px;
        position: absolute;
        top: 0;
    }
    #shadow2 {
        box-shadow: 0px -1px 10px 5px #000;
        width: 100%;
        height: 0px;
        position: fixed;
        bottom: 0;
    }
    input[type='text'] {
        font-size: 20px;
    }
    input[type='submit'] {
        font-size: 20px;
    }
    .clear {
        clear: both;
    }
    div#right img {
    	width: 410px;
    	height: 584px;
        border: 15px solid black;
        border-radius: 8px;
        box-shadow: 0px 5px 3px #000;
    }
    div#right img.white {
        border-color: #fff;
    }
    h1, h2, div#right p {
    	margin: 0;
    }
    h1 {
    	font-size: 28px;
        margin-top: 5px;
    }
    h2 {
    	font-weight: normal;
    	font-size: 24px;
    }
    div#right p {
    	margin-top: 40px;
    	color: #65b3ec;
    	font-style: italic;
    	font-size: 24px;
    	font-weight: normal;
    	line-height: normal;
    }
    div#right p a {
        color: #65b3ec;
        text-decoration: none;
    }
    div#right p a:hover {
        text-decoration: underline;
    }
    div#left-column {
    	float: left;
    	text-align: center;
    	padding: 50px;
    }
    div#right {
    	width: 440px;
    	float: right;
    	padding: 20px;
    	color: #fff;
    }
    .ui-helper-hidden-accessible {
        display: none;
    }
.ui-autocomplete.ui-widget.ui-widget-content  {
    max-width: 300px;
    text-align: left;
    list-style-type: none;
    padding-left: 0px;
    font-size: 12px;
    color:#000;
    filter:alpha(opacity=95);
    -moz-opacity:.95;
    opacity:.95;
    -moz-box-shadow: 0px 0px 2px #999;
    -webkit-box-shadow: 0px 0px 2px #999;
    box-shadow: 0px 0px 2px #999;
}
.ui-autocomplete.ui-widget.ui-widget-content li a.ui-corner-all {
    display: block;
    background-color: #f5f5dc; border-left: #FFFFE5 1px solid; border-right: none; border-bottom: #D2D2BC 1px solid;
    padding: 3px;
    border-radius: 0px;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
}
.ui-autocomplete.ui-widget.ui-widget-content li a.ui-corner-all.auto-member {
    background-color: #E7F2E6;
    border-left: 1px solid #E7F2E6;
    border-bottom: 1px solid #bed1bc;
}
.ui-autocomplete.ui-widget.ui-widget-content li a.ui-corner-all span {
    font-size: 10px;
    color: darkgrey;
}
.ui-autocomplete.ui-widget.ui-widget-content li:nth-child(even) a {
    background-color: #f5f5e9; border-left: #f5f5dc 1px solid; border-right: none; border-bottom: #FFFFE5 1px solid;
}
.ui-autocomplete.ui-widget.ui-widget-content li:nth-child(even) a.auto-member {
    background-color: #f1fcf0;
    border-left: 1px solid #def5dc;
    border-bottom: 1px solid #e8ffe5;
}
.ui-autocomplete.ui-widget.ui-widget-content li a.ui-state-hover, .ui-autocomplete.ui-widget.ui-widget-content li a.ui-state-focus {
    border-bottom: #315b7f 1px solid;
    border-left: #3c709c 1px solid;
    border-right: none;
    border-top: none;
    background: #3c709c!important;
    color: #E9EAF5!important;
    cursor: pointer;
    font-weight: normal;
}
.ui-autocomplete.ui-widget.ui-widget-content li a.ui-state-hover span, .ui-autocomplete.ui-widget.ui-widget-content li a.ui-state-focus span {
    color:#a4bfd4;
}
.ui-autocomplete img {
    width: 30px; height: 30px; margin-right: 5px; vertical-align: middle;
}
.ui-autocomplete img.friend {
    width: auto; height: auto; margin-left: 3px; margin-right: 3px;
}
.ui-autocomplete { height: 200px; overflow-y: scroll; overflow-x: hidden;}
</style>
    <script src="/javascript/default.js"></script>
	<script src="//code.jquery.com/jquery-1.9.0.min.js"></script>
    <script src="//code.jquery.com/ui/1.9.0/jquery-ui.min.js" type="text/javascript"></script>
</head>
<body><div id="shadow"></div><div id="shadow2"></div>
<div id="left-column">	
	<form action="card.php" method="get">
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
        $('input[type="text"]').focus().autocomplete({
            source: "/jqacquery.php?type=textareacards",
            hidden: "#hidden",
            maxLength: 25,
            minLength: 3,
            results: 10,
            autoFocus: true,
            select: function(event, ui) {
                window.location.href = "?id="+ui.item.value;
            },
              focus: function( event, ui ) {
                //$( 'input[type="text"]' ).val( ui.item.cardname );
                return false;
              },
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            if(item.label) {
                first_tag = item.label.indexOf("]");
                end_tag = item.label.indexOf("[/");
                label = item.label.substring(first_tag+1, end_tag);
            }
            else label = item.label;

            if(item.exp) link_string = "<a class='auto-"+item.item_type+"'><img src=\""+ item.img +"\" />" + label + " <span>("+item.exp+")</span></a>";
            else link_string = "<a class='auto-"+item.item_type+"'><img src=\""+ item.img +"\" />" + label + "</a>";

            return $( "<li>" )
                .data( "item.autocomplete", item )
                .append( link_string )
                .appendTo( ul );
        };			});
        <?php if($_GET["reload"]) { ?>
        var reloadz = window.setInterval(function(){
            $.get("card.php?reload=true&getid=true",function(data){
                data = $.parseJSON(data);
                if(data.id == <?=$id;?>) {
                    //alert('samma');
                } else {
                    window.location.reload();
                }
            });
        },2000);
        <?php } elseif($_GET["id"]) {
            mysql_query("UPDATE scoreboard SET scoreboard_html = '".$_GET["id"]."' WHERE pk_key_id = 2");
        }
        ?>
		</script>
			
		<input type="text" placeholder="Search for cardname..." name="cardname" id="kortparm_sok" size="30" border="0" />
        <input type="hidden" name="hidden" id="hidden" />
		<input type="submit" value="View card" />
	</form>
</div>	
<div id="right">	
	<img onError="cardPicError(this)" src="<?php echo $bildurl;?>" id="card" class="<?=$kort[border_color];?>" />
	<h1><?php echo stripslashes($kort["name"]);?></h1>
	<h2><?php echo stripslashes($kort["exp"]);?><?php echo in_array($kort["rarity"],array("C","U","R","MR")) ? " (".rarity2readable($kort["rarity"]).")" : "";?></h2>
<?php
if(false && $kort[exps]){
	echo "<p>Also in:<br />";
	$expansionerna=explode(",", $kort[exps]);
	$x = 1;
    $idna=explode(',', $kort[ids]);
	foreach($expansionerna as $key => $en_expansion) { 
		echo "<a href='?id=".$idna[$key]."'>".$en_expansion."</a>";
		if(count($expansionerna) > 1 && $x++ != count($expansionerna)) echo ", ";
	}
	echo "</p>";
}
?>
</div>
<div class="clear"></div>

</body>
</html>
<?php 
function rarity2readable($string) {
    if($string == "C") return "Common";
    elseif($string == "U") return "Uncommon";
    elseif($string == "R") return "Rare";
    elseif($string == "MR") return "Mythic";
}