<?php

declare(strict_types=1);

namespace App\Puzzle\Model;

/**
 * A name for the puzzle.
 */
class Name implements \JsonSerializable {
	/**
	 * The name.
	 * @var string
	 */
	private string $name;

	/**
	 * Creates a new name.
	 * @param string $name The name.
	 */
	public function __construct(string $name) {
		$this->name = $name;
	}

	/**
	 * Returns the name.
	 * @return string The name.
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize(): string {
		return $this->getName();
	}
}
