<?php

namespace Anax\Blogg;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class BloggController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * @var $db database object
     */
    private $db;


    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * connect to the database
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = $this->app->db;
        $this->app->db->connect();
    }

    /**
     * index.
     *
     * shows all content from db
     *
     *
     * @return object
     */
    public function indexAction() : object
    {
        $title = "Blogg database";
        $page = $this->app->page;

        $content = new Content($this->db);
        $res = $content->selectAll();

        $page->add("blogg/navbar-index");
        $page->add("blogg/index", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * shows error page when there is no matching page
     * @return object
     */
    public function notFoundAction() : object
    {
        $title = "Blogg database";
        $page = $this->app->page;

        $page->add("blogg/navbar-index");
        $page->add("blogg/404");

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * This is the show all movies
     * admin view.
     * @return object
     */
    public function adminAction()
    {
        $title = "Admin";
        $page = $this->app->page;

        $content = new Content($this->db);
        $res = $content->selectAll();

        $page->add("blogg/navbar-index");
        $page->add("blogg/admin", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * This is the delete bloggpost action GET
     * Takes argument and selects content that matches that argument
     * as content id.
     *
     * @return object
     */
    public function deletePostActionGet($id)
    {
        $title = "Delete";
        $page = $this->app->page;

        $content = new Content($this->db);
        $res = $content->selectById($id);

        $page->add("blogg/navbar-index");
        $page->add("blogg/delete-post", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
           "id" => $id,
        ]);
    }

    /**
     * This is the delete post action POST
     * update post to deleted from content.
     * redirects to admin over-view
     *
     * @return object
     */
    public function deletePostActionPost($id)
    {
        $response = $this->app->response;
        $request = $this->app->request;

        $id = $request->getPost("id");
        $content = new Content($this->db);
        $content->updateToDeleted($id);

        return $response->redirect("blogg/admin");
    }

    /**
     * This is the update/edit content action GET
     * Takes argument and selects content that matches the id
     *
     * @return object
     */
    public function updatePostActionGet($id)
    {
        $title = "Update database";
        $page = $this->app->page;

        $content = new Content($this->db);
        $res = $content->selectById($id);

        $page->add("blogg/navbar-index");
        $page->add("blogg/update-post", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
           "id" => $id,
        ]);
    }

    /**
     * This is the update content action POST
     * update content that matches posted id.
     * redirects to content overview
     *
     * @return object
     */
    public function updatePostActionPost($id)
    {
        $response = $this->app->response;
        $request = $this->app->request;

        $title = $request->getPost("title");
        $path = $request->getPost("path");
        $slug = $request->getPost("slug");
        $data = $request->getPost("data");
        $type = $request->getPost("type");
        $filter = $request->getPost("filter");
        $published = $request->getPost("published");
        $id = $request->getPost("id");

        $content = new Content($this->db);
        $content->updatePost($title, $path, $slug, $data, $type, $filter, $published, $id);

        return $response->redirect("blogg/admin");
    }

    /**
     * Create new post.
     * Show form for adding a new title.
     *
     * @return object
     */
    public function createActionGet() : object
    {
        $title = "Create";
        $page = $this->app->page;

        $page->add("blogg/navbar-index");
        $page->add("blogg/create");

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * create new post
     * with incoming title
     * redirect to update route
     *
     * @return object
     */
    public function createActionPost() : object
    {
        $page = $this->app->page;
        $response = $this->app->response;
        $request = $this->app->request;

        $title = $request->getPost("title");

        $content = new Content($this->db);
        $id = $content->createTitle($title);

        return $response->redirect("blogg/update-post/{$id}");

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * fetch all from db that matches type page
     *
     *
     * @return object
     */
    public function pagesAction() : object
    {
        $page = $this->app->page;
        $title = "Pages";

        $webPage = new Page($this->db);
        $res = $webPage->selectAllPages();

        $page->add("blogg/navbar-index");
        $page->add("blogg/pages", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * get path for current page
     * select matching content from db
     * @return object
     */
    public function pageActionGet($path) : object
    {
        $page = $this->app->page;
        $response = $this->app->response;
        $path = htmlentities($path);
        $title = "{$path}";

        $webPage = new Page($this->db);
        $res = $webPage->selectOnePage($path);

        if (!$res) {
            return $response->redirect("blogg/notFound");
        }

        $page->add("blogg/navbar-index");
        $page->add("blogg/page", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * fetch all from db that matches type blog
     *
     *
     * @return object
     */
    public function blogAction() : object
    {
        $page = $this->app->page;
        $title = "Blog";

        $blogPost = new Blogpost($this->db);
        $res = $blogPost->selectAllBlogposts();

        $page->add("blogg/navbar-index");
        $page->add("blogg/blog", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }

    /**
     * get slug for current page
     * select matching content from db
     * @return object
     */
    public function blogPostActionGet($slug) : object
    {
        $page = $this->app->page;
        $response = $this->app->response;
        $slug = htmlentities($slug);
        $title = "Post";

        $blogPost = new Blogpost($this->db);
        $res = $blogPost->selectOneBlogPost($slug);

        if (!$res) {
            return $response->redirect("blogg/notFound");
        }

        $page->add("blogg/navbar-index");
        $page->add("blogg/blog-post", [
              "res" => $res,
        ]);

        return $page->render([
           "title" => $title,
        ]);
    }
}
