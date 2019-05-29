<?php

namespace Anax\MyTextFilter;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 *
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MyTextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * This is the index method action, it handles:
     * shows the original text without filters
     *
     *
     *
     * @return object
     */
    public function indexAction() : object
    {
        $title = "Orginal | oophp";
        $page = $this->app->page;

        $text = file_get_contents("../text/text.txt");
        $res = $text;

        $page->add("textfilter/navbar-index");
        $page->add("textfilter/index", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * shows the text with bbcode-filter
     * @return object
     */
    public function bbcodeAction() : object
    {
        $title = "BBCode | oophp";
        $page = $this->app->page;

        $text = file_get_contents("../text/text.txt");
        $filter = array("bbcode");

        $myTextFilter = new MyTextFilter();
        $res = $myTextFilter->parse($text, $filter);

        $page->add("textfilter/navbar-index");
        $page->add("textfilter/bbcode", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * shows the text with clickable-filter
     *
     *
     * @return object
     */
    public function linkActionGet()
    {
        $title = "Link | oophp";
        $page = $this->app->page;

        $text = file_get_contents("../text/text.txt");
        $filter = array("link");

        $myTextFilter = new MyTextFilter();
        $res = $myTextFilter->parse($text, $filter);

        $page->add("textfilter/navbar-index");
        $page->add("textfilter/link", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * shows the text with markdown-filter
     *
     *
     * @return object
     */
    public function markdownAction()
    {
        $title = "Markdown | oophp";
        $page = $this->app->page;

        $text = file_get_contents("../text/text.txt");
        $filter = array("markdown");

        $myTextFilter = new MyTextFilter();
        $res = $myTextFilter->parse($text, $filter);

        $page->add("textfilter/navbar-index");
        $page->add("textfilter/markdown", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * shows the text with nl2br-filter
     *
     *
     * @return object
     */
    public function nl2brActionGet()
    {
        $title = "nl2br | oophp";
        $page = $this->app->page;

        $text = file_get_contents("../text/text.txt");
        $filter = array("nl2br");

        $myTextFilter = new MyTextFilter();
        $res = $myTextFilter->parse($text, $filter);

        $page->add("textfilter/navbar-index");
        $page->add("textfilter/nl2br", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * shows the text with all-filters at the same time
     *
     *
     * @return object
     */
    public function allActionGet()
    {
        $title = "nl2br | oophp";
        $page = $this->app->page;

        $text = file_get_contents("../text/text.txt");
        $filter = array("bbcode", "link", "markdown", "nl2br");
        
        $myTextFilter = new MyTextFilter();
        $res = $myTextFilter->parse($text, $filter);

        $page->add("textfilter/navbar-index");
        $page->add("textfilter/all", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }
}
