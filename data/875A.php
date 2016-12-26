<?php

namespace HeroesOfLegend;

return new NamedTable("875A", "Crime Type", DiceRoller::from("d20"), [
	"1" => "Burglary (breaking, entering and stealing) (D), (2) or (14)",
	"2" => "Racketeering (running organized crime operations) (8)",
	"3" => "Heresy (religious wrong thinking, speaking or doing) (9)",
	"4" => "Murder (10), (D)",
	"5" => [ "Sex-related crime", SubtableInvoker(DiceRoller::from("d6"), [
		"1" => "Adultery (13), (17)", /* XXX not always applicable */
		"2" => "Rape (8), (DD)",
		"3" => "Illegal prostitution (1)",
		"4" => "Immorality (1) or (13)",
		"5" => "Creating pornography (3)",
		"6" => "Child molesting (4), (D)",
	])],
	"6" => "Offending an influential person (7), (D)",
	"7" => "Trespassing (1), (D)",
	"8" => [ "Special situation regarding crime or punishment", SubtableInvoker(DiceRoller::from("d10"), [
		"1-6" => [ "Character framed for something he did not do",
		           TableInvoker("875A", new RerollFilter(DiceRoller::from("d20"), function($r) { return $r !== 8; })) ],
		"7-8" => [ "Branded for crime (17)",
		           TableInvoker("875A", new RerollFilter(DiceRoller::from("d20"), function($r) { return $r !== 8; })) ],
		"9" => [ "Tortured to reveal accomplices (16)",
		         TableInvoker("875A", new RerollFilter(DiceRoller::from("d20"), function($r) { return $r !== 8; })) ],
		"10" => [ "Another person suffers in the character's place", Combiner(Invoker("750"),
			TableInvoker("875A", new RerollFilter(DiceRoller::from("d20"), function($r) { return $r !== 8; }))
		)],
	])],
	"9" => "Treason against state or its ruler (16), (10), (17)",
	"10" => "Failure to pay debts or taxes (4)",
	"11" => "Character was member of losing faction in political struggle (4)",
	"12" => "Violation of curfew (13)",
	"13" => [ "Armed robbery", SubtableInvoker(DiceRoller::from("d4"), [
		"1" => "Banditry (5), (D)",
		"2" => "Mugging (3), (D)",
		"3" => "Holding up a money lender (5)",
		"4" => "Freeing slaves at weapon point (4), (13)",
	])],
	"14" => "Piracy (6), (17)",
	"15" => "Harboring criminals (4)",
	"16" => "Larceny (picking pockets, stealing from shop, etc.) (1) or (15) or (14)",
	"17" => [ "Animal-related crime", SubtableInvoker(DiceRoller::from("d4"), [
		"1" => "Poaching (13)",
		"2" => "Horse theft (3), (13)",
		"3" => "Livestock rustling (2)",
		"4" => "Killing livestock (14)",
	])],
	"18" => "Assault and battery (1), (D)",
	"19" => "Selling drugs (7), (12)",
	"20" => [ "Two linked crimes:", Repeater(2, Invoker("875A")) ],
]);
