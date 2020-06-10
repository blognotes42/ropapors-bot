<?php
declare(strict_types=1);

namespace RopaporsBot;

use Exception;
use function random_int;

class Randomizer
{
    /**
     * @param int $maxValue
     * @return int
     * @throws Exception
     */
    public function randomMeUp(int $maxValue): int
    {
        return random_int(0, $maxValue);
    }
}