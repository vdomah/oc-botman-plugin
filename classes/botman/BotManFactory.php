<?php namespace Vdomah\Botman\Classes\BotMan;

use React\Socket\Server;
use BotMan\BotMan\Http\Curl;
use React\EventLoop\LoopInterface;
use BotMan\BotMan\Cache\ArrayCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Interfaces\CacheInterface;
use Symfony\Component\HttpFoundation\Request;
use BotMan\BotMan\Interfaces\StorageInterface;
use BotMan\BotMan\Storages\Drivers\FileStorage;

class BotManFactory extends \BotMan\BotMan\BotManFactory
{
    /**
     * Create a new BotMan instance.
     *
     * @param array $config
     * @param CacheInterface $cache
     * @param Request $request
     * @param StorageInterface $storageDriver
     * @return \Vdomah\Botman\Classes\Botman\BotMan
     */
    public static function create(
        array $config,
        CacheInterface $cache = null,
        Request $request = null,
        StorageInterface $storageDriver = null
    ) {
        if (empty($cache)) {
            $cache = new ArrayCache();
        }
        if (empty($request)) {
            $request = Request::createFromGlobals();
        }
        if (empty($storageDriver)) {
            $storageDriver = new FileStorage(__DIR__);
        }

        // if id_prefix specified - populate it to every driver config array
        // Used to separate cache instances for separate bots and be able to use one app for several different bots
        if (isset($config['id_prefix'])) {
            foreach ($config as $driver_code=>$driver_config) {
                if ($driver_code != 'config') {
                    $driver_code['id_prefix'] = $config['id_prefix'];
                }
            }
        }

        $driverManager = new DriverManager($config, new Curl());
        $driver = $driverManager->getMatchingDriver($request);

        return new BotMan($cache, $driver, $config, $storageDriver);
    }
}