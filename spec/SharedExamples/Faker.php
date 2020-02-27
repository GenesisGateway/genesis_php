<?php

namespace spec\SharedExamples;

use \Faker\Factory;
use \Faker\Generator;

/**
 * Class Faker
 * @package spec\SharedExamples
 */
class Faker
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
     * @var Faker
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
    private static $providers = [];

    /**
     * Locale used for Faker initialization
     *
     * @var string $locale
     */
    private static $locale = self::DEFAULT_LOCALE;

    /**
     * Initialize singleton object
     *
     * @param array $providers
     * @param string $locale
     *
     * @return void
     */
    public static function initialize($providers = [], $locale = self::DEFAULT_LOCALE)
    {
        self::$providers = $providers;
        self::$locale    = $locale;
    }

    /**
     * Prevent copy of singleton object
     */
    public function __clone()
    {

    }

    /**
     * Faker constructor.
     */
    private function __construct()
    {
        $this->faker = Factory::create(self::$locale);
        $this->registerProviders(self::$providers);
    }

    /**
     * Return Faker Instance
     *
     * @return Generator
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Faker();
        }

        return self::$instance->getFaker();
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
     * Register providers
     * By default Faker Register list of default providers
     *
     * @param $providers
     */
    protected function registerProviders($providers)
    {
        if (!is_array($providers) || empty($providers)) {
            self::$providers = self::getAllowedProviders();
        }

        foreach (self::$providers as $provider) {
            if (!in_array($provider, self::getAllowedProviders())) {
                continue;
            }

            $this->faker->addProvider(new $provider($this->faker));
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
            self::FAKER_PROVIDER_PREFIX_PATH . self::DEFAULT_LOCALE . '\Person',
            self::FAKER_PROVIDER_PREFIX_PATH . 'Payment',
            self::FAKER_PROVIDER_PREFIX_PATH . self::DEFAULT_LOCALE . '\Address',
            self::FAKER_PROVIDER_PREFIX_PATH . self::DEFAULT_LOCALE . '\PhoneNumber',
            self::FAKER_PROVIDER_PREFIX_PATH . 'Internet',
            self::FAKER_PROVIDER_PREFIX_PATH . 'DateTime'
        ];
    }
}
