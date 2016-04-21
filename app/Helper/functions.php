<?php
function role_select($data, $select_name=""){
	foreach ($data as $value) {
		$name = $value->name;
		if(strcmp($name, $select_name) == 0) {
			echo "<option value='$name' selected='selected'>$name</option>";
		} else {
			echo "<option value='$name'>$name</option>";
		}
	}
}
?>