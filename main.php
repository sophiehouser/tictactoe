<?php

require("Player.php");

require("Board.php");

require("Game.php");

function main()
{
    $playerX = new Player("Player One", "X");
    $playerO = new Player("Player Two", "O");

    $board = new Board();
    $game = new Game([$playerX, $playerO], $board);

    do
    {
        do {
            $moveCoordinates = $game->getMove();

        } while ($moveCoordinates == null);

        $game->makeMove($moveCoordinates[0], $moveCoordinates[1]);

        $isGameOver = $board->isGameOver();
        if ($isGameOver != Board::GAME_NOT_OVER) {
            $game->printGameOver($isGameOver);
        }

        $game->changeTurns();

    } while($isGameOver == Board::GAME_NOT_OVER);
}

main();
