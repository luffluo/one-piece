<?php

namespace App\Models\Traits;

trait MarkdownHelper
{
    /**
     * @var \HyperDown\Parser
     */
    protected static $markdown;

    public static function setMarkdown($markdown)
    {
        static::$markdown = $markdown;

        self::$markdown->hook('afterParseCode', function ($html) {
            return preg_replace("/<code class=\"([_a-z0-9-]+)\">/i", "<code class=\"lang-\\1\">", $html);
        });

        self::$markdown->enableHtml(true);
    }

    public static function getMarkdown()
    {
        return static::$markdown;
    }

    public function parserMarkdown($content)
    {
        return str_replace(
            '<p><!--more--></p>',
            '<!--more-->',
            static::$markdown->makeHtml($content)
        );
    }
}
