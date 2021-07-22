<?php

declare(strict_types=1);

class Board
{
    public const WINNER = "winner";
    public const TIE = "tie";
    public const GAME_NOT_OVER = "game_not_over";
    public const INITALIZER_CONTENT = " ";

    private $board = [];

    public function __construct()
    {
        $row1 = array(self::INITALIZER_CONTENT, self::INITALIZER_CONTENT, self::INITALIZER_CONTENT);

        $row2 = array(self::INITALIZER_CONTENT, self::INITALIZER_CONTENT, self::INITALIZER_CONTENT);

        $row3 = array(self::INITALIZER_CONTENT, self::INITALIZER_CONTENT, self::INITALIZER_CONTENT);

        $this->board[0] = $row1;

        $this->board[1] = $row2;

        $this->board[2] = $row3;
    }

    //display the board with moves made so far
    public function display()
    {
        echo "\n\n";

        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->board[$i][$j] == " ") {
                    echo ($i + 1) . ", " . ($j + 1) . "\t";
                } else {
                    echo $this->board[$i][$j] . "\t";
                }
            }

            echo "\n\n";
        }
    }

    public function setCell(int $row, int $column, string $moveSignature): void {
        $this->board[$row - 1][$column - 1] = $moveSignature;
    }


    public function isMoveValid(int $row, int $column): bool
    {
        $rowAsIndex = $row - 1;
        $columnAsIndex = $column - 1;

        $isValidCell = ($rowAsIndex >= 0 && $rowAsIndex <= 2) && ($columnAsIndex >= 0 && $columnAsIndex <= 2);

        if ($isValidCell) {
            return ($this->board[$rowAsIndex][$columnAsIndex] == self::INITALIZER_CONTENT);
        }

        return $isValidCell;
    }

    public function isGameOver(): string {
        $hasFreeSpace = false;
        $hasWinningSection = false;

        for ($i = 0; $i < 3; $i++) {
            // check for winning rows
            if ($this->board[$i][0] == $this->board[$i][1] && $this->board[$i][1] == $this->board[$i][2] && !$hasWinningSection) {
                $hasWinningSection = $this->board[$i][0] != self::INITALIZER_CONTENT;
            }

            for ($j = 0; $j < 3; $j++) {
                // check for winning columns
                if ($this->board[0][$j] == $this->board[1][$j] && $this->board[1][$j] == $this->board[2][$j] && !$hasWinningSection) {
                    $hasWinningSection = $this->board[0][$j] != self::INITALIZER_CONTENT;
                }

                // check for free spaces
                if ($this->board[$i][$j] == self::INITALIZER_CONTENT) {
                    $hasFreeSpace = true;
                }
            }
        }

        // check for winning diagonal
        if ($this->board[0][0] == $this->board[1][1] && $this->board[1][1] == $this->board[2][2]) {
            $hasWinningSection = $this->board[0][0] != self::INITALIZER_CONTENT;
        }

        // check for other winning diagonal
        if ($this->board[0][2] == $this->board[1][1] && $this->board[1][1] == $this->board[2][0]) {
            $hasWinningSection = $this->board[0][2] != self::INITALIZER_CONTENT;
        }

        if ($hasWinningSection) {
            return self::WINNER;
        }

        if (!$hasFreeSpace) {
            return self::TIE;
        }

        return self::GAME_NOT_OVER;
    }
}
