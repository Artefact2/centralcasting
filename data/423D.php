<?php

namespace HeroesOfLegend;

return new NamedTable("423D", "Upper Class Occupation", DiceRoller::from("d20"), [
	"1" => "Alchemist",
	"2" => "Engineer",
	"3" => "Architect",
	"4" => "Doctor/surgeon",
	"5-7" => [ "Merchant", Invoker("425") ],
	"8" => [ "Craftsman", Invoker("424C") ],
	"9" => "Courtier/courtesan (attendant in the court of a noble ruler, sometimes just a fancy prostitute)",
	"10" => "Diplomat/negotiator",
	"11" => [ "Writer/playwrite/poet", function(State $s) {
		if(Roll("d100") <= 75) {
			LineAdder("And patron sponsors work")($s);
		}
	}],
	"12" => "Litigation trickster (lawyer/barrister)",
	"13" => "Philosopher (thinker, sage, etc.; wise or simply pompous)",
	"14" => [ "Craftsman", Invoker("424B") ],
	"15" => "Interpreter (probably for a government office or large merchant guild)",
	"16" => [ "Government official (if low position, in charge of)", Invoker("752") ],
	"17" => "Banker",
	"18" => [ "Business owner", Invoker("423A") ],
	"19" => "Landlord (".Roll("d10")." properties owned)",  /* XXX average social status */
	"20" => [ "Craftsmaster (local guild leader of said craft)", SubtableInvoker(DiceRoller::from("d6"), [
		"1-3" => Invoker("424A"),
		"4-5" => Invoker("424B"),
		"6" =>   Invoker("424C"),
	])],
]);
