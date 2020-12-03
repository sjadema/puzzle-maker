<?php

declare(strict_types=1);

namespace App\Puzzle;

use App\Puzzle\Model\Name;
use App\Puzzle\Model\Puzzle;
use App\Puzzle\Model\Quote;
use App\Puzzle\Model\Word;

/**
 * Factory to create a {@see Puzzle}.
 */
class PuzzleFactory {
	/**
	 * Creates a puzzle from an array.
	 * @param mixed[] $data The data.
	 * @return Puzzle The puzzle.
	 */
	public static function fromArray(array $data): Puzzle {
		if (!isset($data['uuid'], $data['title'])) {
			throw new \InvalidArgumentException(
				'Could not create puzzle because either "uuid" or "title" is missing.'
			);
		}

		return (new Puzzle($data['uuid'], $data['title']))
			->setName(new Name($data['name'] ?? ''))
			->setQuotes(array_map(static fn(string $quote): Quote => new Quote($quote), $data['quotes'] ?? []))
			->setWords(array_map(
				static fn(array $word): Word => new Word($word['word'], $word['hint'], [], []),
				$data['words'] ?? []
			));
	}
}
