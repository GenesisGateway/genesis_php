<?php

namespace spec\SharedExamples;

use \Faker\Factory;
use \Faker\Generator;

/**
 * Class FakerExample
 * @package spec\SharedExamples
 */
class FakerExample
{
    /**
     * Default Path for Providers
     */
    const FAKER_PROVIDER_PREFIX_PATH = '\Faker\Provider\\';

    /**
     * Default Locale for generated fakes
     */
    const DEFAULT_LOCALE = 'en_US';

    /**
     * @var FakerExample
     */
    private static $instance = null;

    /**
     * @var Generator
     */
    private $faker = null;

    /**
     * List of Initialized providers
     *
     * @var array
     */
    protected static $providers = [];

    /**
     * Initialize singleton object
     *
     * @param array $providers
     * @return FakerExample
     */
    public static function initialize($providers = [])
    {
        self::$providers = $providers;

        if (self::$instance === null) {
            return self::$instance = new FakerExample();
        }

        return self::$instance;
    }

    /**
     * Prevent copy of singleton object
     */
    public function __clone()
    {

    }

    /**
     * FakerExample constructor.
     */
    private function __construct()
    {
        $this->faker = Factory::create();

        $this->registerProviders(self::$providers);
    }

    /**
     * Return FakerExample Instance
     *
     * @return FakerExample
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * Return Faker instance
     *
     * @return Generator
     */
    public function getFaker()
    {
        return $this->faker;
    }

    /**
     * @return array
     */
    public static function getProviders()
    {
        return self::$providers;
    }

    /**
     * Register providers
     * By default Faker Register list of default providers
     *
     * @param $providers
     */
    protected function registerProviders($providers)
    {
        if (!is_array($providers)) {
            return;
        }

        foreach ($providers as $provider) {
            if (!in_array($provider, self::getAllowedProviders())) {
                continue;
            }

            $class = self::FAKER_PROVIDER_PREFIX_PATH . $provider;
            $this->faker->addProvider(new $class($this->faker));
        }
    }

    /**
     * Return all providers used in Genesis API
     *
     * @return array
     */
    public static function getAllowedProviders()
    {
        return [
            self::DEFAULT_LOCALE . '\Person',
            'Payment',
            self::DEFAULT_LOCALE . '\Address',
            self::DEFAULT_LOCALE . '\PhoneNumber',
            'Internet',
            'DateTime'
        ];
    }
}
