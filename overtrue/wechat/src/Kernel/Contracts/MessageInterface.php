<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace EasyWeChat\Kernel\Contracts;

/**
 * Interface MessageInterface.
 *
 * @author overtrue <i@overtrue.me>
 */
interface MessageInterface
{
    /**
     * @return string
     */
    public function getType();
    /**
     * @return mixed
     */
    public function transformForJsonRequest();
    /**
     * @return string
     */
    public function transformToXml();
}