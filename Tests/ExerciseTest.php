<?php
namespace TheLooper\Model;
use PHPUnit\Framework\TestCase;

class ExerciseTest extends TestCase
{
    /**
     * @covers Exercise::all()
     */
    public function testAll()
    {
        $this->assertEquals(3,count(Exercise::all()));
    }

    /**
     * @covers Exercise::find(id)
     */
    public function testFind()
    {
        $this->assertInstanceOf(Exercise::class,Exercise::find(1));
        $this->assertNull(Exercise::find(1000));
    }

    /**
     * @covers $exercise->create()
     */
    public function testCreate()
    {
        $exercise = new Exercise();
        $exercise->title = "UnitTest";
        $exercise->state = 1;
        $this->assertTrue($exercise->create());
        $this->assertFalse($exercise->create());
    }

    /**
     * @covers $exercise->save()
     */
    public function testSave()
    {
        $exercise = Exercise::find(1);
        $savetitle = $exercise->title;
        $exercise->title = "newname";
        $this->assertTrue($exercise->save());
        $this->assertEquals("newname",Exercise::find(1)->title);
        $exercise->title = $savetitle;
        $exercise->save();
    }

    /**
     * @covers $exercise->save() doesn't allow duplicates
     */
    public function testSaveRejectsDuplicates()
    {
        $exercise = Exercise::find(1);
        $exercise->title = Exercise::find(2)->title;
        $this->assertFalse($exercise->save());
    }

    /**
     * @covers $exercise->delete()
     */
    public function testDelete()
    {
        $exercise = Exercise::make(["title" => "PHPUnit", "state" => 1]);
        $exercise->create();
        $id = $exercise->id;
        $this->assertTrue($exercise->delete()); // expected to succeed
        $this->assertNull(Exercise::find($id)); // we should not find it back
    }

    /**
     * @covers Exercise::destroy(id)
     */
    public function testDestroy()
    {
        $exercise = Exercise::make(["title" => "PHPUnit", "state" => 1]);
        $exercise->create();
        $id = $exercise->id;
        $this->assertTrue(Exercise::destroy($id)); // expected to succeed
        $this->assertNull(Exercise::find($id)); // we should not find it back
    }


    public static function tearDownAfterClass() : void
    {
        DBConnector::execute("DELETE FROM exercises WHERE title = :title", ["title" => "UnitTest"]);
    }
}