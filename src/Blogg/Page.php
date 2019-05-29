<?php

namespace Anax\Blogg;

/**
 * Filter and format text content.
 * @SuppressWarnings(PHPMD.StaticAccess)
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class Page
{

    protected $db;

    /**
     *
     * @var $db the database object
     *
     * @return string with the formatted text.
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * select all the pages in content.
     * uses textfilter-class to apply selected filters for the text
     *
     */
    public function selectAllPages()
    {
        $sql = <<<EOD
SELECT
    *,
    CASE
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM content
WHERE type=?
;
EOD;

        $res = $this->db->executeFetchAll($sql, ["page"]);

        return $res;
    }

    /**
     * select the page that matches the path.
     * uses textfilter-class to apply selected filters for the text
     *
     */
    public function selectOnePage($path)
    {
        $sql = <<<EOD
SELECT
*,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
path = ?
AND type = ?
AND (deleted IS NULL OR deleted > NOW())
AND published <= NOW()
;
EOD;
        $res = $this->db->executeFetch($sql, [$path, "page"]);
        $myTextFilter = new MyTextFilter();

        if (!$res) {
            return;
        }

        if ($res->filter) {
            $filter = [];
            $filter = explode(",", $res->filter);
            $res->data = htmlentities($res->data);
            $txt = $myTextFilter->parse($res->data, $filter);
            $res->data = $txt;
        }

        return $res;
    }
}
