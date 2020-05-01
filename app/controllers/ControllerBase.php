<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    // Implement common logic
    public function onConstruct()
    {
        date_default_timezone_set('Asia/Calcutta'); // India Timezone
    }

    public function authorized()
    {
        if (!$this->isLoggedIn()) {
            return $this->response->redirect('user/login');
        }
    }

    public function isLoggedIn()
    {
        // Check if the variable is defined
        if ($this->session->has('AUTH_ID') AND $this->session->has('AUTH_NAME') AND $this->session->has('AUTH_CREATED') AND $this->session->has('AUTH_UPDATED')) {
            return true;
        }
        return false;
    }
}
