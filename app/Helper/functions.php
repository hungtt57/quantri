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
function check_format($type,$value){
	if($value==config('setting.'.$type)){
		
		return 'checked';
	}
}




function get_timezone_list(){

	$timezone= timezone_list();

	foreach ($timezone as $key => $value) {
		if($key==config('setting.timezone')) {
			echo "<option value='$key' selected='selected'>$value</option>";
		} else {
			echo "<option value='$key'>$value</option>";
		}
		
	}
}


// get list time zone php
function timezone_list() {
    static $timezones = null;

    if ($timezones === null) {
        $timezones = [];
        $offsets = [];
        $now = new DateTime();

        foreach (DateTimeZone::listIdentifiers() as $timezone) {
            $now->setTimezone(new DateTimeZone($timezone));
            $offsets[] = $offset = $now->getOffset();
            $timezones[$timezone] = '(' . format_GMT_offset($offset) . ') ' . format_timezone_name($timezone);
        }

        array_multisort($offsets, $timezones);
    }

    return $timezones;
}

function format_GMT_offset($offset) {
    $hours = intval($offset / 3600);
    $minutes = abs(intval($offset % 3600 / 60));
    return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
}

function format_timezone_name($name) {
    $name = str_replace('/', ', ', $name);
    $name = str_replace('_', ' ', $name);
    $name = str_replace('St ', 'St. ', $name);
    return $name;
}
// end get list timezone php
?>