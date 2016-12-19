<?php

$s->char->siblings = 0;
$s->char->illegitSiblings = 0;

$table = function() use(&$s, &$table) {
	Table($s, "107", "Siblings", Roll(20), [
		"1-2" => null,
		"3-9" => [ null, function() use(&$s) { $s->char->siblings += Roll(3); }],
		"10-15" => [ null, function() use(&$s) { $s->char->siblings += Roll(3) + 1; }],
		"16-17" => [ null, function() use(&$s) { $s->char->siblings += Roll(4) + 2; }],
		"18-19" => [ null, function() use(&$s) { $s->char->siblings += Roll(2, 4); }],
		"20" => [ null, function() use(&$s, &$table) { $s->char->illegitSiblings += Roll(3); $table(); }],
	]);
};
$table();

$illegit = $legit = [ 'm' => 0, 'f' => 0 ];
for($i = 0; $i < $s->char->siblings; ++$i) {
	$legit[Roll(20) <= 9 ? 'm' : 'f']++;
}
for($i = 0; $i < $s->char->illegitSiblings; ++$i) {
	$illegit[Roll(20) <= 9 ? 'm' : 'f']++;
}

$siblings = [];

if($legit['m'] > 0) $siblings[] = $legit['m'].' brother(s)';
if($legit['f'] > 0) $siblings[] = $legit['f'].' sister(s)';

if($illegit['m'] > 0) $siblings[] = $illegit['m'].' illegitimate brother(s)';
if($illegit['f'] > 0) $siblings[] = $illegit['f'].' illegitimate sister(s)';

if($siblings === []) {
	$siblings[] = 'None, only child';
}

$s->char->entries[] = [ "107", "Siblings", implode(', ', $siblings) ];

if($s->char->siblings > 0) {
	Invoke($s, "108");
}

unset($s->char->siblings);
unset($s->char->illegitSiblings);
