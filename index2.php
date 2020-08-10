<?php
$text = 'PHp rules';
if(preg_match('/PHP/i', $text))
{
	echo 'Text PHP found in $text';
} else
{
	echo 'Not found';
}

$time = time();