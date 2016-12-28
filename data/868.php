<?php

namespace HeroesOfLegend;

return new NamedTable("868", "Curse", new DiceRoller("d20"), [
	"1" => Repeater(Roll("d4"), Invoker("648")),
	"2" => "-".Roll("d6")." Charisma or Appearance",
	"3" => [ "Character will be responsible for untimely death of lovers", Invoker("545") ],
	"4" => "Frequently fumble (10% chance each time a skill is used)",
	"5" => "Character becomes tongue-tied and cannot speak in presence of members of opposite sex",
	"6" => "Character becomes a lycanthrope (werewolf, etc.)",
	"7" => [ "One body location is monstrous and scaly", Invoker("867") ],
	"8" => "Can only join chaotic/evil cults/religions, all others will reject character",
	"9" => [ "Character has physical affliction", Invoker("874") ],
	"10" => "Character has recurring nightmares (loses sleep)",
	"11" => "Character acts like a Bad Luck Talisman (causes friends to fumble)",
	"12" => [ "Character attacked by fits of madness/mental disorder", Invoker("649B") ],
	"13" => [ "All character's children will be born under unusual circumstances and with a physical affliction",
	          Invoker("112", "874") ],
	"14" => [ "Tragedies occur in rapid succession", Repeater(Roll("d4"), Invoker("528")) ],
	"15" => "Character is unaffected carrier of virulent and deadly disease",
	"16" => "Character is subject to fits of berserker rage",
	"17" => "Condemned to nomadic life, cannot stay in one place/city/country for more than 1 year and 1 day",
	"18" => "Haunted and attacked by ghost/evil spirit every ".Roll("d100")." day(s)",
	"19" => "Will always be blamed for the commission of heineous acts that occur in same locale as character",
	"20" => [ "Combine curses in a logical manner:", Repeater(Roll("d3"), Invoker("868")) ],
]);
