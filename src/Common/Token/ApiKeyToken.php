<?php

namespace Mi\VideoManager\SDK\Common\Token;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 *
 * @codeCoverageIgnore
 */
class ApiKeyToken implements ApiKeyTokenInterface
{
    private $apiKey;
    private $clientKey;
    private $developerKey;

    /**
     * @param string $apiKey
     * @param string $clientKey
     * @param string $developerKey
     */
    public function __construct($apiKey, $clientKey, $developerKey)
    {
        $this->apiKey       = $apiKey;
        $this->clientKey    = $clientKey;
        $this->developerKey = $developerKey;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getClientKey()
    {
        return $this->clientKey;
    }

    /**
     * @return string
     */
    public function getDeveloperKey()
    {
        return $this->developerKey;
    }
}
