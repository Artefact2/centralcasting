<?php

/* XXX: develop parents further, table 114? */

Table($s, "754", "Guardian", Roll(1, 20), [
	"1-5" => [ "Relative", function() use(&$s) { Invoke($s, "753"); } ], /* XXX: generates a lot of nonsense */
	"6-8" => "Raised in an orphanage",
	"9-10" => [ "Adopted in another family", function() use(&$s) { Invoke($s, "106"); } ],
	"11" => [ "Raised by priests/monks in a temple", function() use(&$s) { Invoke($s, "864"); } ],
	"12" => "Raised by nonhumans", /* XXX */
	"13" => "Sold into indentured servitude to pay parent's depts", /* XXX */
	"14" => "Raised on the street by outcasts (beggars and prostitutes)",
	"15" => "Raised by a thieves' guild", /* XXX */
	"16" => "Passed from relative to relative until reaching the age of majority",
	"17" => "Raised by an adventurer", /* XXX */
	"18" => "Mysteriously disappears for ".Roll(1, 10)." year(s) without memories (GM special 978#754)",
	"19" => "Raised by beasts in the wild (wolves, tigers, bears, etc.)",
	"20" => "Raised by monsters", /* XXX */
]);