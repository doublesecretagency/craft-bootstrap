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

        // Initialize
        $this->css = [];
        $this->js = [];

        // Get plugin settings
        $settings = Bootstrap::$plugin->getSettings();

        // Whether this is the production environment
        $environment = Craft::$app->getConfig()->env;
        $isProduction = ($settings->production == $environment);

        // Optionally bundle Popper
        if ($settings->includePopper) {
            $bootstrapJs = 'bootstrap.bundle.min.js';
        } else {
            $bootstrapJs = 'bootstrap.min.js';
        }

        // Check environment
        if ($settings->useCdn && $isProduction) {

            // Get library versions for CDN paths
            $versions = Bootstrap::$plugin->getLibraryVersions();

            // Use CDN in production environment
            $bootstrapPath = "https://stackpath.bootstrapcdn.com/bootstrap/{$versions['bootstrap']}/";

            // Optionally include jQuery
            if ($settings->includeJquery) {
                $this->js[] = "https://code.jquery.com/jquery-{$versions['jquery']}.min.js";
            }

        } else {

            // Use local files in all other environments
            $this->sourcePath = '@vendor/';
            $bootstrapPath = 'twbs/bootstrap/dist/';

            // Optionally include jQuery
            if ($settings->includeJquery) {
                $this->js[] = 'components/jquery/jquery.min.js';
            }

        }

        // Register Bootstrap CSS file
        $this->css[] = "{$bootstrapPath}css/bootstrap.min.css";

        // Register Bootstrap JS file
        $this->js[] = "{$bootstrapPath}js/{$bootstrapJs}";

    }

}