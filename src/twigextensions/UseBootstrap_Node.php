<?php
/**
 * Bootstrap plugin for Craft CMS
 *
 * Build your site with the Bootstrap front-end framework.
 *
 * @author    Double Secret Agency
 * @link      https://www.doublesecretagency.com/
 * @copyright Copyright (c) 2018 Double Secret Agency
 *
 * @author    Bootstrap
 * @link      https://getbootstrap.com/
 * @copyright 2011-2018 The Bootstrap Authors
 * @copyright 2011-2018 Twitter, Inc.
 * @license   MIT
 */

namespace doublesecretagency\bootstrap\twigextensions;

/**
 * Class UseBootstrap_Node
 * @since 4.1.1
 */
class UseBootstrap_Node extends \Twig_Node
{

    /**
     * Compiles a UseBootstrap_Node into PHP.
     *
     * @param \Twig_Compiler $compiler
     *
     * @return null
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('\doublesecretagency\bootstrap\Bootstrap::$plugin->useBootstrap();')
            ->raw("\n");
    }

}
