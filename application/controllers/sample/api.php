<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * API Sample Controller
 */
class Api extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model', 'users');
    }


    /**
     * GET /sample/api/user/{userId}
     *
     * curl http://example.jp/sample/api/user/1  --dump-header -
     */
    public function user_get($id = null) {
        if (!$id) {
            $this->response(null, 404);
            return;
        }

        $user = $this->users->get($id);
        $this->response($user);
    }

    /**
     * GET /sample/api/users
     * curl http://example.jp/sample/api/users  --dump-header -
     *
     * GET /sample/api/users?q={searchText}
     * curl http://example.jp/sample/api/users?q=hoge  --dump-header -
     */
    public function users_get() {
        $q = $this->get('q');
        log_message('debug', "GET request parameter / q:$q");

        $users = $this->users->all();

        $this->response($users);
    }

    /**
     *  POST /sample/api/user
     *
     *  name=XXXXXX
     *
     *  curl http://example.jp/sample/api/user -X POST -d "name=user3" --dump-header -
     */
    public function user_post() {
        $this->load->helper('url');
        $name = $this->post('name');
        log_message('debug', "POST request parameter / name:$name");

        $newId = $this->users->add($name);
        $resourceURL = site_url('sample/api/user/' . $newId);
        header("Location: $resourceURL");
        $this->response(null, 201);
    }

    /**
     * PUT /sample/api/user/{userId}
     *
     * name=XXXXXX
     *
     *  curl http://example.jp/sample/api/user/3 -X PUT -d "name=user3" --dump-header -
     */
    public function user_put($id = null) {
        if (!$id) {
            $this->response(null, 404);
            return;
        }

        $name = $this->put('name');
        log_message('debug', "PUT request parameter / name:$name");

        $user = $this->users->get($id);
        $user->name = $name;
        $this->users->update($user);

        $this->response(null, 204);
    }

    /**
     * DELETE /sample/api/user/{userId}
     *
     * curl http://example.jp/sample/api/user/3 -X DELETE --dump-header -
     */
    public function user_delete($id = null) {
        if (!$id) {
            $this->response(null, 404);
            return;
        }

        $this->users->delete($id);

        $this->response(null, 204);
    }
}

/* End of file api.php */
/* Location: ./application/controllers/sample/api.php */
