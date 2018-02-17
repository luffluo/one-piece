<?php

namespace App\Services;

use HyperDown\Parser;

class Markdown
{
    public function convert($text)
    {
        static $parser;

        if (empty($parser)) {
            $parser = new Parser();

            $parser->hook('afterParseCode', function ($html) {
                return preg_replace("/<code class=\"([_a-z0-9-]+)\">/i", "<code class=\"lang-\\1\">", $html);
            });

            $parser->enableHtml(true);
        }

        return str_replace('<p><!--more--></p>', '<!--more-->', $parser->makeHtml($text));
    }
}
