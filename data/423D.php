<?php

Table($s, "423D", "Upper Class Occupation", Roll(20), [
	"1" => "Alchemist",
	"2" => "Engineer",
	"3" => "Architect",
	"4" => "Doctor/surgeon",
	"5-7" => [ "Merchant", Invoker($s, "425") ],
	"8" => [ "Craftsman", Invoker($s, "424C") ],
	"9" => "Courtier/courtesan (attendant in the court of a noble ruler, sometimes just a fancy prostitute)",
	"10" => "Diplomat/negotiator",
	"11" => "Writer/playwrite/poet".(Roll(100) <= 75 ? " (patron sponsors work)" : ""),
	"12" => "Litigation trickster (lawyer/barrister)",
	"13" => "Philosopher (thinker, sage, etc.; wise or simply pompous)",
	"14" => [ "Craftsman", Invoker($s, "424B") ],
	"15" => "Interpreter (probably for a government office or large merchant guild)",
	"16" => [ "Government official (if low position, in charge of)", Invoker($s, "752") ],
	"17" => "Banker",
	"18" => [ "Business owner", Invoker($s, "423A") ],
	"19" => "Landlord (".Roll(10)." properties owned)",  /* XXX average social status */
	"20" => [ "Craftsmaster (local guild leader of said craft)", function() use(&$s) {
			switch(Roll(6)) {
			case 1:
			case 2:
			case 3:
			Invoke($s, "424A");
			break;

			case 4:
			case 5:
			Invoke($s, "424B");
			break;

			Invoke($s, "424C");
			}
		}],
]);
