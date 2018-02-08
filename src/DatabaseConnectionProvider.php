<?php
/**
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @licence   proprietary
 */

namespace Ingenerator\PhinxWrapper;


interface DatabaseConnectionProvider
{

    /**
     * @return array
     */
    public function getConnectionInfo();
}
