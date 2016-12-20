<?php

Table($s, "423C", "Middle Class Occupation", Roll(20), [
	"1" => "Money lender (loan shark)",
	"2-5" => [ "Merchant", Invoker($s, "425") ],
	"6" => [ "Business owner", Invoker($s, "423B") ],
	"7-8" => [ "Craftsman", Invoker($s, "424B") ],
	"9" => [ "Instructor", function() use(&$s) {
			switch(Roll(4)) {
			case 1:
			return "Instructor (weapon use)";

			case 2:
			/* XXX 876 */
			return "Instructor (unusual skill)";
			
			case 3:
			/* d4 decides */
			/* XXX 877A */
			/* XXX 877B */
			/* XXX 877C */
			/* XXX 877D */
			return "Instructor (military skill)";

			case 4:
			Invoke($s, [ "424A", "424B", "424C" ][Roll(3) - 1]);
			return "Instructor (craft)";
			
			}
		}],
	"10" => "Government official (if high position, assistant to)", /* XXX 752 */
	"11" => [ "Craftsman", Invoker($s, "424A") ],
	"12" => "Chef (restaurant or noble family)",
	"13" => [ "Overseer (supervisor) of industry:", Invoker($s, "423A") ],
	"14" => "Innkeeper",
	"15" => "Scribe",
	"16" => "Guide/Pilot",
	"17" => "Ship captain".(Roll(100) <= 10 + $s->char->SolMod ? " (has own ship)" : ""),
	"18" => "Engineer (may be tinkerer/mad inventor)",
	"19" => "Teacher",
	"20" => [ "Tavern owner", function() {
		$r = Roll(10);
		if($r === 10) return "Inn owner (road house or on highway)";
		if($r >= 7) return "Tavern owner (road house or on highway)";
	}],
]);

Invoke($s, "426");
