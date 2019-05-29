<?php

namespace Anax\Blogg;

use \Michelf\Markdown;

/**
 * Filter and format text content.
 * @SuppressWarnings(PHPMD.StaticAccess)
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class MyTextFilter
{
    
    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param array  $filter Array of filters to use.
     *
     * @return string with the formatted text.
     */
    public function parse($text, $filter)
    {
        for ($i=0; $i<count($filter); $i++) {
            if ($filter[$i] == "bbcode") {
                $text = $this->bbcode2html($text);
            }
            if ($filter[$i] == "link") {
                $text = $this->makeClickable($text);
            }
            if ($filter[$i] == "markdown") {
                $text = $this->markdown($text);
            }
            if ($filter[$i] == "nl2br") {
                $text = $this->nl2br($text);
            }
            if ($filter[$i] == "slugify") {
                $text = $this->slugify($text);
            }
        }
        return $text;
    }


    /**
     * Helper, BBCode formatting converting to HTML.
     *
     * @param string $text The text to be converted.
     *
     * @return string the formatted text.
     */
    public function bbcode2html($text)
    {
        $search = [
        '/\[b\](.*?)\[\/b\]/is',
        '/\[i\](.*?)\[\/i\]/is',
        '/\[u\](.*?)\[\/u\]/is',
        '/\[img\](https?.*?)\[\/img\]/is',
        '/\[url\](https?.*?)\[\/url\]/is',
        '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        ];

        $replace = [
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        ];

        return preg_replace($search, $replace, $text);
    }

    /**
     * Make clickable links from URLs in text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string with formatted anchors.
     */
    public function makeClickable($text)
    {
            return preg_replace_callback(
                '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
                function ($matches) {
                    return "<a href=\"{$matches[0]}\">{$matches[0]}</a>";
                },
                $text
            );
    }

    /**
     * Format text according to Markdown syntax.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string as the formatted html text.
     *
     */
    public function markdown($text)
    {
        return Markdown::defaultTransform($text);
    }

    /**
     * For convenience access to nl2br formatting of text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string the formatted text.
     */
    public function nl2br($text)
    {
        $text = str_replace(array("\r\n", "\r", "\n"), "<br />", $text);
        return $text;
    }

    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return str the formatted slug.
     */
    public function slugify($str)
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(['å','ä'], 'a', $str);
        $str = str_replace('ö', 'o', $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }
}
