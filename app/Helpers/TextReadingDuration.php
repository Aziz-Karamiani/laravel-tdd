<?php

namespace App\Helpers;

class TextReadingDuration
{
    private int $baseDurationPerWord = 1;
    private int $duration;

    /**
     * TextReadingDuration constructor.
     * @param string $text
     */
    public function setText(string $text)
    {
        $textWordCount = count(explode(' ', $text));
        $this->duration = $textWordCount * $this->baseDurationPerWord;
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
