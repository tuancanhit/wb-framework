<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Resolver;

use William\Core\Model\DataObject;

/**
 * Class Layout
 *
 * @package William\Core\Resolver
 */
class Layout extends DataObject
{
    protected string $layout;

    /**
     * @return string
     */
    public function getLayout()
    {
        return '';
    }
}