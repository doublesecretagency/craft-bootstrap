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
 * Class UseBootstrap_TokenParser
 * @since 4.1.1
 */
class UseBootstrap_TokenParser extends \Twig_TokenParser
{

    /**
     * Parses {% useBootstrap %} tags.
     *
     * @param \Twig_Token $token
     *
     * @return UseBootstrap_Node
     */
    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);
        return new UseBootstrap_Node(array(), array(), $lineno, $this->getTag());
    }

    /**
     * Defines the tag name.
     *
     * @return string
     */
    public function getTag()
    {
        return 'useBootstrap';
    }

}

