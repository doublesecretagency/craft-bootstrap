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

namespace doublesecretagency\bootstrap;

use Yii;
use yii\base\Event;

use Craft;
use craft\base\Plugin;
use craft\events\TemplateEvent;
use craft\web\View;

use doublesecretagency\bootstrap\models\Settings;
use doublesecretagency\bootstrap\twigextensions\BootstrapTwigExtension;
use doublesecretagency\bootstrap\web\assets\BootstrapAssets;
use doublesecretagency\bootstrap\web\assets\jQueryAssets;

/**
 * Class Bootstrap
 * @since 4.1.1
 */
class Bootstrap extends Plugin
{

    /** @var Plugin $plugin Self-referential plugin property. */
    public static $plugin;

    /** @var bool $hasCpSettings The plugin has a settings page. */
    public $hasCpSettings = true;

    /** @var array $versions The current versions of each library. Fallback versions by default. */
    public $versions = [
        'bootstrap' => '4.1.1',
        'jquery'    => '3.3.1',
    ];

    /** @var bool $loadCdn Whether to load the library via CDN. */
    public $loadCdn = false;

    /** @var array $_lockRead Whether the composer.lock file been read already. */
    protected $_lockRead = false;

    /** @inheritDoc */
    public function init()
    {
        parent::init();

        self::$plugin = $this;

        // If control panel request, bail
        if (Craft::$app->getRequest()->getIsCpRequest()) {
            return false;
        }

        if (Craft::$app->getRequest()->getIsSiteRequest()) {
            Craft::$app->getView()->registerTwigExtension(new BootstrapTwigExtension());
        }

        // If auto-loading, load Bootstrap before template is rendered
        if ($this->getSettings()->useEverywhere) {
            Event::on(
                View::class,
                View::EVENT_BEFORE_RENDER_TEMPLATE,
                function (TemplateEvent $event) {
                    Bootstrap::$plugin->useBootstrap();
                }
            );
        }
    }

    /**
     * Load the Bootstrap library.
     *
     * @return void
     */
    public function useBootstrap()
    {
        // Get view
        $view = Craft::$app->getView();

        // Load current library versions
        $this->loadLibraryVersions();

        // Get plugin settings
        $settings = $this->getSettings();

        // Whether this is the production environment
        $environment = Craft::$app->getConfig()->env;
        $isProduction = ($settings->production == $environment);

        // Determine whether to load via CDN
        $this->loadCdn = ($settings->useCdn && $isProduction);

        // Register Bootstrap CSS & JS
        $view->registerAssetBundle(BootstrapAssets::class);

        // Optionally register jQuery JS
        if ($this->getSettings()->includeJquery) {
            $view->registerAssetBundle(jQueryAssets::class);
        }
    }

    /**
     * Load the version numbers of included libraries.
     *
     * @return void
     */
    public function loadLibraryVersions()
    {
        // If versions have already been determined, bail
        if ($this->_lockRead) {
            return;
        }

        // Mark composer.lock as read
        $this->_lockRead = true;

        // Locate composer.lock file
        $filename = Yii::getAlias('@root/composer.lock');

        // Get composer.lock file contents
        $lock = @file_get_contents($filename);

        // If unable to retrieve lock file, bail
        if (!$lock) {
            return;
        }

        // Convert to JSON data
        $json = @json_decode($lock, true);

        // If unable to decode JSON, bail
        if (!$json) {
            return;
        }

        // Get current versions of libraries
        foreach ($json['packages'] as $package) {
            switch ($package['name']) {
                case 'twbs/bootstrap':
                case 'components/jquery':
                    $name    = preg_replace('/^[^\/]*\//', '', $package['name']);
                    $version = preg_replace('/[^0-9\.]/', '', $package['version']);
                    $this->versions[$name] = $version;
                    break;
            }
        }
    }

    /**
     * @return Settings Plugin settings model.
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @return string The fully rendered settings template.
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->getView()->renderTemplate('bootstrap/settings', [
            'settings' => $this->getSettings(),
        ]);
    }

}