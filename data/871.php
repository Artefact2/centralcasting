<?php

/*<<< Name: Special Nobility Title >>>*/

Invoke($s, "871A");
$pos = array_pop($s->char->entries);

Invoke($s, "871B");
$mod = array_pop($s->char->entries);

Invoke($s, "871C");
$loc = array_pop($s->char->entries);

$s->char->entries[] = [
	"871",
	"Special Nobility Title",
	$pos[2].' '.ltrim($mod[2].' '.$loc[2]),
];
