<?php

Table($s, "114A", "Parents Occupation", Roll(20), [
	"1-12" => [ "Head of household has one occupation", function() use(&$s) {
			Invoke($s, "420-423");
		}],
	"13-14" => [ "Head of household has one full-time occupation and another part-time occupation", function() use(&$s) {
			$s->char->entries[] = [ "", "", "Full-time occupation:" ];
			Invoke($s, "420-423");
			$s->char->entries[] = [ "", "", "Part-time occupation:" ];
			$s->char->CuMod -= 2;
			Invoke($s, "420-423");
			$s->char->CuMod += 2;
		}],
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
	"17-18" => [ "Both parents in household have an occupation", function() use(&$s) {
			$s->char->entries[] = [ "", "", "Mother:" ];
			Invoke($s, "420-423");
			$s->char->entries[] = [ "", "", "Father:" ];
			Invoke($s, "420-423");
		}],
	"19" => [ "Head of household is/was an adventurer", function() use(&$s) {
			/* XXX 757 */
		}],
	"20" => [ "Head of household has no visible occupation, money just seems to be available when needed", function() use(&$s) {
			$s->char->entries[] = [ "", "", "See GM special 978#114" ];
		}],
]);
