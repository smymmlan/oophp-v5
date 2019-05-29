<?php

namespace Anax\Blogg;

// use Anax\Commons\AppInjectableInterface;
// use Anax\Commons\AppInjectableTrait;

/**
 * Filter and format text content.
 * @SuppressWarnings(PHPMD.StaticAccess)
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class Content
{

    protected $db;

    /**
     * Call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param array  $filter Array of filters to use.
     *
     * @return string with the formatted text.
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM content;";
        $res = $this->db->executeFetchAll($sql);
        return $res;
    }

    public function selectById($id)
    {
        if (ctype_digit($id)) {
            $sql = "SELECT * FROM content WHERE id = ?;";
            $res = $this->db->executeFetchAll($sql, [$id]);
        }

        return $res;
    }

    public function updateToDeleted($id)
    {
        if (ctype_digit($id)) {
            $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
            $this->db->execute($sql, [$id]);
        }
    }

    public function updatePost($title, $path, $slug, $data, $type, $filter, $published, $id)
    {
        if (!$slug) {
            $myTextFilter = new MyTextFilter();
            $slugify = array("slugify");
            $slug = $myTextFilter->parse($title, $slugify);
        }

        $sql = "SELECT * FROM content WHERE slug = ? AND id NOT IN (SELECT id FROM content WHERE id = ?);";
        $res = $this->db->executeFetchAll($sql, [$slug, $id]);

        foreach ($res as $row) {
            if ($row->slug) {
                $slug = $slug . "-" . strval(mt_rand(100, 100000));
            }
        }

        if (!$path) {
            $path = null;
        }

        if (ctype_digit($id)) {
            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $this->db->execute($sql, [$title, $path, $slug, $data, $type, $filter, $published, $id]);
        }
    }

    public function createTitle($title)
    {
        $sql = "INSERT INTO content (title) VALUES (?);";
        $this->db->execute($sql, [$title]);
        $id = $this->db->lastInsertId();

        return $id;
    }
}
