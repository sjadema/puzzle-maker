<?php

declare(strict_types=1);

namespace App\Puzzle\Model;

class Puzzle implements \JsonSerializable {
	/**
	 * @var string
	 */
	private string $uuid;

	/**
	 * @var string
	 */
	private string $title;

	/**
	 * @var Name|null
	 */
	private ?Name $name = null;

	/**
	 * @var Word[]
	 */
	private array $quotes = [];

	/**
	 * @var Word[]
	 */
	private array $words = [];

	public function __construct(string $uuid, string $title) {
		$this->uuid = $uuid;
		$this->title = $title;
	}

	/**
	 * @param Quote $quote
	 * @return $this
	 */
	public function addQuote(Quote $quote): self {
		$this->quotes[] = $quote;

		return $this;
	}

	/**
	 * @param Word $word
	 * @return $this
	 */
	public function addWord(Word $word): self {
		$this->words[] = $word;

		return $this;
	}

	public function getName(): ?Name {
		return $this->name;
	}

	public function getQuotes(): array {
		return $this->quotes;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getUuid(): string {
		return $this->uuid;
	}

	/**
	 * Returns the words indexed on row.
	 * @return Word[] The words.
	 */
	public function getWords(): array {
		return array_combine(array_slice(range('A', 'Z'), 0, count($this->words)), $this->words);
	}

	/**
	 * @param Name $name
	 * @return Puzzle
	 */
	public function setName(Name $name): self {
		$this->name = $name;

		return $this;
	}

	/**
	 * @param Quote[] $quotes
	 * @return Puzzle
	 */
	public function setQuotes(array $quotes): self {
		$this->quotes = [];
		foreach ($quotes as $quote) {
			$this->addQuote($quote);
		}

		return $this;
	}

	/**
	 * @param Word[] $words
	 * @return Puzzle
	 */
	public function setWords(array $words): self {
		$this->words = [];
		foreach ($words as $word) {
			$this->addWord($word);
		}

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize(): array {
		return [
			'uuid' => $this->getUuid(),
			'title' => $this->getTitle(),
			'name' => $this->getName(),
			'quotes' => $this->getQuotes(),
			'words' => $this->getWords(),
		];
	}
}
