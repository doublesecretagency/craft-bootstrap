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

namespace doublesecretagency\bootstrap\models;

use craft\base\Model;

/**
 * Class Settings
 * @since 4.1.1
 */
class Settings extends Model
{

    /** @var bool $includeJquery Whether to load the jQuery library before Bootstrap. */
    public $includeJquery = true;

    /** @var bool $includePopper Whether to bundle the Popper library with Bootstrap. */
    public $includePopper = true;

    /** @var bool $useEverywhere Whether to load the library for all front-end pages. */
    public $useEverywhere = true;

    /** @var bool $useCdn Whether to switch to CDN in production environment. */
    public $useCdn = true;

    /** @var string $production Name of the production environment. */
    public $production = 'production';

}