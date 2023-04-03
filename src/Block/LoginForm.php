<?php

namespace William\Wb\Block;

use William\Base\Block\AbstractBlock;
use William\Base\Block\BlockInterface;

/**
 * Class LoginForm
 *
 * @package William\Wb\Block
 */
class LoginForm extends AbstractBlock implements BlockInterface
{
    protected $template = '@app::auth/login-form.php';
}