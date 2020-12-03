<?php

declare(strict_types=1);

namespace App\Puzzle\Modifier;

use App\Puzzle\Model\Name;
use App\Puzzle\Model\Word;

/**
 * Generates a name.
 */
class NameModifier {
	/**
	 * Word service.
	 * @var WordService
	 */
	private WordService $words;

	public function __construct(WordService $words) {
		$this->words = $words;
	}

	/**
	 * Generates the name and returns it per character.
	 * @param Name $name The name
	 * @param bool $debug Whether to show the positions (default) or characters in the name.
	 * @return iterable|string[] The name per character.
	 */
	public function getName(Name $name, bool $debug = false): iterable {
		$fromName = strtoupper($name->getName());
		$fromWords = $this->getNameFromWords();

		$position = 0;
		foreach (str_split($fromName) as $character) {
			if (preg_match('/\w/', $character)) {
				$position++;
				$character = !$debug ? $position : $fromWords[$position];
			}

			yield $character;
		}
	}

	/**
	 * Returns the name from the words with a 1-based index.
	 * @return string[] The name.
	 */
	public function getNameFromWords(WordModifier $words): array {
		$characters = array_combine(
			array_map(static fn(Word $word): int => $word->getNamePosition(), $words->getWords()),
			array_map(static fn(Word $word): string => $word->getNameCharacter(), $words->getWords())
		);

		ksort($characters);

		return $characters;
	}

	/**
	 * Returns the length of the name.
	 * @return int The length.
	 */
	public function getNameLength(): int {
		return count($this->getNameFromWords());
	}
}
