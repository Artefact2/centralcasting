<?php

namespace HeroesOfLegend;

return new NamedTable("755", "Criminal", DiceRoller::from("d20"), [
	"1" => "Murderer",
	"2" => "Kidnapper",
	"3" => "Thief (member of a guild, usually a burglar)",
	"4" => "Pickpocket",
	"5" => "Extortionist or blackmailer",
	"6" => "Confidence artist (con man)",
	"7" => "Armed robber (bank robber)",
	"8" => "Highwayman (usually a loner)",
	"9" => "Bandit (part of a gang)",
	"10" => "Professional assassin",
	"11" => "Drug dealer",
	"12" => "Mugger (rubs lone victims)",
	"13" => "Horse thief",
	"14" => "Rustler (steals livestock)",
	"15" => "Thug (muscleman for a gang)",
	"16" => "Pimp (runs prostitution)",
	"17" => "Prostitute",
	"18" => "Gang leader",
	"19" => "Rapist",
	"20" => "Pirate",
]);
