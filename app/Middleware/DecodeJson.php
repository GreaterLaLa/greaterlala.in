<?php
namespace GLLApp\Middleware;

/**
 * Decodes JSON in request body and assigns to $app->response->json
 */
class DecodeJson extends \Slim\Middleware
{
    public function call()
    {
        $json_type = "application/json";

        // work around problem with HTTP_CONTENT_TYPE with PHP dev server
        if (!$this->app->request->headers->get('CONTENT_TYPE')) {
            if (isset($_SERVER['HTTP_CONTENT_TYPE'])) {
                $this->app->request->headers->set('CONTENT_TYPE', $_SERVER['HTTP_CONTENT_TYPE']);
            }
        }

        $content_type = $this->app->request->getMediaType();

        if ($json_type == $content_type) {
            $this->app->log->addDebug("Request Content-type is JSON {$content_type}");
            $body = $this->app->request->getBody();
            if ($body) { // don't decode if body not present
                $this->app->request->json = json_decode($body, true); // decode as array
                $this->app->log->addDebug("Assigned decoded JSON to request->json");
            }
        }

         $this->next->call();
    }
}
