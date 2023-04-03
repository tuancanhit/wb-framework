<?php

namespace William\Base\Controller;

/**
 * Class AbstractController
 *
 * @package William\Base\Controller
 */
interface AbstractControllerInterface
{
    const FRONT = 'frontend';
    const AJAX  = 'ajax';
    const ADMIN = 'admin';

    public function execute();
    public function launch();
    public function setRedirect(string $handler);
    public function getRedirect();
    public function getRequest();
}