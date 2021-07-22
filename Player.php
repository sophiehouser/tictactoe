<?php

declare(strict_types=1);

class Player
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $moveSignature;

    public function __construct(string $name, string $moveSignature)
    {
        $this->name = $name;
        $this->moveSignature = $moveSignature;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMoveSignature(): string
    {
        return $this->moveSignature;
    }
}
