<?php

namespace William\Base\Controller;

/**
 * Class AbstractController
 *
 * @package William\Base\Controller
 */
interface AbstractControllerInterface
{
    public function execute();
    public function launch();
    public function setRedirect(string $handler);
    public function getRedirect();
}