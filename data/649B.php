<?php

namespace HeroesOfLegend;

return new NamedTable("649B", "Mental Affliction", DiceRoller::from("2d10"), [
	"2" => [ "Multiple personalities", function(State $s) {
		$pcount = Roll("d3");
		for($i = 1; $i <= $pcount; ++$i) {
			SubentryCreator("649Z", "Additional persona #".$i, null, function(State $s) {
				/* Make sure a trait develops, avoid 1-50 */
				$s->invokeTable("318A", DiceRoller::from("d50+50"));
				if(Roll("d100") <= 60) {
					$s->invoke("649");
				}
			})($s);
		}
	}],
	"3" => [ "Compulsive lying", DarksideTrait() ],
	"4" => [ "Paranoia", DarksideTrait() ],
	"5" => "Hallucinations (each occurence has 10% chance of catatonia)",
	"6" => "Catatonia (collapse in fetal position, withdrawn frow world)",
	"7" => [ "Megalomania (delusions of omnipotence and grandeur)", DarksideTrait() ],
	"8" => "Severy phobic (GM decides)",
	"9" => [ "Manic-depressive (alternating hyperactivity, unable to cope with everyday pressures)", DarksideTrait() ],
	"10" => [ "Hypochondria (unhealthy concern for health)", NeutralTrait() ],
	"11-12" => "Depression (all hope is gone, can get suicidal)",
	"13" => [ "Hysterical injury (believes he suffers an injury)", Invoker("870") ],
	"14-15" => [ "Obsessive behavior", SubtableInvoker(DiceRoller::from("d8"), [ /* Another book typo (d10). */
		"1" => [ "Devotion to a lightside trait", Invoker("647") ],
		"2" => [ "Devotion to a darkside trait", Combiner(Invoker("648"), DarksideTrait()) ],
		"3" => [ "Obsessive hatred", SubtableInvoker(DiceRoller::from("d3"), [
			/* Tableception! */
			"1" => "Any nonhuman",
			"2" => [ "Particular nonhuman race", Invoker("751") ],
			"3" => "Monsters",
			"4" => [ "Someone in particular", Invoker("750") ],
		])],
		"4" => [ "Obsessive need to destroy (target of choice)", DarksideTrait() ],
		"5" => "Obsessive need to clean",
		"6" => "Obsessively superstitious",
		"7" => [ "Obsessive need to collect some objects", SubtableInvoker(DiceRoller::from("d4"), [
			"1" => [ "A particular item", Invoker("863") ],
			"2" => "Gold (anything gold)",
			"3" => "Animals",
			"4" => "Beautiful things (includes people)",
		])],
		"8" => "Obsessive need to help others",
	])],
	"16" => [ "Kleptomania (impulse to steal)", DarksideTrait() ],
	"17" => [ "Pyromania (impulse to set things on fire and watch)", DarksideTrait() ],
	"18" => "Hysterical sense loss (character believes he is deaf or blind, GM decides)",
	"19" => [ "Berserker rage, mindless aggression", Combiner(DarksideTrait(), TableInvoker("868", new TrivialRoller(16))) ],
	"20" => [ "Multiple afflictions", Combiner(Repeater(Roll("d3+1"), Invoker("649B")), function(State $s) {
		if(Roll("d100") <= 60) {
			LineAdder("And afflictions are interrelated: one intensifies other")($s);
			LineAdder("or causes it to occur, or is the object/target of other")($s);
		}
	})],
]);
