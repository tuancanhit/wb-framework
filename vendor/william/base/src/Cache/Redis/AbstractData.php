<?php
/**
 * Copyright © SmartOSC, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

/**
 * Class AbstractData
 */
class AbstractData extends \William\Base\Model\AbstractInstance
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->redis = new Redis();
        $this->redis->connect(config('redis.host'), config('redis.portt'));
        parent::__construct($data);
    }

    /**
     * @param $data
     * @param $identifier
     * @return array
     */
    public function setDataCache($data, $identifier)
    {
        if ($data instanceof \William\Base\Model\DataObject) {
            $data = $data->getData();
        }
        return $this->redis->set($identifier, [
            'identifier' => $identifier,
            'data' => $data,
        ]);
    }

    public function getCacheData($identifier)
    {
        $data = $this->redis->get($identifier);
        if (empty($data)) {
            throw new LogicException('Empty');
        }
        $identifier = $data['identifier'];
        return new $identifier($identifier['data']);
    }
}