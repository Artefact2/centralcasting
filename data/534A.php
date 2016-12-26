<?php

namespace HeroesOfLegend;

return new NamedTable("534A", "Wrong Path", DiceRoller::from("d10"), [
	"1" => "Character needs money to pay debts",
	"2" => "Peer pressure 'forces' character to do criminal acts",
	"3" => "Character has pathological urge to do wrong",
	"4" => "Character wants to defy authority",
	"5" => "Character feels he is punishing those responsible for misdeeds done to him",
	"6" => "Character wants to live a lifestyle he could not afford otherwise",
	"7" => "Character seeks a lifestyle filled with dangerous thrills and excitement",
	"8" => "Character seeks to wield power in crime world",
	"9" => "Character is forced into a life of crime by criminals who threaten his loved ones",
	"10" => Repeater(2, Invoker("534A")),
], RandomTable::REROLL_DUPLICATES);
