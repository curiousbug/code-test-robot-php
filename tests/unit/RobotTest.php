<?php
use Codeception\Util\Stub;

require_once 'lib/tabletop.php';
require_once 'lib/robot.php';

class RobotTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy,
              $robot;

    protected function _before()
    {
        $this->robot = new Robot(new Tabletop(5, 5));
    }

    protected function _after()
    {
    }

    // tests
    public function testNew()
    {
        $this->assertInstanceOf('Robot', $this->robot);
    }

    public function testRobotOffTableReport()
    {
        //before place
        $this->assertEquals('', $this->robot->report());

        //invalid places
        $this->robot->place(-1, -1, 'NORTH');
        $this->assertEquals('', $this->robot->report());

        $this->robot->place(-1, 0, 'NORTH');
        $this->assertEquals('', $this->robot->report());

        $this->robot->place(0, -1, 'NORTH');
        $this->assertEquals('', $this->robot->report());

        $this->robot->place(0, 0, 'COWS');
        $this->assertEquals('', $this->robot->report());
    }

    public function testPlaceThenReport()
    {
        //valid place
        $this->robot->place(0, 0, 'NORTH');
        $this->assertEquals('Output: 0, 0, NORTH', $this->robot->report());

        //invalid place
        $this->robot->place(0, 0, 'NORTH');

        $this->robot->place(-1, -1, 'NORTH');
        $this->assertEquals('Output: 0, 0, NORTH', $this->robot->report());

        $this->robot->place(-1, 0, 'NORTH');
        $this->assertEquals('Output: 0, 0, NORTH', $this->robot->report());

        $this->robot->place(0, -1, 'NORTH');
        $this->assertEquals('Output: 0, 0, NORTH', $this->robot->report());

        $this->robot->place(0, 0, 'COWS');
        $this->assertEquals('Output: 0, 0, NORTH', $this->robot->report());

        //more valid places
        $this->robot->place(0, 0, 'NORTH');
        $this->assertEquals('Output: 0, 0, NORTH', $this->robot->report());

        $this->robot->place(1, 1, 'NORTH');
        $this->assertEquals('Output: 1, 1, NORTH', $this->robot->report());

        $this->robot->place(2, 1, 'NORTH');
        $this->assertEquals('Output: 2, 1, NORTH', $this->robot->report());

        $this->robot->place(2, 2, 'NORTH');
        $this->assertEquals('Output: 2, 2, NORTH', $this->robot->report());

        $this->robot->place(2, 2, 'SOUTH');
        $this->assertEquals('Output: 2, 2, SOUTH', $this->robot->report());
    }

    public function testLeft()
    {
        //robot not placed
        $this->robot->left();
        $this->assertEquals('', $this->robot->report());

        //initial placement of robot
        $this->robot->place(0, 0, 'NORTH');
        $this->assertEquals('Output: 0, 0, NORTH', $this->robot->report());

        //test left()
        $this->robot->left();
        $this->assertEquals('Output: 0, 0, WEST', $this->robot->report());

        $this->robot->left();
        $this->assertEquals('Output: 0, 0, SOUTH', $this->robot->report());

        $this->robot->left();
        $this->assertEquals('Output: 0, 0, EAST', $this->robot->report());

        $this->robot->left();
        $this->assertEquals('Output: 0, 0, NORTH', $this->robot->report());
    }

    public function testRight()
    {
        //robot not placed
        $this->robot->right();
        $this->assertEquals('', $this->robot->report());

        //initial placement of robot
        $this->robot->place(0, 0, 'NORTH');
        $this->assertEquals('Output: 0, 0, NORTH', $this->robot->report());

        //test right()
        $this->robot->right();
        $this->assertEquals('Output: 0, 0, EAST', $this->robot->report());

        $this->robot->right();
        $this->assertEquals('Output: 0, 0, SOUTH', $this->robot->report());

        $this->robot->right();
        $this->assertEquals('Output: 0, 0, WEST', $this->robot->report());

        $this->robot->right();
        $this->assertEquals('Output: 0, 0, NORTH', $this->robot->report());
    }

    public function testMove()
    {
        //robot not placed yet
        $this->robot->move();
        $this->assertEquals('', $this->robot->report());

        //initial placement of robot
        $this->robot->place(0, 0, 'NORTH');
        $this->assertEquals('Output: 0, 0, NORTH', $this->robot->report());

        //test move() in NORTH direction
        $this->robot->move();
        $this->assertEquals('Output: 0, 1, NORTH', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 0, 2, NORTH', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 0, 3, NORTH', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 0, 4, NORTH', $this->robot->report());

        //invalid NORTH move
        $this->robot->move();
        $this->assertEquals('Output: 0, 4, NORTH', $this->robot->report());

        //set robot in EAST direction
        $this->robot->right();
        $this->assertEquals('Output: 0, 4, EAST', $this->robot->report());

        //test move() in the EAST direction
        $this->robot->move();
        $this->assertEquals('Output: 1, 4, EAST', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 2, 4, EAST', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 3, 4, EAST', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 4, 4, EAST', $this->robot->report());

        //invalid EAST move
        $this->robot->move();
        $this->assertEquals('Output: 4, 4, EAST', $this->robot->report());

        //set robot in the SOUTH direction
        $this->robot->right();
        $this->assertEquals('Output: 4, 4, SOUTH', $this->robot->report());

        //test move() in the SOUTH direction
        $this->robot->move();
        $this->assertEquals('Output: 4, 3, SOUTH', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 4, 2, SOUTH', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 4, 1, SOUTH', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 4, 0, SOUTH', $this->robot->report());

        //invalid SOUTH move
        $this->robot->move();
        $this->assertEquals('Output: 4, 0, SOUTH', $this->robot->report());

        //set robot in the WEST direction
        $this->robot->right();
        $this->assertEquals('Output: 4, 0, WEST', $this->robot->report());

        //test move() in the WEST direction
        $this->robot->move();
        $this->assertEquals('Output: 3, 0, WEST', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 2, 0, WEST', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 1, 0, WEST', $this->robot->report());

        $this->robot->move();
        $this->assertEquals('Output: 0, 0, WEST', $this->robot->report());

        //invalid SOUTH move
        $this->robot->move();
        $this->assertEquals('Output: 0, 0, WEST', $this->robot->report());
    }
}