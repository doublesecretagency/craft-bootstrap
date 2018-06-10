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

use yii\base\Event;

use Craft;
use craft\base\Plugin;
use craft\events\TemplateEvent;
use craft\web\View;

use doublesecretagency\bootstrap\models\Settings;
use doublesecretagency\bootstrap\twigextensions\BootstrapTwigExtension;
use doublesecretagency\bootstrap\web\assets\BootstrapAssets;

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
        Craft::$app->getView()->registerAssetBundle(BootstrapAssets::class);
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