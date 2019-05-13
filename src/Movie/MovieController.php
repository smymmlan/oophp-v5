<?php

namespace Anax\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db;



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->app->db->connect();

        // Use $this->app to access the framework services.
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        $title = "Movie database | oophp";
        $db = $this->app->db;
        $page = $this->app->page;

        $sql = "SELECT * FROM movie;";
        $res = $db->executeFetchAll($sql);

        $page->add("movie/navbar-index");
        $page->add("movie/index", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * This is the show all movies
     * @return object
     */
    public function showAllAction()
    {
        $title = "Movie database | oophp";
        $db = $this->app->db;
        $page = $this->app->page;

        $sql = "SELECT * FROM movie;";
        $res = $db->executeFetchAll($sql);

        $page->add("movie/navbar");
        $page->add("movie/show-all", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * This is the search title action GET
     *
     *
     * @return object
     */
    public function searchTitleActionGet()
    {
        $title = "Movie database | oophp";
        $page = $this->app->page;

        $page->add("movie/navbar");
        $page->add("movie/search-title");

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * This is the search title action POST
     *
     *
     * @return object
     */
    public function searchTitleActionPost()
    {
        $title = "Movie database | oophp";
        $request = $this->app->request;
        $db = $this->app->db;
        $page = $this->app->page;

        $searchTitle = $request->getPost("searchTitle");
        $searchTitle = htmlentities($searchTitle);
        $searchTitle = "%" . $searchTitle . "%";

        if (isset($searchTitle)) {
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $res = $db->executeFetchAll($sql, [$searchTitle]);
        }

        $page->add("movie/navbar");
        $page->add("movie/search-title", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * This is the search year action GET
     *
     *
     * @return object
     */
    public function searchYearActionGet()
    {
        $title = "Movie database | oophp";
        $page = $this->app->page;

        // Rendera sidan med sökformulär
        $page->add("movie/navbar");
        $page->add("movie/search-year");

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * This is the search Year action POST
     *
     *
     * @return object
     */
    public function searchYearActionPost()
    {
        $title = "Movie database | oophp";
        $request = $this->app->request;
        $db = $this->app->db;
        $page = $this->app->page;

        $yearOne = $request->getPost("year1");
        $yearTwo = $request->getPost("year2");

        if (ctype_digit($yearOne) && ctype_digit($yearTwo)) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $res = $db->executeFetchAll($sql, [$yearOne, $yearTwo]);
        }

        $page->add("movie/navbar");
        $page->add("movie/search-year", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * This is the add movie action GET
     *
     *
     * @return object
     */
    public function addMovieActionGet()
    {
        $title = "Movie database | oophp";
        $page = $this->app->page;

        $page->add("movie/navbar");
        $page->add("movie/add-movie");

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * This is the add movie action POST
     * handle incoming post to add movies
     *
     * @return object
     */
    public function addMovieActionPOST()
    {
        $response = $this->app->response;
        $request = $this->app->request;
        $db = $this->app->db;

        $movieTitle = $request->getPost("title");
        $movieYear = $request->getPost("year");
        $movieImage = $request->getPost("image");

        $movieTitle = htmlentities($movieTitle);
        $movieImage = htmlentities($movieImage);

        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $db->execute($sql, [$movieTitle, $movieYear, $movieImage]);

        return $response->redirect("movie/add-movie");
    }

    /**
     * This is the delete movie action GET
     * Takes argument and selects move that matches that argument as movie id
     *
     * @return object
     */
    public function deleteMovieActionGet($id)
    {
        $title = "Movie database | oophp";
        $page = $this->app->page;
        $db = $this->app->db;

        if (ctype_digit($id)) {
            $sql = "SELECT * FROM movie WHERE id = ?;";
            $res = $db->executeFetchAll($sql, [$id]);
        }

        $page->add("movie/navbar");
        $page->add("movie/delete-movie", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
           "id" => $id,
        ]);
    }

    /**
     * This is the delete movie action POST
     * delete movie that matches posted id.
     * redirects to movie over-view
     *
     * @return object
     */
    public function deleteMovieActionPost($id)
    {
        $response = $this->app->response;
        $request = $this->app->request;
        $db = $this->app->db;

        $movieId = $request->getPost("id");

        if (ctype_digit($movieId)) {
            $sql = "DELETE FROM movie WHERE id = ?;";
            $db->execute($sql, [$id]);
        }

        return $response->redirect("movie/show-all");
    }

    /**
     * This is the delete movie action GET
     * Takes argument and selects move that matches that argument as movie id
     *
     * @return object
     */
    public function updateMovieActionGet($id)
    {
        $title = "Movie database | oophp";
        $page = $this->app->page;
        $db = $this->app->db;

        if (ctype_digit($id)) {
            $sql = "SELECT * FROM movie WHERE id = ?;";
            $res = $db->executeFetchAll($sql, [$id]);
        }

        $page->add("movie/navbar");
        $page->add("movie/update-movie", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
           "id" => $id,
        ]);
    }

    /**
     * This is the update movie action POST
     * update movie that matches posted id.
     * redirects to movie overview
     *
     * @return object
     */
    public function updateMovieActionPost($movieId)
    {
        $response = $this->app->response;
        $request = $this->app->request;
        $db = $this->app->db;

        $movieTitle = $request->getPost("title");
        $movieTitle = htmlentities($movieTitle);
        $movieImage = $request->getPost("image");
        $movieImage = htmlentities($movieImage);
        $movieYear = $request->getPost("year");
        $movieId = $request->getPost("id");

        if (ctype_digit($movieId)) {
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
        }

        return $response->redirect("movie/show-all");
    }
}
