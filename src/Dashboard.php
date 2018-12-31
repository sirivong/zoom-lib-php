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
     * @param array $query
     * @return mixed
     */
    public function webinars($from, $to, $query = [])
    {
        return $this->objects('webinars', $from, $to, $query);
    }

    /**
     * @param $from
     * @param $to
     * @param array $query
     * @return mixed
     */
    public function meetings($from, $to, $query = [])
    {
        return $this->objects('meetings', $from, $to, $query);
    }

    /**
     * @param $webinarId
     * @param string $type
     * @return mixed
     */
    public function webinar($webinarId, $type = null)
    {
        $query = ['type' => $type];
        return $this->object('webinars', $webinarId, $query);
    }

    /**
     * @param $meetingId
     * @param string $type
     * @return mixed
     */
    public function meeting($meetingId, $type = null)
    {
        $query = ['type' => $type];
        return $this->objects('meetings', $meetingId, $query);
    }

    /**
     * @param string $category
     * @param $from
     * @param $to
     * @param array $query
     * @return mixed
     */
    protected function objects(string $category, $from, $to, ?array $query = [])
    {
        if (is_a($from, \DateTime::class)) {
            $from = $from->format('Y-m-d');
        }
        if (is_a($to, \DateTime::class)) {
            $to = $to->format('Y-m-d');
        }
        $query = array_merge(['from' => $from, 'to' => $to], $query);
        $endpoint = sprintf("%s/%s", $this->endpoint(), $category);
        return $this->get(null, $endpoint, $query);
    }

    /**
     * @param string $category
     * @param string $objectId
     * @param array $query
     * @return mixed
     */
    protected function object(string $category, string $objectId, ?array $query = [])
    {
        $endpoint = sprintf("%s/%s/%s", $this->endpoint(), $category, $objectId);
        return $this->get(null, $endpoint, $query);
    }
}
