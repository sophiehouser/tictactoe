<?php

declare(strict_types=1);

class Game
{
    /**
     * @var Player
     */
    private $currentPlayer;

    /**
     * @var array<Player>
     */
    private $players;

    /**
     * @var Board
     */
    private $board;

    /**
     * @param array<Player> $players
     * @param Board $board
     */
    public function __construct(array $players, Board $board)
    {
        $this->players = $players;
        $this->board = $board;

        $this->setCurrentPlayer($players[0]);

        $board->display();
        $this->printInstructions();
    }

    public function getCurrentPlayer(): Player
    {
        return $this->currentPlayer;
    }

    public function setCurrentPlayer(Player $currentPlayer): void
    {
        $this->currentPlayer = $currentPlayer;
    }

    public function changeTurns() {
        for ($i = 0; $i < sizeof($this->players); $i++) {
            if ($this->getCurrentPlayer()->getName() != $this->players[$i]->getName()) {
                $this->setCurrentPlayer($this->players[$i]);
                break;
            }
        }
    }

    public function printInstructions() {
        echo "Welcome to a game of 3x3 tic tac toe. when it's your turn input your move as ROW,COLUMN, ie: 1,2 and press enter \n\n";
    }

    public function getMove(): ?array {
        do {
            echo $this->getCurrentPlayer()->getName() . "'s move [" . $this->getCurrentPlayer()->getMoveSignature() . "]: ";

            $rawMove = trim(fgets(STDIN));

        } while($rawMove == null);

        $parsedMove = $this->getMoveCoordinates($rawMove);

        if (!$parsedMove) {
            echo "INVALID MOVE \n\n";
            return null;
        }

        if (!$this->board->isMoveValid($parsedMove[0], $parsedMove[1])) {
            echo "INVALID MOVE \n\n";
            return null;
        }

        return $parsedMove;
    }

    public function makeMove(int $row, int $column)
    {
        $this->board->setCell($row, $column, $this->currentPlayer->getMoveSignature());

        $this->board->display();
    }

    public function getMoveCoordinates(string $playerInput): ?array {
        $moveCoordinatesArray = explode(",", $playerInput);

        if (sizeof($moveCoordinatesArray) != 2) {
            return null;
        }

        if (!(is_numeric($moveCoordinatesArray[0]) && is_numeric($moveCoordinatesArray[1]))) {
            return null;
        }

        return [(int) $moveCoordinatesArray[0], (int) $moveCoordinatesArray[1]];
    }

    public function printGameOver(string $gameEnding) {
        switch ($gameEnding) {
            case Board::WINNER:
                echo "GAME OVER! " . $this->getCurrentPlayer()->getName() . " is victorious. Go gettem tiger rawrrr \n\n";
                break;
            case BOARD::TIE:
                echo "GAME OVER: TIE! \n\n";
                break;
            default:
                echo "GAME OVER: Unknown reason but congrats! \n\n";
                break;
        }
    }
}
