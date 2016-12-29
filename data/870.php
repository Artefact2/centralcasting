<?php

namespace HeroesOfLegend;

/* XXX implement proper posthook with (1) (2) etc. */

return new NamedTable("870", "Serious Wound", DiceRoller::from("d20"), [
	"1" => function() {
		if(Roll("d100") <= 50) {
			return "Impressive facial scar (+1 Charisma)";
		} else {
			return "Impressive facial scar (-1 Charisma)";
		}
	},
	"2" => [ "Impressive body scars", Invoker("867") ],
	"3" => function(State $s) {
		LineAdder("Depth perception is gone, -1 rank in all combat/visual skills")($s);
		
		if(Roll("d2") === 1) {
			return "Left eye put out";
		} else {
			return "Right eye put out";
		}
	},
	"4" => "Lost ".Roll("d4")." teeth",
	"5" => function(State $s) {
		if(Roll("d10") >= 7) {
			LineAdder("Permanent hearing loss, -2 ranks in all listening skills, -1 Appearance")($s);
		}
			
		if(Roll("d2") === 1) {
			return "Left ear torn or cut off";
		} else {
			return "Right ear torn or cut off";
		}
	},
	"6" => "Disfigurement, -".Roll("d10")." Appearance, -".Roll("d10")." Charisma",
	"7" => [ "Brain damage caused by head injury", Invoker("870A") ],
	"8" => "Injury causes constant pain, -1 Dexterity, -1 Strength, Intelligence check to concentrate",
	"9" => "Knee injury, slow and constant limp, Intelligence check to concentrate, -25% movement speed",
	"10" => [ "Body part permanently severed", Invoker("870B") ],
	"11" => "Injury heals badly, -1 Dexterity, -1 Strength",
	"12" => "Foot injury causes constant limp, -25% movement speed",
	"13" => "Lung damage (racking cough and pain), Intelligence check to concentrate, -1 Constitution",
	"14" => "Stomach injury (recurrent nausea, -d10 ranks in skills while nauseated)",
	"15" => "Kidney damage, need to drink 3-4x normal amount of water, -1 Constitution",
	"16" => "Genital injury (no sex drive)",
	"17" => "Throat injury (".Roll("d10*10")."% voice loss)",
	"18" => "Back injury, -".Roll("d6")." Strength",
	"19" => "Liver damage, alcohol becomes poisonous, -1 Constitution",
	"20" => Repeater(Roll("d2+1"), Invoker("870")),
], RandomTable::REROLL_DUPLICATES);
