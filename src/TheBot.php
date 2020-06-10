<?php
declare(strict_types=1);

namespace RopaporsBot;

use Exception;
use InvalidArgumentException;

class TheBot
{
    public string $name = 'RopaporsBar';
    public const ROCK_EMOJI = "✊";
    public const PAPER_EMOJI = "🤚";
    public const SCISSORS_EMOJI = "✌️";

    public const ROCK = 'rock';
    public const PAPER = 'paper';
    public const SCISSORS = 'scissors';

    private Randomizer $randomizer;

    public function __construct(Randomizer $randomizer)
    {
        $this->randomizer = $randomizer;
    }

    /**
     * @param string $playerPlays
     * @return string
     * @throws Exception
     */
    public function play(string $playerPlays): string
    {
        $playerPlays = strtolower($playerPlays);
        $validMoves = [self::ROCK, self::PAPER, self::SCISSORS];

        if (!in_array($playerPlays, $validMoves)) {
            throw new InvalidArgumentException("$playerPlays is not a valid move");
        }

        $botPlays = $this->useExpertMachineLearningToPickAMoveToPlay($validMoves);

        $result = self::calculateComplexResultScenario(array_search($playerPlays, $validMoves, true), array_search($botPlays, $validMoves, true));

        $botEmoji = constant('self::' . strtoupper($botPlays) . '_EMOJI');
        $playedEmoji = constant('self::' . strtoupper($playerPlays) . '_EMOJI');

        return "You played {$playedEmoji} and RopaporsBot played {$botEmoji} -- {$result}";
    }

    private static function calculateComplexResultScenario(int $playerMove, int $botMove): string
    {

        if ($playerMove === $botMove) {
            return 'It\'s a tie 🙉';
        }

        if (
            ($playerMove === 0 && $botMove === 1)
            || ($playerMove === 1 && $botMove === 2)
            || ($playerMove === 2 && $botMove === 0)
        ) {
            return 'YOU LOSE! 🙈';
        }

        return 'YOU WIN! 🙊';
    }

    /**
     * @param array $validMoves
     * @return string
     * @throws Exception
     */
    private function useExpertMachineLearningToPickAMoveToPlay(array $validMoves): string
    {
        return $validMoves[$this->randomizer->randomMeUp(count($validMoves) - 1)];
    }
}