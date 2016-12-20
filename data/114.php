<?php

Table($s, "114A", "Parents Occupation", Roll(20), [
	"1-12" => [ "Head of household has one occupation", Invoker($s, "420-423") ],
	"13-14" => [ "Head of household has one full-time occupation and another part-time occupation", Combiner(
		EntryAdder($s, "Full-time occupation:"),
		Invoker($s, "420-423"),
		EntryAdder($s, "Part-time occupation:"),
		CharIncrementer($s, "CuMod", -2),
		Invoker($s, "420-423"),
		CharIncrementer($s, "CuMod", 2)
	)],
	"15-16" => [ "Head of household has no occupation, other parent works", function() use(&$s) {
			$sub = 0;
			
			switch(Roll(6)) {
			case 6:
				$sub = -2;
				break;

			case 4:
			case 5:
				$sub = 2;
				break;
			}

			$s->char->CuMod -= $sub;
			Invoke($s, "420-423");
			$s->char->CuMod += $sub;
		}],
	"17-18" => [ "Both parents in household have an occupation", Combiner(
		EntryAdder($s, "Mother:"),
		Invoker($s, "420-423"),
		EntryAdder($s, "Father:"),
		Invoker($s, "420-423")
	)],
	"19" => "Head of household is/was an adventurer", /* XXX 757 */
	"20" => [ "Head of household has no visible occupation, money just seems to be available when needed",
	          EntryAdder($s, "See GM special 978#114")
	],
]);
