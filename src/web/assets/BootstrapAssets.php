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

namespace doublesecretagency\bootstrap\web\assets;

use Craft;
use craft\web\AssetBundle;
use doublesecretagency\bootstrap\Bootstrap;

/**
 * Class BootstrapAssets
 * @since 4.1.1
 */
class BootstrapAssets extends AssetBundle
{

    /** @inheritdoc */
    public function init()
    {
        parent::init();

        // CDN info
        $cdnVersion = '4.1.1';
        $cdn = null;

        // Get plugin settings
        $settings = Bootstrap::$plugin->getSettings();

        // Get current environment
        $environment = Craft::$app->getConfig()->env;

        // Whether this is the production environment
        $isProduction = ($settings->production == $environment);

        // Check environment
        if ($settings->useCdn && $isProduction) {

            // Use CDN in production environment
            $cdn = "https://stackpath.bootstrapcdn.com/bootstrap/{$cdnVersion}/";

        } else {

            // Use local files in all other environments
            $this->sourcePath = '@vendor/twbs/bootstrap/dist';

        }

        // Register assets
        $this->css = [
            "{$cdn}css/bootstrap.min.css",
        ];

        $this->js = [
            "{$cdn}js/bootstrap.min.js",
        ];

    }

}