<?php

namespace HeroesOfLegend;

return new NamedTable("536", "Noncombat Duty", new DiceRoller("d20"), [
	"1-3" => [ "Noncombat occupation within the army", Invoker("420-423") ],
	"4-5" => "Medical corps, gain rank 2 first aid skill (+1 rank every 2 years)",
	"6" => "Recruiter (character recruits, drafts and shanghais new recruits)",
	"7" => "Quartermaster corps (provide supplies to military frontlines)",
	"8" => function(State $s) {
		if($s->getActiveCharacter()->getMilitaryRank() > 0) {
			return 'Instructor';
		}

		$s->invoke("536");
		return '';
	},
	"9" => "Engineer (design & build camps, bridges, etc.)",
	"10" => "Messenger",
	"11" => "Cook",
	"12" => "Medium Infantry: embassy guard in a foreign land",
	"13" => [ "Medium Infantry: mage guard (guards the military's contingent of wizards)", function(State $s) {
		if(Roll("d2") === 1) {
			LineAdder("And exotic event occurs")($s);
			$s->invoke("544");
		}
	}],
	"14" => "Medium Infantry: prison guard",
	"15" => "Medium Infantry: payroll guard",
	"16" => "Medium Infantry: city guard",
	"17" => "Medium Infantry: private body guard of army leader",
	"18" => "Medium Infantry: palace guard",
	"19" => "Medium Infantry: temple guard",
	"20" => "Medium Infantry: border guard",
]);
