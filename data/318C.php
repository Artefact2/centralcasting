<?php

$l = $s->char->traits['L'];
$d = $s->char->traits['D'];
$n = $s->char->traits['N'];

if($l >= max($d, $n) + 2) {
	$alignment = "Lightsided";
} else if($d >= max($l, $n) + 2) {
	$alignment = "Darksided";
} else {
	$alignment = "Neutral";
}

$s->char->entries[] = [ "318C", "Alignment", $alignment ];
