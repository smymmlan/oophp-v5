<?php

namespace Anax\Blogg;

/**
 * Filter and format text content.
 * @SuppressWarnings(PHPMD.StaticAccess)
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class Blogpost
{

    protected $db;

    /**
     *
     * @var $db the database object
     *
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * selects all content that matches the type 'post'.
     * uses textfilter-class to apply selected filters for the text
     *
     */
    public function selectAllBlogposts()
    {

        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
    FROM content
WHERE type=?
ORDER BY published DESC
;
EOD;

        $res = $this->db->executeFetchAll($sql, ["post"]);
        $myTextFilter = new MyTextFilter();

        foreach ($res as $row) {
            if ($row->filter) {
                $filter = [];
                $filter = explode(",", $row->filter);
                $row->data = htmlentities($row->data);
                $txt = $myTextFilter->parse($row->data, $filter);
                $row->data = $txt;
            }
        }

        return $res;
    }

    /**
     * select the blogpost that matches the slug.
     * uses textfilter-class to apply selected filters for the text
     *
     */
    public function selectOneBlogPost($slug)
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE
    slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;
        $res = $this->db->executeFetch($sql, [$slug, "post"]);
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
