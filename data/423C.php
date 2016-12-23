<?php

namespace HeroesOfLegend;

return new NamedTable("423C", "Middle Class Occupation", DiceRoller::from("d20"), [
	"1" => "Money lender (loan shark)",
	"2-5" => [ "Merchant", Invoker("425") ],
	"6" => [ "Business owner", Invoker("423B") ],
	"7-8" => [ "Craftsman", Invoker("424B") ],
	"9" => [ "Instructor", SubtableInvoker(DiceRoller::from("d4"), [
		"1" => "Weapon use",
		"2" => [ "Unusual skill", Invoker("876") ],
		"3" => [ "Military skill", Invoker([ "877A", "877B", "877C", "877D" ][Roll("d4-1")]) ],
		"4" => [ "Craft", Invoker([ "424A", "424B", "424C" ][Roll("d3-1")]) ],
	])],
	"10" => [ "Government official (if high position, assistant to)", Invoker("752") ],
	"11" => [ "Craftsman", Invoker("424A") ],
	"12" => "Chef (restaurant or noble family)",
	"13" => [ "Overseer (supervisor) of industry:", Invoker("423A") ],
	"14" => "Innkeeper",
	"15" => "Scribe",
	"16" => "Guide/Pilot",
	"17" => [ "Ship captain", function(State $s) {
		if(Roll("d100") <= 10 + $s->getActiveCharacter()->getModifier('SolMod')) {
			LineAdder("And has own ship")($s);
		}
	}],
	"18" => "Engineer (may be tinkerer/mad inventor)",
	"19" => "Teacher",
	"20" => [ "Tavern owner", function() {
		$r = Roll("d10");
		if($r === 10) return "Inn owner (road house or on highway)";
		if($r >= 7) return "Tavern owner (road house or on highway)";
	}],
]);
