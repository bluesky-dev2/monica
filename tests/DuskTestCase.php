<?php

namespace Tests;

use Tests\Traits\SignIn;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, SignIn;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        if (env('SAUCELABS') != '1') {
            static::startChromeDriver();
        }
    }

    /**
     * Register the base URL and some macro with Dusk.
     *
     * @return void
     *
     * @psalm-suppress UndefinedThisPropertyFetch
     */
    protected function setUp(): void
    {
        parent::setUp();

        /*
         * Macro scrollTo to scroll down/up, until the selector is visible
         */
        Browser::macro('scrollTo', function ($selector) {
            //$element = $this->element($selector);
            //$this->driver->executeScript("arguments[0].scrollIntoView(true);",[$element]);

            $selectorby = $this->resolver->format($selector);
            $this->driver->executeScript("$(\"html, body\").animate({scrollTop: $(\"$selectorby\").offset().top}, 0);");

            return $this;
        });
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(explode(' ', env('CHROME_DRIVER_OPTS', '')));
        $capabilities = DesiredCapabilities::chrome()->setCapability(
            ChromeOptions::CAPABILITY, $options
        );

        if (env('SAUCELABS') == '1') {
            $capabilities->setCapability('tunnel-identifier', env('TRAVIS_JOB_NUMBER'));

            return RemoteWebDriver::create(
                'http://'.env('SAUCE_USERNAME').':'.env('SAUCE_ACCESS_KEY').'@localhost:4445/wd/hub', $capabilities
            );
        } else {
            return RemoteWebDriver::create(
                'http://localhost:9515', $capabilities
            );
        }
    }

    public function hasDivAlert(Browser $browser)
    {
        $res = $browser->elements('alert');

        return count($res) > 0;
    }

    public function hasNotification(Browser $browser)
    {
        $res = $browser->elements('.notifications');

        return count($res) > 0;
    }

    public function getDivAlert(Browser $browser)
    {
        $res = $browser->elements('alert');
        if (count($res) > 0) {
            return $res[0];
        }
    }

    public function getNotification($browser)
    {
        $res = $browser->elements('.notification');
        if (count($res) > 0) {
            return $res[0];
        }
    }
}
