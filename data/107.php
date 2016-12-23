<?php

namespace HeroesOfLegend;

$produceSiblings = function(int $c) {
	return function(State $s) use($c) {
		$genders = [ 0, 0 ];
		while(--$c >= 0) {
			++$genders[(int)(Roll("d20") <= 9)];
		}
		
		$ac = $s->getActiveCharacter();
		$ac->setNumBrothers($ac->getNumBrothers() + $genders[0]);
		$ac->setNumSisters($ac->getNumSisters() + $genders[1]);
		$s->invoke("108");

		$result = [];
		if($genders[0] > 0) $result[] = $genders[0]." brother(s)";
		if($genders[1] > 0) $result[] = $genders[1]." sister(s)";
		return implode(" and ", $result);
	};
};

return new NamedTable("107", "Siblings", DiceRoller::from("d20"), [
	"1-2" => function(State $s) {
		if($s->getActiveCharacter()->getNumIllegitSiblings() > 0) {
			return "No legitimate siblings";
		} else {
			return "No siblings";
		}
	},
	"3-9" => $produceSiblings(Roll("d3")),
	"10-15" => $produceSiblings(Roll("d3+1")),
	"16-17" => $produceSiblings(Roll("d4+2")),
	"18-19" => $produceSiblings(Roll("2d4")),
	"20" => Combiner(
		Invoker("107"),
		function(State $s) {
			$c = Roll("d3");
			$ac = $s->getActiveCharacter();
			$ac->setNumIllegitSiblings($ac->getNumIllegitSiblings() + $c);

			$genders = [ 0, 0 ];
			while(--$c >= 0) {
				++$genders[(int)(Roll("d20") <= 9)];
			}

			$result = [];
			if($genders[0] > 0) $result[] = $genders[0]." illegitimate brother(s)";
			if($genders[1] > 0) $result[] = $genders[1]." illegitimate sister(s)";
			LineAdder(implode(" and ", $result))($s);
		}),
]);
