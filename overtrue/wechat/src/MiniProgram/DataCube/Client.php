<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace EasyWeChat\MiniProgram\DataCube;

use EasyWeChat\Kernel\BaseClient;
/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * Get summary trend.
     *
     * @param string $from
     * @param string $to
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function summaryTrend($from, $to)
    {
        return $this->query('datacube/getweanalysisappiddailysummarytrend', $from, $to);
    }
    /**
     * Get daily visit trend.
     *
     * @param string $from
     * @param string $to
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function dailyVisitTrend($from, $to)
    {
        return $this->query('datacube/getweanalysisappiddailyvisittrend', $from, $to);
    }
    /**
     * Get weekly visit trend.
     *
     * @param string $from
     * @param string $to
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function weeklyVisitTrend($from, $to)
    {
        return $this->query('datacube/getweanalysisappidweeklyvisittrend', $from, $to);
    }
    /**
     * Get monthly visit trend.
     *
     * @param string $from
     * @param string $to
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function monthlyVisitTrend($from, $to)
    {
        return $this->query('datacube/getweanalysisappidmonthlyvisittrend', $from, $to);
    }
    /**
     * Get visit distribution.
     *
     * @param string $from
     * @param string $to
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function visitDistribution($from, $to)
    {
        return $this->query('datacube/getweanalysisappidvisitdistribution', $from, $to);
    }
    /**
     * Get daily retain info.
     *
     * @param string $from
     * @param string $to
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function dailyRetainInfo($from, $to)
    {
        return $this->query('datacube/getweanalysisappiddailyretaininfo', $from, $to);
    }
    /**
     * Get weekly retain info.
     *
     * @param string $from
     * @param string $to
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function weeklyRetainInfo($from, $to)
    {
        return $this->query('datacube/getweanalysisappidweeklyretaininfo', $from, $to);
    }
    /**
     * Get monthly retain info.
     *
     * @param string $from
     * @param string $to
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function monthlyRetainInfo($from, $to)
    {
        return $this->query('datacube/getweanalysisappidmonthlyretaininfo', $from, $to);
    }
    /**
     * Get visit page.
     *
     * @param string $from
     * @param string $to
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function visitPage($from, $to)
    {
        return $this->query('datacube/getweanalysisappidvisitpage', $from, $to);
    }
    /**
     * Get user portrait.
     *
     * @param string $from
     * @param string $to
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     */
    public function userPortrait($from, $to)
    {
        return $this->query('datacube/getweanalysisappiduserportrait', $from, $to);
    }
    /**
     * Unify query.
     *
     * @param string $api
     * @param string $from
     * @param string $to
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    protected function query($api, $from, $to)
    {
        $params = ['begin_date' => $from, 'end_date' => $to];
        return $this->httpPostJson($api, $params);
    }
}