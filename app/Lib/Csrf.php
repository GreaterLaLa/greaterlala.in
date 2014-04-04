<?php

namespace GLLApp\Lib;

/**
* CSRF generation and validation
*/
class Csrf
{
    /**
     * @var \Slim\Slim
     */
    protected $app;

    const CSRF_SESSION_KEY = "_csrf_token";
    const CSRF_HEADER_KEY = "Csrf-Token";
    const CSRF_REQUEST_KEY = "_csrf_token";

    public function __construct(\Slim\Slim $app)
    {
        $this->app = $app;
    }

    public function genCsrf()
    {
        $key = $this->app->config('csrf.secret');
        $message = (string)md5(uniqid(rand(), true));
        $token = hash_hmac("sha1", $message, $key, false);
        return $token;
    }

    /**
     * store the passed token in the session
     */
    public function storeCsrf($csrf_token)
    {
        $_SESSION[self::CSRF_SESSION_KEY] = $csrf_token;
    }

    /**
     * generate a new csrf token, store it in the session, and return
     */
    public function regenCsrf()
    {
        $new_csrf = $this->genCsrf();
        $this->storeCsrf($new_csrf);
        return $new_csrf;
    }

    /**
     * get the current csrf token value from the session
     */
    public function getCurrentCsrf()
    {
        if (!isset($_SESSION[self::CSRF_SESSION_KEY])) {
            return false;
        }
        return $_SESSION[self::CSRF_SESSION_KEY];
    }

    /**
     * compares the passed value to the CSRF token stored in the session
     */
    public function isCsrfValid($client_csrf_token)
    {
        if (empty($client_csrf_token)) {
            throw new Exception("client_csrf_token can't be empty");
        }

        $current_csrf = $this->getCurrentCsrf();

        if (empty($current_csrf)) {
            return false;
        }

        return $client_csrf_token === $current_csrf;
    }

    /**
     * retrieves the CSRF value from app_request. If not present, returns null
     * it checks in this order:
     * - headers
     * - json request body
     * - PUT
     * - POST
     * - GET
     */
    public function getCsrfFromRequest()
    {
        $csrf_val = null;

        if (array_key_exists(self::CSRF_HEADER_KEY, $this->app->request->headers)) {

            $csrf_val = $this->app->request->headers(self::CSRF_HEADER_KEY);

        } else if ($this->jsonHasCsrfKey()) {

            $csrf_val = $this->app->request->json[self::CSRF_REQUEST_KEY];

        // ->params() scans PUT, POST and GET in that order
        } else if ($this->app->request->params(self::CSRF_REQUEST_KEY)) {

            $csrf_val = $this->app->request->params(self::CSRF_REQUEST_KEY);

        }

        return $csrf_val;
    }

    protected function jsonHasCsrfKey()
    {
        /**
         * if no JSON set, return false
         */
        if (empty($this->app->request->json)) {
            return false;
        }

        return array_key_exists(self::CSRF_REQUEST_KEY, $this->app->request->json);
    }

    /**
     * retrieves the CSRF val from the request and compares it to the value
     * in the session.
     * If not present in request, returns None
     * Otherwise returns True/False
     */
    public function checkCsrf()
    {
        $csrf_val = $this->getCsrfFromRequest();
        $this->app->log->addDebug("CSRF value from request: {$csrf_val}");

        if (empty($csrf_val)) {
            return null;
        }

        $valid = $this->isCsrfValid($csrf_val);
        $this->app->log->addDebug("is CSRF valid? {$valid}");
        return $valid;
    }
}
