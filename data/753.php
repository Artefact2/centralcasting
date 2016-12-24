<?php

namespace HeroesOfLegend;

/* XXX reroll nonsensical results */

return new NamedTable("753", "Relative", DiceRoller::from("d20"), [
	"1" => "First cousin", /* XXX */
	"2" => "Second cousin",
	"3" => "Distant cousin",
	"4" => function(State $s) {
		if($s->getActiveCharacter()->getAgeRange() !== Character::ADULT) {
			$s->invoke("753");
			return '';
		}
		return 'Son'; /* XXX track children */
	},
	"5" => function(State $s) {
		if($s->getActiveCharacter()->getAgeRange() !== Character::ADULT) {
			$s->invoke("753");
			return '';
		}
		return 'Daughter'; /* XXX track children */
	},
	"6" => function(State $s) {
		if($s->getActiveCharacter()->getNumSisters() > 0) {
			return "Sister";
		} else if($s->getActiveCharacter()->getNumBrothers() > 0) {
			return "Brother";
		}
		$s->invoke("753");
		return '';
	},
	"7" => function(State $s) {
		if($s->getActiveCharacter()->getNumBrothers() > 0) {
			return "Brother";
		} else if($s->getActiveCharacter()->getNumSisters() > 0) {
			return "Sister";
		}
		$s->invoke("753");
		return '';
	},
	"8" => "Spouse", /* XXX track spouse */
	"9" => "Aunt",
	"10" => "Uncle",
	"11" => "Great aunt",
	"12" => "Great uncle",
	"13" => function(State $s) {
		if($s->getActiveCharacter()->hasMother()) {
			return "Mother";
		}
		$s->invoke("753");
		return '';
	},
	"14" => function(State $s) {
		if($s->getActiveCharacter()->hasFather()) {
			return "Father";
		}
		$s->invoke("753");
		return '';
	},
	"15" => "Grandmother", /* XXX */
	"16" => "Grandfather", /* XXX */
	"17" => "Great grandmother",
	"18" => "Great grandfather",
	"19" => "Descendant (".Roll("d3+1")." generation(s))", /* XXX */
	"20" => "Unknown person claims to be related (GM special 978#753)",
]);
