<?php
namespace Iannsp\PhpWar\Game\Score;
use \Iannsp\PhpWar\Arena as Arena;
use Iannsp\PhpWar\Move as Move;

class Neibor
{
    private $arena;
    public function __construct($arena)
    {
        $this->arena = $arena;
    }
    public function analyze($playerName, Move $move)
    {
        $coordinates = $move->getCoordenates();
        $warPlace    = $this->arena->getArena();
        return $this->calculate($coordinates['x'],$coordinates['y'], $warPlace, $playerName);
    }
    private function calculate($x, $y, $warPlace, $playerName)
    {
        $result = array(
            isset($warPlace[$x-1][$y+1]) ? $warPlace[$x-1][$y+1] : null, // left top corner
            isset($warPlace[$x][$y+1]) ? $warPlace[$x][$y+1] : null, // center top
            isset($warPlace[$x+1][$y+1]) ? $warPlace[$x+1][$y+1] : null, // right top
            isset($warPlace[$x-1][$y]) ? $warPlace[$x-1][$y] : null, // left same line
            isset($warPlace[$x+1][$y]) ? $warPlace[$x+1][$y] : null, // right same line
            isset($warPlace[$x-1][$y-1]) ? $warPlace[$x-1][$y-1] : null, // left bottom corner
            isset($warPlace[$x][$y-1]) ? $warPlace[$x][$y-1] : null, // center bootom
            isset($warPlace[$x+1][$y-1]) ? $warPlace[$x+1][$y-1] : null // right bottom
        );
//        foreach ($warPlace as $place){var_dump(implode('', $place));};
        $rEnd = array();
        foreach ($result as $idx=>$r){
            if (!is_null($r))
                $rEnd[] = $r;
        }
        $count = array_count_values($rEnd);
        asort($count);
        unset($count['.']);
        if (count($count)==0)
            return true;
        $dominanteId    = key($count);
        $dominanteCount = array_shift($count);
        if ($dominanteId==$playerName || $dominanteId=='.')
            return true;
        if($dominanteCount ==1)
            return true;
        return false;
    }
}

/*
1,1 =
. . .
. 0 .
. . .
*/

