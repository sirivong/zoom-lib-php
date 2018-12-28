<?php

namespace Zoom;

/**
 * Class Dashboard
 * @package Zoom
 */
class Dashboard extends Resource
{
    /**
     * @var string resource base endpoint.
     */
    protected $endpoint = 'metrics';

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
            $query = array_merge($query, $filters);
        }
        $endpoint = sprintf("%s/%s", $this->endpoint(), $category);
        return $this->get($endpoint, $query);
    }

    /**
     * @param $webinarId
     * @param string $type
     * @return mixed
     */
    public function webinar($webinarId, $type = null)
    {
        $filters = [];
        if (!empty($type)) {
            $filters['type'] = $type;
        }
        return $this->object('webinars', $webinarId, $filters);
    }

    /**
     * @param $meetingId
     * @param string $type
     * @return mixed
     */
    public function meeting($meetingId, $type = null)
    {
        $filters = [];
        if (!empty($type)) {
            $filters['type'] = $type;
        }
        return $this->objects('meetings', $meetingId, $filters);
    }

    /**
     * @param $category
     * @param $objectId
     * @param array $filters
     * @return mixed
     */
    protected function object($category, $objectId, $filters = [])
    {
        $query = [];
        if (!empty($filters)) {
            $query = array_merge($query, $filters);
        }
        $endpoint = sprintf("%s/%s/%s", $this->endpoint(), $category, $objectId);
        return $this->get($endpoint, $query);
    }
}
