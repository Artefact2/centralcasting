<?php

namespace HeroesOfLegend;

return new NamedTable("114B", "Noteworthy Item", DiceRoller::from("d20"), [
	"1" => [ "NPC is noted for his personality", SubtableInvoker(DiceRoller::from("d6"), [
		"1-3" => Invoker("647"),
		"4-5" => Invoker("648"),
		"6" => Invoker("649"),
	])],
	"2" => [ "NPC had unusual birth circumstance(s)", Repeater(Roll("d3"), Invoker("113")) ],
	"3" => [ "NPC devotes time to a hobby", Invoker("427") ],
	"4" => [ "NPC has unusual item", Invoker("863") ],
	"5" => "NPC is creative, inventive, possibly artistic",
	"6" => [ "NPC was affected by exotic event, often spoken about", Invoker("544") ],
	"7" => "NPC tells tales of legendary lost treasure, vague hints about its location",
	"8" => [ "NPC is obsessed about something", SubtableInvoker(DiceRoller::from("d6"), [
		"1" => [ "A relationship with someone", Invoker("750") ],
		"2" => [ "A significant event from the past", Invoker("215") ],
		"3" => [ "Working out of a personality trait", Invoker(Roll("d2") === 1 ? "648" : "647") ],
		"4" => "Accomplishment of a motivation (figure it out)", /* XXX */
		"5" => [ "Accomplishing a future event", Invoker("217") ],
		"6" => [ "Preventing a future event", Invoker("217") ],
	])],
	"9" => "NPC has secret identity (select social status and occupation)", /* XXX */
	"10" => [ "NPC has patron", Invoker("543") ],
	"11" => [ "NPC is military veteran", Invoker("535A") ],
	"12" => [ "NPC is very religious/evangelizing, seeks to convert others", Invoker("864") ],
	"13" => [ "NPC is noted for/hesitant to speak about past event:", SubtableInvoker(DiceRoller::from("d4"), [
		"1" => [ "Famous/hero for occurence of significant event", Invoker("217") ],
		"2" => [ "Persecuted/villainized for occurence of significant event", Invoker("217") ],
		"3" => "Important in home village/town/city",
		"4" => "But won't speak about it (GM decides, table 217)",
	])],
	"14" => [ "NPC has special relationship with family:", SubtableInvoker(DiceRoller::from("d4"), [
		"1" => "Particularly loving towards family",
		"2" => "Does not love family or children",
		"3" => "Is unfaithful to spouse",
		"4" => "Has married more than once, current spouse is number ".Roll("d4"), /* XXX is 1 meaningful? d3+1? */
	])],
	"15" => [ "NPC originally from different culture", function(State $s) {
		/* Book doesn't say, but obviously same culture gets rerolled */
		$ae = $s->getActiveCharacter()->getActiveEntry();
		do {
			foreach($ae->getChildren() as $c) $ae->removeChild($c);
			CharacterSandboxer(true, $p, Invoker("102"))($s);
		} while($p->getModifier('CuMod') === $s->getActiveCharacter()->getModifier('CuMod'));
	}],
	"16" => [ "NPC originally of different social status", function(State $s) {
		/* See previous case */
		$ae = $s->getActiveCharacter()->getActiveEntry();
		do {
			foreach($ae->getChildren() as $c) $ae->removeChild($c);
			CharacterSandboxer(true, $p, Invoker("103"))($s);
		} while($p->getModifier('SolMod') === $s->getActiveCharacter()->getModifier('SolMod'));
	}],
	"17" => "NPC from foreign land",
	"18" => [ "NPC has friends/ennemies", SubtableInvoker(DiceRoller::from("d6"), [
		"1" => [ "Has rival", function(State $s) {
			$s->invoke("762");
			if($s->getActiveCharacter()->getType() === Character::PC && Roll("d6") >= 5) {
				LineAdder("Rival actively seeks out character")($s);
			}
		}],
		"2" => "Has ".Roll("d10+2")." ennemies", /* XXX book likely wrong about generating 10+ rivals at once */
		"3" => "Has ".Roll("d10+2")." close friends (like family)",
		"4" => "Has ".Roll("d6+1")." jilted ex-lovers",
		"5" => [ "Has companion", Invoker("761") ],
		"6" => function(State $s) use(&$anon) {
			$anon->execute($s);
			$anon->execute($s);
		},
	], RandomTable::REROLL_DUPLICATES, $anon)],
	"19" => [ "NPC was horribly wounded once", Invoker("870") ],
	"20" => [ "NPC noted for very exotic personality (possibly real weirdo)", Repeater(Roll("d3"), Invoker("649")) ],
]);
