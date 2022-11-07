<?php

namespace Tests\Unit;

use App\Helpers\TextReadingDuration;
use PHPUnit\Framework\TestCase;

class TextReadingDurationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_reading_text_duration()
    {
        $text = "This is a post description.";

        $duration = new TextReadingDuration();
        $duration->setText($text);

        $this->assertEquals(5, $duration->getTextReadingDurationPerSeconds());
        $this->assertEquals(5 / 60, $duration->getTextReadingDurationPerMinutes());
    }
}
