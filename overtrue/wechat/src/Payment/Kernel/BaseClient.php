<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace EasyWeChat\Payment\Kernel;

use EasyWeChat\Kernel\Support;
use EasyWeChat\Kernel\Traits\HasHttpRequests;
use EasyWeChat\Payment\Application;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;
/**
 * Class BaseClient.
 *
 * @author overtrue <i@overtrue.me>
 */
class BaseClient
{
    use HasHttpRequests {
        request as performRequest;
    }
    /**
     * @var \EasyWeChat\Payment\Application
     */
    protected $app;
    /**
     * Constructor.
     *
     * @param \EasyWeChat\Payment\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->setHttpClient($this->app['http_client']);
    }
    /**
     * Extra request params.
     *
     * @return array
     */
    protected function prepends()
    {
        return [];
    }
    /**
     * Make a API request.
     *
     * @param string $endpoint
     * @param array  $params
     * @param string $method
     * @param array  $options
     * @param bool   $returnResponse
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    protected function request($endpoint, $params = [], $method = 'post', $options = [], $returnResponse = false)
    {
        $base = ['mch_id' => $this->app['config']['mch_id'], 'nonce_str' => uniqid(), 'sub_mch_id' => $this->app['config']['sub_mch_id'], 'sub_appid' => $this->app['config']['sub_appid']];
        $params = array_filter(array_merge($base, $this->prepends(), $params));
        $secretKey = $this->app->getKey($endpoint);
        if ('HMAC-SHA256' === ($params['sign_type'] ?: 'MD5')) {
            $encryptMethod = function ($str) use($secretKey) {
                return hash_hmac('sha256', $str, $secretKey);
            };
        } else {
            $encryptMethod = 'md5';
        }
        $params['sign'] = Support\generate_sign($params, $secretKey, $encryptMethod);
        $options = array_merge(['body' => Support\XML::build($params)], $options);
        $this->pushMiddleware($this->logMiddleware(), 'log');
        $response = $this->performRequest($endpoint, $method, $options);
        return $returnResponse ? $response : $this->castResponseToType($response, $this->app->config->get('response_type'));
    }
    /**
     * Log the request.
     *
     * @return \Closure
     */
    protected function logMiddleware()
    {
        $formatter = new MessageFormatter($this->app['config']['http.log_template'] ?: MessageFormatter::DEBUG);
        return Middleware::log($this->app['logger'], $formatter);
    }
    /**
     * Make a request and return raw response.
     *
     * @param string $endpoint
     * @param array  $params
     * @param string $method
     * @param array  $options
     *
     * @return ResponseInterface
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    protected function requestRaw($endpoint, $params = [], $method = 'post', $options = [])
    {
        return $this->request($endpoint, $params, $method, $options, true);
    }
    /**
     * Request with SSL.
     *
     * @param string $endpoint
     * @param array  $params
     * @param string $method
     * @param array  $options
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    protected function safeRequest($endpoint, $params, $method = 'post', $options = [])
    {
        $options = array_merge(['cert' => $this->app['config']->get('cert_path'), 'ssl_key' => $this->app['config']->get('key_path')], $options);
        return $this->request($endpoint, $params, $method, $options);
    }
    /**
     * Wrapping an API endpoint.
     *
     * @param string $endpoint
     *
     * @return string
     */
    protected function wrap($endpoint)
    {
        return $this->app->inSandbox() ? "sandboxnew/{$endpoint}" : $endpoint;
    }
}