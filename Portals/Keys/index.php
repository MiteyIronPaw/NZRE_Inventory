<?php
	session_start();
	include $_SESSION['path']."/Tools/database.php";
	include $_SESSION['path']."/Tools/getPortalInfo.php";
?>
<html>
	<?php include $_SESSION['path']."/Tools/head.php";?>
	<body>
		<?php include $_SESSION['path']."/Tools/menu.php";?>
		<p>
			<form action="update.php" method="post" autocomplete="off">
				Update Keys<br>
				<?php
					$Names = array();
					$result = selectFrom("PortalTable", null, null);
					while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
						array_push($Names,$row['PortalName']);
					}
				
					natcasesort ($Names);
				
					foreach($Names as $Name){
						$OldKeysQuerry = selectFrom("KeyTable", array("username", "portalID"), array($_SESSION['name'], getPortalID($Name)));
						$OldKeysArray = mysqli_fetch_array($OldKeysQuerry);
						$OldKeys = $OldKeysArray['NumKeys'];	
						if($OldKeys==""){$OldKeys=0;}
						
						echo "<div id=\"lineTall\"><div id=\"Left\">".$Name."</div><div id=\"Right\">";
						echo "<input style=\"width:60px;\" class=\"fieldShort\" type=\"text\" name=\"".getPortalID($Name)."\" autocomplete=\"off\" value=\"".$OldKeys."\">";
						echo "</div></div>";
					}
				?>
				<br>
				<input class="button" type="submit" value="Update">
			</form>
		</p>
		<div id="line"><a href="../">Cancel</a></div>
	</body>
</html>
