<?php

Table($s, "216B", "Special Event of Adolescence", Roll(20), [
	"1" => "Learn to use a weapon (of choice, rank 3, culture appropriate)",
	"2" => [ "Character gets tatooed with unusual marking", Invoker($s, 866) ],
	"3-4" => [ "Apprenticed to learn an occupation (always at age 13)", Combiner(NeutralTrait($s), Invoker($s, "419")) ],
	"5" => "Wizard or priest teaches character a simple spell",
	"6" => [ "Character is accused of crime he did not commit", Invoker($s, "217B") ],
	"7" => [ "Character learns unusual skill", Invoke($s, "876") ],
	"8" => [ "Character acquires hobby", Invoke($s, "427") ],
	"9" => "Learn head of household occupation (".Roll(3)." rank(s))",
	"10" => [ "Character joins the military", Combiner(
		RandomTrait($s),
		function() use(&$s) {
			$s->char->entries[] = [ "", "", "Reason for joining: ".([
				"character was drafted during wartime",
				"character patriotically volunteered",
				"character was rounded up by press gang who needed to meet quota",
				"character mistakenly thought he was applying for another job",
			][Roll(4) - 1])];
		},
		Invoker($s, "535")
	)], /* XXX C/P from 217 */
	"11" => [ "Participate in rebellion against local authority", Combiner(RandomTrait($s), function() use(&$s) {
				if(Roll(10) >= 9) {
					$s->char->entries[] = [ "", "", "And it succeeded" ];
				} else {
					$s->char->entries[] = [ "", "", "And it failed" ];
					if(Roll(10) === 10) {
						$s->char->entries[] = [ "", "", "And character is now an outlaw" ];
					} else {
						$s->char->entries[] = [ "", "", "Only few close friends know of the character's participation" ];
					}
				}
			})], /* XXX C/P from 217 */
	"12" => [ "Character becomes well-known/famous for the event:", Combiner(NeutralTrait($s), Invoker($s, "215")) ],
	"13-14" => [ "Character has romantic encounter (ignore children/marriage if <16 or social status too far apart)", Combiner(
		RandomTrait($s),
		Invoker($s, "542")
	)],
	"15" => "Character learns another language (of choice, rank 3)",
	"16" => [ "Race-specific event", Combiner(RandomTrait($s), Invoker($s, "530-533")) ],
	"17" => [ "Exotic event occurs", Combiner(RandomTrait($s), Invoker($s, "544")) ],
	"18" => [ "Tragedy occurs", Combiner(RandomTrait($s), Invoker($s, "528")) ],
	"19" => [ "Something wonderful occurs", Combiner(RandomTrait($s), Invoker($s, "529")) ],
	"20" => [ "Character is older than usual at beginning of adventuring carreer", Repeater(Roll(3) - 1, Invoker($s, "217")) ],
]);
