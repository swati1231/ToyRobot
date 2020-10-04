<?php

class toyTable
{
    /**
     * @var int
     */
    protected $height;

    /**
     * @var int
     */
    protected $width;

    /**
     * toyTable constructor.
     * @param $height
     * @param $width
     */
    public function __construct($height, $width)
    {
        $this->height = $height;
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Checks if robot is placed within the boundaries specified.
     *
     * @param $x
     * @param $y
     * @return bool
     */
    public function checkRobotPosition($x, $y, $facing)
    {
        if (is_null($x) && is_null($y) && is_null($facing)) {
            throw new Exception('Coordinates and direction cannot be set as null');
        }

        if (($x > $this->width && $y > $this->height)) {
            throw new Exception('Robot has not been positioned within the table limit');
        }

        return true;
    }
}
