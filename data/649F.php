<?php

namespace HeroesOfLegend;

$nt = new NamedTable("649F", "Sexual Disorder", DiceRoller::from("2d8"), [
	"2" => "Transsexualism",
	"3" => "Complete disinterest (no sexual desire)",
	"4" => "Shyness",
	"5" => "Homosexuality",
	"6" => "Bisexuality",
	"7" => "Transvestism",
	"8" => "Nymphomania/satyrism",
	"9" => "Sadism",
	"10" => "Masochism",
	"11" => [ "Too prude", function(State $s) {
		if(Roll("d8") >= 6) {
			LineAdder("Character is actively suppressing another disorder")($s);
			$s->invokeTable("649F", new RerollFilter(DiceRoller::from("2d8"), function($r) { return $r !== 11; }));
		}
	}],
	"12" => "Voyeurism",
	"13" => [ "Fetichism", SubtableInvoker(DiceRoller::from("d10"), [
		"1" => "Women's clothing (not for wearing)",
		"2" => "Men's clothing (not for wearing)",
		"3" => "Shoes",
		"4" => "Hair (particularly woman's hair)",
		"5" => Invoker("867"),
		"6" => "Animal (of choice)",
		"7" => Invoker("649C"),
		"8" => Invoker("863"),
		"9" => Invoker("750"),
		"10" => Invoker("753"),
	])],
	"14" => "Necrophilia",
	"15-16" => Repeater(Roll("d2+1"), Invoker("649F")),
]);

$nt->addPostExecuteHook(DarksideTrait());
return $nt;
