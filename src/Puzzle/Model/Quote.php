<?php

declare(strict_types=1);

namespace App\Puzzle\Model;

class Quote implements \JsonSerializable {
	/**
	 * @var string
	 */
	private string $quote;

	public function __construct(string $quote) {
		$this->quote = $quote;
	}

	public function getQuote(): string {
		return $this->quote;
	}

	public function jsonSerialize(): string {
		return $this->quote;
	}
}
