<?php

namespace HeroesOfLegend;

return new NamedTable("874", "Physical Affliction", new DiceRoller("d20"), [
	"1" => "Hunchbacked (-".($d = Roll("d3"))." Dexterity, -".($c = Roll("d6"))." Charisma or Appearance, +".($d+$c)." to other attributes of choice)",
	"2" => "Character grows much larger than species normal (".Roll("d5+1*10")."% larger than average, -1 Dexterity)",
	"3" => "Character does not grow to normal size (".Roll("d5+1*10")."% shorter than average, not below 85% of species minimum)",
	"4" => [ "Character has glowing eyes", function(State $s) {
		if(Roll("d100") <= 60) {
			LineAdder("And eyes have unusual color")($s);
			LineAdder("And grant some power")($s);
			$s->invoke("865");
			SubtableInvoker(new DiceRoller("d4"), [
				"1" => [ "Psychic ability", Invoker("873") ],
				"2" => "A magical spell effect (GM decides)",
				"3" => "Shoot 2d6 damage heat ray",
				"4" => "X-ray vision through walls",
			])($s);
		}
	}],
	"5" => [ "Character has extra eye in middle of forehead", function(State $s) {
		if(Roll("d2") === 1) {
			LineAdder("And eye grants infravision (sense heat patterns in the dark)")($s);
		}
	}],
	"6" => "Character is an albino (-".($c = Roll("d6"))." Constitution, +".Roll(($c - 1)."+d".(7 - $c))." Magical Ability, sensible to strong sunlight)",
	"7" => "Body covered in fur, same color as hair (+1 Constitution, +1 natural armor, -".Roll("d4")." Appearance)",
	"8" => "Character has webbed fingers and toes (+1 rank in swimming)",
	"9" => "Character is a true hermaphrodite and has androgynous physical appearance",
	"10" => "Character can modify Charisma or Appearance (+d10 above normal score, -6 points if not using power)",
	"11" => function(State $s) {
		if(Roll("d4") === 1) LineAdder("And character can fly (same speed as griffin)")($s);
		return Roll("d2") === 1 ? "Born with bat wings" : "Born with bird wings";
	},
	"12" => function(State $s) {
		LineAdder("Unarmed attacks with claw do +2 damage")($s);
		return Roll("d2") === 1 ? "Left hand is a scaly claw" : "Right hand is a scaly claw";
	},
	"13" => [ "Character has unusually colored skin (-d4 Charisma or Appearance when meeting a new person)", Invoker("865") ],
	"14" => "+".Roll("d6")." Strength", /* No reason at all? WTF, book */
	"15" => "+".Roll("d10")." Intelligence, -".Roll("d6")." Charisma or Appearance",
	"16" => [ "Character has psychic power", Invoker("873") ],
	"17" => [ "Character has unusually colored hair", Invoker("865") ],
	"18" => "Character has scaly skin (+2 natural armor, -".Roll("d4")." Appearance or Charisma)",
	"19" => "Character has rectactable fangs (venomous like a viper)",
	"20" => [ "Multiple afflictions", Repeater(Roll("d2+1"), Invoker("874")) ],
]);
