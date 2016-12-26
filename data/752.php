<?php

namespace HeroesOfLegend;

return new NamedTable("752", "Government Official", DiceRoller::from("d20"), [
	"1" => "Scribe (note taker, transcribes laws)",
	"2" => "Clerk (office worker)",
	"3" => "City guard/constable (policeman)",
	"4" => "Guard captain/chief constable",
	"5" => "Sheriff (law and order in village, shire or county)",
	"6" => "Tax collector",
	"7" => "Magistrate (courtroom judge, limited authority)",
	"8" => "Diplomat/ambassador",
	"9" => "City ruler (mayor, manor lord, petty baron, etc.)",
	"10" => "Advisor to ruler (counselor)",
	"11" => "Chief advisor to ruler (like prime minister)",
	"12" => "Governor (rules over a colony/territory)",
	"13" => "Judge",
	"14" => "Secret policeman (undercover)",
	"15" => "Soldier (paid member of standing army)",
	"16" => [ "Army officer", Invoker("538") ],
	"17" => "Bureaucrat",
	"18" => "Senator",
	"19" => [ "Government employee", Invoker("420-423") ],
	"20" => "Spy (covert agent)",
]);
