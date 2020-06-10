<?php
declare(strict_types=1);

use RopaporsBot\Randomizer;
use RopaporsBot\TheBot;

beforeEach(function () {
    $this->theBot = new TheBot(new Randomizer());
});

it('errors if we play a move that isn\'t valid', function () {
    $this->theBot->play('cat');
})->throws(InvalidArgumentException::class);

it('returns correct emoji in the result when we play a valid move', function ($stringMove, $emojiMove) {
    $result = $this->theBot->play($stringMove);
    assertStringContainsString('You played ' . $emojiMove, $result);
})->with([
    [TheBot::ROCK, TheBot::ROCK_EMOJI],
    [TheBot::SCISSORS, TheBot::SCISSORS_EMOJI],
    [TheBot::PAPER, TheBot::PAPER_EMOJI]
]);

it('returns a valid result a random move from the bot', function ($myMove, $botMoveIndex, $expectResult) {

    $randomizeMock = $this->getMockBuilder(Randomizer::class)->getMock();

    $randomizeMock->expects($this->once())
        ->method('randomMeUp')
        ->with(2)
        ->willReturn($botMoveIndex);

    $theBot = new TheBot($randomizeMock);

    assertEquals($expectResult, $theBot->play($myMove));
})->with([
    ['rock', 0, 'You played '.TheBot::ROCK_EMOJI.' and RopaporsBot played '.TheBot::ROCK_EMOJI.' -- It\'s a tie 🙉'],
    ['paper', 1, 'You played '.TheBot::PAPER_EMOJI.' and RopaporsBot played '.TheBot::PAPER_EMOJI.' -- It\'s a tie 🙉'],
    ['scissors', 2, 'You played '.TheBot::SCISSORS_EMOJI.' and RopaporsBot played '.TheBot::SCISSORS_EMOJI.' -- It\'s a tie 🙉'],
    ['rock', 2, 'You played '.TheBot::ROCK_EMOJI.' and RopaporsBot played '.TheBot::SCISSORS_EMOJI.' -- YOU WIN! 🙊'],
    ['scissors', 1, 'You played '.TheBot::SCISSORS_EMOJI.' and RopaporsBot played '.TheBot::PAPER_EMOJI.' -- YOU WIN! 🙊'],
    ['paper', 0, 'You played '.TheBot::PAPER_EMOJI.' and RopaporsBot played '.TheBot::ROCK_EMOJI.' -- YOU WIN! 🙊'],
    ['scissors', 0, 'You played '.TheBot::SCISSORS_EMOJI.' and RopaporsBot played '.TheBot::ROCK_EMOJI.' -- YOU LOSE! 🙈'],
    ['paper', 2, 'You played '.TheBot::PAPER_EMOJI.' and RopaporsBot played '.TheBot::SCISSORS_EMOJI.' -- YOU LOSE! 🙈'],
    ['rock', 1, 'You played '.TheBot::ROCK_EMOJI.' and RopaporsBot played '.TheBot::PAPER_EMOJI.' -- YOU LOSE! 🙈']
]);