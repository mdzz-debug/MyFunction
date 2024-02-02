<?php

namespace mdzz\MF\Server;

use RedisException;

class Redis
{
    /**
     * @var \Redis
     */
    private $redis;

    /**
     * connection host
     * @param string $host host
     * @param int $port port
     * @param string $auth auth
     * @throws RedisException RedisException
     */
    public function __construct($host, $port, $auth)
    {
        $this->redis = new \Redis();
        if (!$this->redis->connect($host, $port)) {
            throw new RedisException('Redis connection failed');
        }
        if ($auth) {
            if (!$this->redis->auth($auth)) {
                throw new RedisException('Redis auth failed');
            }
        }
    }

    /**
     * get value by key
     * @param string $key key
     * @return string|bool value
     * @throws RedisException
     */
    public function get($key)
    {
        try {
            return $this->redis->get($key);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * set value by key
     * @param string $key key
     * @param string $value value
     * @param int $expire expire
     * @return bool
     * @throws RedisException
     */
    public function set($key, $value, $expire = 0)
    {
        try {
            if ($expire > 0) {
                return $this->redis->setex($key, $expire, $value);
            }
            return $this->redis->set($key, $value);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * set value by hash
     * @param string $key key
     * @param string $field field
     * @param string $value value
     * @param int $expire expire
     * @return void
     * @throws RedisException
     */
    public function hSet($key, $field, $value, $expire = 0)
    {
        try {
            $this->redis->hSet($key, $field, $value);
            if ($expire > 0) {
                $this->redis->expire($key, $expire);
            }
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * set values by hash
     * @param string $key key
     * @param array $data data
     * @param int $expire expire
     * @return void
     * @throws RedisException
     */
    public function hMset($key, $data, $expire = 0)
    {
        try {
            $this->redis->hMset($key, $data);
            if ($expire > 0) {
                $this->redis->expire($key, $expire);
            }
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * get value by hash
     * @param string $key key
     * @param string $field field
     * @return string|bool value
     * @throws RedisException
     */
    public function hGet($key, $field)
    {
        try {
            return $this->redis->hGet($key, $field);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * get all values by hash
     * @param $key
     * @return array
     * @throws RedisException
     */
    public function hGetAll($key)
    {
        try {
            return $this->redis->hGetAll($key);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * @param string $key key
     * @param array $fields fields
     * @return array|false|\Redis
     * @throws RedisException
     */
    public function hmGet($key, $fields)
    {
        try {
            return $this->redis->hmGet($key, $fields);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * get all values by hash
     * @param string $key
     * @return array
     * @throws RedisException
     */
    public function hKeys($key)
    {
        try {
            return $this->redis->hKeys($key);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * delete value by hash
     * @param string $key
     * @param string $field
     * @return bool|int|\Redis
     * @throws RedisException
     */
    public function hDel($key, $field)
    {
        try {
            return $this->redis->hDel($key, $field);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * get hash length
     * @param string $key
     * @return false|int|\Redis
     * @throws RedisException
     */
    public function hLen($key)
    {
        try {
            return $this->redis->hLen($key);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * delete value by key
     * @param string $key key
     * @return bool
     * @throws RedisException
     */
    public function del($key)
    {
        try {
            return $this->redis->del($key);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * subscribe channel
     * @param string $channel channel
     * @param callable $callback callback
     * @throws RedisException
     */
    public function subscribe($channel, $callback)
    {
        try {
            $this->redis->subscribe([$channel], $callback);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * publish message
     * @param string $channel channel
     * @param string $message message
     * @return int
     * @throws RedisException
     */
    public function publish($channel, $message)
    {
        try {
            return $this->redis->publish($channel, $message);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * psubscribe channel
     * @param string $pattern pattern
     * @param callable $callback callback
     * @throws RedisException
     */
    public function pSubscribe($pattern, $callback)
    {
        try {
            $this->redis->pSubscribe([$pattern], $callback);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * pubsub channels
     * @param string $pattern pattern
     * @return array
     * @throws RedisException
     */
    public function pubSub($pattern)
    {
        try {
            return $this->redis->pubsub($pattern);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * unsubscribe channel
     * @param array $channel channel
     * @throws RedisException
     */
    public function unsubscribe($channel)
    {
        try {
            $this->redis->unsubscribe($channel);
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }

    /**
     * Redis native
     * @return \Redis
     */
    public function Native()
    {
        return $this->redis;
    }

    /**
     * close connection
     * @throws RedisException
     */
    public function __destruct()
    {
        try {
            $this->redis->close();
        } catch (RedisException $e) {
            throw new RedisException($e->getMessage());
        }
    }
}