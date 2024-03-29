<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace EasyWeChat\OfficialAccount\User;

use EasyWeChat\Kernel\BaseClient;
/**
 * Class TagClient.
 *
 * @author overtrue <i@overtrue.me>
 */
class TagClient extends BaseClient
{
    /**
     * Create tag.
     *
     * @param string $name
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function create($name)
    {
        $params = ['tag' => ['name' => $name]];
        return $this->httpPostJson('cgi-bin/tags/create', $params);
    }
    /**
     * List all tags.
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function all()
    {
        return $this->httpGet('cgi-bin/tags/get');
    }
    /**
     * Update a tag name.
     *
     * @param int    $tagId
     * @param string $name
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function update($tagId, $name)
    {
        $params = ['tag' => ['id' => $tagId, 'name' => $name]];
        return $this->httpPostJson('cgi-bin/tags/update', $params);
    }
    /**
     * Delete tag.
     *
     * @param int $tagId
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function delete($tagId)
    {
        $params = ['tag' => ['id' => $tagId]];
        return $this->httpPostJson('cgi-bin/tags/delete', $params);
    }
    /**
     * Get user tags.
     *
     * @param string $openid
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function userTags($openid)
    {
        $params = ['openid' => $openid];
        return $this->httpPostJson('cgi-bin/tags/getidlist', $params);
    }
    /**
     * Get users from a tag.
     *
     * @param int    $tagId
     * @param string $nextOpenId
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function usersOfTag($tagId, $nextOpenId = '')
    {
        $params = ['tagid' => $tagId, 'next_openid' => $nextOpenId];
        return $this->httpPostJson('cgi-bin/user/tag/get', $params);
    }
    /**
     * Batch tag users.
     *
     * @param array $openids
     * @param int   $tagId
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function tagUsers($openids, $tagId)
    {
        $params = ['openid_list' => $openids, 'tagid' => $tagId];
        return $this->httpPostJson('cgi-bin/tags/members/batchtagging', $params);
    }
    /**
     * Untag users from a tag.
     *
     * @param array $openids
     * @param int   $tagId
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function untagUsers($openids, $tagId)
    {
        $params = ['openid_list' => $openids, 'tagid' => $tagId];
        return $this->httpPostJson('cgi-bin/tags/members/batchuntagging', $params);
    }
}