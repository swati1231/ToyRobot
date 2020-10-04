<?php

class toyRobot
{
    protected $toyTable;

    protected $coordX;

    protected $coordY;

    protected $facing;

    protected $placedFlag = false;

    protected $directionsArr = [
        'NORTH',
        'EAST',
        'SOUTH',
        'WEST'
    ];

    /**
     * toyRobot constructor.
     *
     * @param toyTable $toyTable
     */
    public function __construct(toyTable $toyTable)
    {
        $this->toyTable = $toyTable;
    }

    /**
     * Function reads the commands
     *
     * @param $command
     * @throws Exception
     */
    public function action($command)
    {
        $cmdArr = $this->extractCommand($command);
        switch (trim($cmdArr['task'])) {
            case 'PLACE':
                $this->place($cmdArr['x'], $cmdArr['y'], $cmdArr['facing']);
                break;

            case 'MOVE':
                $this->move();
                break;

            case 'LEFT':
            case 'RIGHT':
                $this->turn($cmdArr['task']);
                break;

            case 'REPORT':
                $this->report();
                break;
        }
    }

    /**
     * Extract commands
     *
     * @param $command
     * @return array
     */
    public function extractCommand($command)
    {
        if (empty($command)) {
            return false;
        }

        $command = preg_split('/ |,+/', $command);

        $task = $command[0] ?? null;
        $x = $command[1] ?? 0;
        $y = $command[2] ?? 0;
        $facing = $command[3] ?? 'NORTH';

        return ['task' => trim($task), 'x' => $x, 'y' => $y, 'facing' => trim($facing)];
    }

    /**
     * Place the robot at its initial position
     *
     * @param $x
     * @param $y
     * @param $facing
     * @throws Exception
     */
    public function place($x, $y, $facing)
    {
        //Prevent robot from falling
        $this->toyTable->checkRobotPosition($x, $y, $facing);

        //Set coordinates and robot facing direction
        $this->coordX = $x;
        $this->coordY = $y;
        $this->facing = $facing;

        //Flag set if placed
        $this->placedFlag = true;
    }

    /**
     * Move the robots one unit at a time in the facing direction
     *
     * @return bool
     */
    public function move()
    {
        //Check if robot has been placed.
        if(!$this->placedFlag) {
            return false;
        }

        //Prevent robot from falling
        if (!$this->preventRobotFall()) {
            return false;
        }

        switch ($this->facing) {
            case 'NORTH':
                $this->coordY++;
                break;

            case 'EAST':
                $this->coordX++;
                break;

            case 'SOUTH':
                $this->coordY--;
                break;

            case 'WEST':
                $this->coordX--;
                break;
        }
    }

    /**
     * This function moves the robot in clockwise or anti-clockwise
     * direction and return the final direction
     *
     * @param $towards
     * @return mixed
     */
    public function turn($towards)
    {
        //Check if robot has been placed.
        if(!$this->placedFlag) {
            return false;
        }

        $lastIdx = count($this->directionsArr) - 1;
        $facingIdx = array_search($this->facing, $this->directionsArr);

        if ($this->facing === $this->directionsArr[0] && $towards === 'LEFT') {
            $this->facing = $this->directionsArr[$lastIdx];
        } elseif ($this->facing === $this->directionsArr[$lastIdx] && $towards === 'RIGHT') {
            $this->facing = $this->directionsArr[0];
        } elseif ($towards === 'RIGHT') {
            $this->facing = $this->directionsArr[$facingIdx + 1];
        } elseif ($towards === 'LEFT') {
            $this->facing = $this->directionsArr[$facingIdx - 1];
        }

        return $this->facing;
    }

    /**
     * Prints the output
     *
     * @return string
     */
    public function report()
    {
        echo sprintf('%d,%d,%s', $this->coordX, $this->coordY, $this->facing);
    }

    /**
     * Check the coordinates and should not go beyond the limit of the table and prevents robot falling
     *
     * @return bool
     */
    public function preventRobotFall()
    {
        return (in_array($this->facing, ['NORTH', 'SOUTH'])
            ? ($this->coordY < $this->toyTable->getHeight())
            : ($this->coordX < $this->toyTable->getWidth()));
    }

}
