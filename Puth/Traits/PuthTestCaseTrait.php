<?php

namespace Puth\Traits;

use Puth\Context;
use Puth\GenericObject;
use Symfony\Component\Process\Process;

trait PuthTestCaseTrait
{
    public Context $context;
    public GenericObject $browser;
    public GenericObject $page;

    /**
     * The Puth process instance.
     *
     * @var Process
     */
    protected static Process $puthProcess;

    /**
     * The Puth instance port.
     *
     * @var int
     */
    public static int $puthPort;

    /**
     * Enable if you are locally writing tests.
     *
     * @var bool
     */
    public bool $dev = false;

    /**
     * Enables debug output on client and server side
     *
     * @var bool
     */
    public bool $debug = false;

    /**
     * Enable snapshotting. You can use snapshots to view/review the test live in the GUI.
     *
     * @var bool
     */
    public bool $snapshot = false;

    /**
     * Override headless browser setting.
     *
     * @var bool
     */
    public bool $headless;

    /**
     * Shorthand variable for navigation to a default url.
     *
     * @var string
     */
    protected string $baseUrl;

    /**
     * Set to connect to custom browser ws endpoint instead of the puth server creating a new one.
     *
     * @var string
     */
    protected string $browserWSEndpoint = '';

    /**
     * Default viewport.
     *
     * @var array|int[]
     */
    protected array $defaultViewport = [
        'width' => 1280,
        'height' => 720,
        // 'deviceScaleFactor' => 1,
    ];

    /**
     * Sets up a Context, Browser and Page for every test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->context = new Context($this->getPuthInstanceUrl(), [
            'snapshot' => $this->shouldSnapshot(),
            'test' => $this->getName(),
            'group' => get_class($this),
            'dev' => $this->isDev(),
            'debug' => $this->isDebug(),
        ]);

        // If specific browser ws endpoint is set, always connect to that
        if ($this->hasSpecificBrowserWSEndpoint()) {
            $this->browser = $this->context->connectBrowser([
                'browserWSEndpoint' => $this->browserWSEndpoint,
                'defaultViewport' => $this->defaultViewport,
            ]);
        } else {
            $this->browser = $this->context->createBrowser([
                'headless' => $this->shouldStartInHeadlessMode(),
                'defaultViewport' => $this->defaultViewport,
                // 'args' => [
                //     '--window-size=' . $this->defaultViewport['width'] . ',' . $this->defaultViewport['height'],
                // ],
            ]);
        }

        $this->page = $this->browser->pages()[0];

        if ($this->isDev() && $this->defaultViewport) {
            // Default viewport is only set if you create or connect to a browser.
            $this->page->setViewport($this->defaultViewport);
        }

        // Set prefers-reduced-motion to reduce because click has problems to wait for scroll
        // animation if 'scroll-behavior: smooth' is set.
        // TODO set by default inside Puth server
        $this->page->emulateMediaFeatures([[
            'name' => 'prefers-reduced-motion',
            'value' => 'reduce',
        ]]);
        
        // Set default cookies if defined
        if (property_exists($this, 'cookies')) {
            $this->page->setCookie(...$this->cookies);
        }
    }

    /**
     * Prepare for Puth test execution.
     *
     * @beforeClass
     * @return void
     * @throws \Exception
     */
    public static function prepare()
    {
        if (method_exists(__CLASS__, 'shouldCreatePuthProcess') && static::shouldCreatePuthProcess()) {
            static::startPuthProcess();
        }
    }

    /**
     * Closes Browser and destroys the Context.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        if (!$this->isDev()) {
            $this->page->close();
        }

        $this->context->destroy();
    }

    protected function testDownClass()
    {
        parent::testDownClass();

        if (isset(static::$puthProcess)) {
            static::$puthProcess->stop();
        }
    }

    public static function startPuthProcess()
    {
        static::$puthProcess = new Process(
            ['puth', 'start', '-p', static::getPuthPort()]
        );
        static::$puthProcess->start();

        static::$puthProcess->waitUntil(function ($type, $output) {
            return str_contains($output, '[Puth][Server] Api on');
        });
    }

    public static function getPuthPort()
    {
        if (!isset(static::$puthPort)) {
            static::$puthPort = random_int(10000, 20000);
        }

        return static::$puthPort;
    }

    public function getPuthInstanceUrl(): string
    {
        return 'http://localhost:' . static::$puthPort;
    }

    protected function isDev(): bool
    {
        return isset($this->dev) ? $this->dev : false;
    }

    protected function isDebug(): bool
    {
        return isset($this->debug) ? $this->debug : false;
    }

    protected function shouldSnapshot(): bool
    {
        return isset($this->snapshot) ? $this->snapshot : false;
    }

    protected function hasSpecificBrowserWSEndpoint(): bool
    {
        return !empty($this->browserWSEndpoint);
    }

    protected function shouldStartInHeadlessMode(): bool
    {
        if (isset($this->headless)) {
            return $this->headless;
        }
        if ($this->isDev()) {
            return false;
        }

        return true;
    }
}
