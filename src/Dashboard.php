<?php

namespace Zoom;

/**
 * Class Dashboard
 * @package Zoom
 */
class Dashboard extends Resource
{
    /**
     * @var string
     */
    protected $baseEndpoint = 'metrics';

    /**
     * @param $from
     * @param $to
     * @param array $filters
     * @return mixed
     */
    public function webinars($from, $to, $filters = [])
    {
        return $this->objects('webinars', $from, $to, $filters);
    }

    /**
     * @param $from
     * @param $to
     * @param array $filters
     * @return mixed
     */
    public function meetings($from, $to, $filters = [])
    {
        return $this->objects('meetings', $from, $to, $filters);
    }

    /**
     * @param $category
     * @param $from
     * @param $to
     * @param array $filters
     * @return mixed
     */
    protected function objects($category, $from, $to, $filters = [])
    {
        if (is_a($from, \DateTime::class)) {
            $from = $from->format('Y-m-d');
        }
        if (is_a($to, \DateTime::class)) {
            $to = $to->format('Y-m-d');
        }
        $query = [
            'from' => $from,
            'to' => $to,
        ];
        if (!empty($filters)) {
            foreach ($filters as $k => $v) {
                $query[$k] = $v;
            }
        }
        $endpoint = sprintf("%s/%s", $this->baseEndpoint(), $category);
        return $this->get($endpoint, $query);
    }
}
