<?php

Table($s, "539C", "Death consequence", Roll(6), [
	"1" => "Sold to a new owner", /* XXX */
	"2" => [ "Freed", Invoker($s, "539B") ],
	"3" => [ "ALL owner possesions must be buried with him, but character escapes", Invoker($s, "539A") ],
	"4" => [ "All slaves now owned by owner's relative", function() use(&$s) { Invoke($s, "753"); } ],
	"5" => [ "Accused of killing the owner, escapes but death hangs over head", function() use(&$s) {
			/* XXX 545 */
			$s->char->enslaved = false;
		}],
	"6" => [
		"Freed by owners will and became heir ; assume control of all property and slaves",
		function() use(&$s) {
			if(Roll(10) < 5) {
				$s->char->enslaved = false;
				return;
			}
			$s->char->entries[] = [
				"", "",
				"But family has will voided, back to enslavement"
			];
		},
	]
]);
