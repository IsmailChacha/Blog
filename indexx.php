<?php
function display($data)
{
	echo '<pre>' . print_r($data, true) . '</pre>';
	echo '<br/>';
}

$array = array();
$array = ['Name' => 'Ismail Chacha', 'Age' => 22];

display(array_change_key_case($array, CASE_UPPER));

$array = ['Ismail' => 22, 'Habiba' => 8, 'Saum' => 6, 'Shaaban' => 20, 'Ramadan' => 17];
display(array_chunk($array, 2, true));

$array = array(
	array(
		'id' => 1,
		'first_name' => 'Ismail',
		'last_name' => 'Chacha'
	),
	array(
		'id' => 2,
		'first_name' => 'Saum',
		'last_name' => 'Kaduka'
	),
	array(
		'id' => 3,
		'first_name' => 'Shaaban',
		'last_name' => 'Boke'
	)
);

display(array_column($array, 'last_name'));

$names = ['Ismail', 'Habiba', 'Saum'];
$ages = [22, 9, 6];

display(array_combine($names, $ages));

display(array_count_values($names));

$array = ['a' => 'red', 'b' => 'blue', 'c' => 'green', 'd' => 'violet'];
$array2 = ['a' => 'red', 'f' => 'blue', 'g' => 'green'];
$array3 = ['h' => 'indigo'];
display(array_diff($array, $array2, $array3));
display(array_diff_assoc($array, $array2));
display(array_diff_key($array, $array2));

function comparisonFunction($a, $b)
{
	if($a === $b)
	{
		return 0;
	}
	return ($a>$b) ? 1:-1;
}

$array = ['a' => 'red', 'b' => 'blue', 'c' => 'green'];
$array2 = ['d' => 'aliceblue', 'b' => 'blue', 'e' => 'green'];

$result = array_diff_uassoc($array, $array2, 'comparisonFunction');
display($result);

$result = array_diff_ukey($array, $array2, 'comparisonFunction');
display($result);

$colors = [];
display(array_fill(0, 5, 'ghostwhite')); 

display(array_fill_keys($names, 'The Mohammed\'s'));

$array = [2, 3, 4, 5,  6];
function test_even($array)
{
	return ($array & 1);
}

display(array_filter($array, 'test_even'));
$array = ['a' => 'red', 'b' => 'blue', 'c' => 'cream'];
display(array_flip($array));

$array = ['a' => 'azure', 'b' => 'salmon', 'c' => 'maroon', 'd' => 'khaki'];
$array2 = ['a' => '#ccc', 'y' => 'brown', 'x' => 'maroon'];
display(array_intersect_key($array, $array2));

display(array_keys($array));
unset($array['c']);
display(array_values($array));
