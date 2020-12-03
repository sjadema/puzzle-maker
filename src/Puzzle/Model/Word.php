<?php

declare(strict_types=1);

namespace App\Puzzle\Model;

/**
 * A word in the puzzle.
 */
class Word implements \JsonSerializable {
	/**
	 * The word.
	 * @var string
	 */
	private string $word;

	/**
	 * The hint.
	 * @var string
	 */
	private string $hint;

	/**
	 * The position of the character that is used in the name.
	 * @var int[]
	 */
	private array $namePosition;

	/**
	 * The positions of the characters that are used in the quotes.
	 * @var int[]
	 */
	private array $quotePositions;

	/**
	 * Creates a new word.
	 * @param string $word The word.
	 * @param string $hint The hint.
	 * @param int[] $namePosition The character position in the name. The index is be 1 based.
	 * @param int[] $quotePositions The character positions in the quotes. The indexes are 1 based.
	 */
	public function __construct(string $word, string $hint, array $namePosition, array $quotePositions) {
		$this->word = strtoupper($word);
		$this->hint = $hint;
		$this->namePosition = $namePosition;
		$this->quotePositions = $quotePositions;
	}

	/**
	 * @param QuoteService $quotes
	 * @param bool $debug
	 * @return \Iterator
	 */
	public function generateWord(QuoteService $quotes, bool $debug = false): \Iterator {
		$characters = array_combine(
			array_merge([$this->getNameIndex()], $this->getQuoteIndexes()),
			array_merge([$this->getNamePosition()], $this->getQuotePositions())
		);

		$occupied = array_values($characters);

		foreach (str_split($this->word) as $i => $character) {
			if (!$debug) {
				if (isset($characters[$i])) {
					$character = $characters[$i];
				} else {
					$character = \random_int(1, $quotes->getQuotesLength());
					while (in_array($character, $occupied, true)) {
						$character = \random_int(1, $quotes->getQuotesLength());
					}
					$occupied[] = $character;
				}
			}

			yield $character;
		}
	}

	/**
	 * Returns the word.
	 * @return string The word.
	 */
	public function getWord(): string {
		return $this->word;
	}

	/**
	 * Returns the hint.
	 * @return string The hint.
	 */
	public function getHint(): string {
		return $this->hint;
	}

	/**
	 * Returns the 0-based index of the name's character in this word.
	 * @return int The index.
	 */
	public function getNameIndex(): int {
		return key($this->namePosition) - 1;
	}

	/**
	 * Returns the position of this word's character in the name.
	 * @return int The position.
	 */
	public function getNamePosition(): int {
		return reset($this->namePosition);
	}

	/**
	 * Returns the character used in the name.
	 * @return string The character.
	 */
	public function getNameCharacter(): string {
		return $this->word[$this->getNameIndex()];
	}

	/**
	 * Returns the 0-based indexes of the quotes' characters in this word.
	 * @return int[] The indexes.
	 */
	public function getQuoteIndexes(): array {
		return array_map(static fn(int $position): int => $position - 1, array_keys($this->quotePositions));
	}

	/**
	 * Returns the positions of this word's characters in the quotes.
	 * @return int[] The positions.
	 */
	public function getQuotePositions(): array {
		return array_values($this->quotePositions);
	}

	/**
	 * Returns the characters used in the quotes.
	 * @return string[] The characters.
	 */
	public function getQuoteCharacters(): array {
		return array_map(fn(int $i): string => $this->word[$i], $this->getQuoteIndexes());
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize() {
		return [
			'word' => $this->word,
			'hint' => $this->hint,
			'name' => [key($this->namePosition) - 1 => reset($this->namePosition) - 1],
		];
	}
}
