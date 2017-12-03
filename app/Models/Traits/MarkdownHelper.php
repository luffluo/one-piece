<?php

namespace App\Models\Traits;

trait MarkdownHelper
{
    /**
     * @var \Parsedown
     */
    protected static $markdown;

    public static function setMarkdown($markdown)
    {
        static::$markdown = $markdown;
    }

    public static function getMarkdown()
    {
        return static::$markdown;
    }

    public function parserMarkdown($content)
    {
        return static::$markdown
            ->setMarkupEscaped(true)
            ->text($content);
    }
}
