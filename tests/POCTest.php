<?php

namespace Mi\VideoManager\SDK\Tests;

use GuzzleHttp\Client;
use JMS\Serializer\Builder\CallbackDriverFactory;
use JMS\Serializer\Metadata\Driver\XmlDriver;
use JMS\Serializer\SerializerBuilder;
use Mi\Guzzle\ServiceBuilder\Loader\JsonLoader;
use Mi\Guzzle\ServiceBuilder\ServiceBuilder;
use Mi\Guzzle\ServiceBuilder\ServiceFactory as BaseServiceFactory;
use Mi\Puli\Metadata\Driver\PuliFileLocator;
use Mi\VideoManager\SDK\Common\ServiceFactory;
use Mi\VideoManager\SDK\Common\Token\ApiKeyToken;
use Mi\VideoManager\SDK\Common\Token\ApiKeyTokenInterface;
use Mi\VideoManager\SDK\Common\Token\UserTokenInterface;
use Mi\VideoManager\SDK\Video\VideoService;
use Puli\Repository\PathMappingRepository;
use Puli\Repository\Resource\DirectoryResource;
use Webmozart\KeyValueStore\ArrayStore;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
class POCTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        self::markTestSkipped('test is only for poc');

        $oAuth2Token = new ApiKeyToken(
            'api-key',
            'mi-videomanger-sdk',
            'dev-key'
        );

        /** @var VideoService $service */
        $service = $this->getServiceBuilder($oAuth2Token)->get('video');

        $response = $service->getVideoList();

        print_r($response);
    }

    /**
     * @param ApiKeyTokenInterface|null $apiKeyToken
     * @param UserTokenInterface|null   $userToken
     *
     * @return ServiceBuilder
     */
    private function getServiceBuilder(ApiKeyTokenInterface $apiKeyToken = null, UserTokenInterface $userToken = null)
    {

        $client = new Client(['base_url' => 'https://api.edge-cdn.net']);

        $factory = new ServiceFactory(
            new BaseServiceFactory($this->getSerializerBuilder()->build(), $client),
            $apiKeyToken,
            $userToken
        );

        $loader = new JsonLoader($this->getPuliRepo());
        $builder = new ServiceBuilder($loader, $factory, '/mi/videomanager-sdk/common/services.json');

        return $builder;
    }

    /**
     * @return PathMappingRepository
     */
    private function getPuliRepo()
    {
        $repo = new PathMappingRepository(new ArrayStore());
        $repo->add('/mi/videomanager-sdk', new DirectoryResource(__DIR__ . '/../resources'));

        return $repo;
    }

    /**
     * @return SerializerBuilder
     */
    private function getSerializerBuilder()
    {
        $driver = new XmlDriver(
            new PuliFileLocator(
                $this->getPuliRepo(),
                [
                    'Mi\\VideoManager\\SDK\\Model' => '/mi/videomanager-sdk/serializer',
                ]
            )
        );

        $serializer = SerializerBuilder::create();
        $serializer->setMetadataDriverFactory(
            new CallbackDriverFactory(
                function () use ($driver) {
                    return $driver;
                }
            )
        );

        return $serializer;
    }
}
