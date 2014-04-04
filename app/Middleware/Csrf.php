<?php
namespace GLLApp\Middleware;

use \GLLApp\Lib\Csrf as CsrfLib;

/**
 * Checks for and compares the CSRF token
 *
 * Some of this code is from https://github.com/codeguy/Slim-Extras/blob/a831f4e0a7e52ea7b982edaa9fe0e5b1640412d6/Middleware/CsrfGuard.php
 */
class Csrf extends \Slim\Middleware
{

    /**
     * Call middleware.
     *
     * @return void
     */
    public function call()
    {
        // Attach as hook before requests run
        $this->app->hook('slim.before', array($this, 'check'));

        // Call next middleware.
        $this->next->call();
    }


    public function check()
    {
        // Check sessions are enabled.
        if (session_id() === '') {
            throw new \Exception('Sessions are required to use the CSRF Guard middleware.');
        }

        $csrf = new CsrfLib($this->app);

        $this->app->log->addDebug("Current csrf token: " . $csrf->getCurrentCsrf());

        $method = $this->app->request->getMethod();
        if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH'])) {
            $this->app->log->addDebug("Will do CSRF check");
            if (!$csrf->checkCsrf()) {
                $this->app->log->addDebug("Invalid CSRF token; halting");
                $this->app->halt(400, 'Invalid CSRF Token');
            }
        }

        // generate new CSRF if needed
        if (!$csrf_token = $csrf->getCurrentCsrf()) {
            $csrf_token = $csrf->regenCsrf();
            $this->app->log->addDebug("New csrf token: {$csrf_token}");
        }

        $this->app->view()->appendData(array(
            'csrf_key'      => $csrf::CSRF_REQUEST_KEY,
            'csrf_token'    => $csrf_token,
        ));
    }
}
