<?php

namespace App\Helpers;

class TextReadingDuration
{
    private int $baseDurationPerWord = 1;
    private int $textWordCount;
    private int $duration;

    /**
     * TextReadingDuration constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->textWordCount = count(explode(' ', $text));
        $this->duration = $this->textWordCount * $this->baseDurationPerWord;
    }

    public function getTextReadingDurationPerSeconds()
    {
        return $this->duration;
    }

    public function getTextReadingDurationPerMinutes()
    {
        return $this->duration / 60;
    }
}
