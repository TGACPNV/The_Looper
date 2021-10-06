<?php

namespace TheLooper\Model;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{


    static function setUpBeforeClass(): void
    {
        $sqlscript = file_get_contents(dirname(__DIR__,1).'/Doc/DB/MPD/MPD.sql');
        DbConnector::execute($sqlscript);
    }

    /**
     * @covers Field::all()
     */
    public function testall(){
        $expectedAmount = 3;
        $actualAmount = count(Field::all());

        $this->assertEquals($expectedAmount,$actualAmount);
    }

    /**
     * @covers Field::find()
     */
    public function testFind()
    {
        $this->assertInstanceOf(Field::class,Field::find(1));
        $this->assertNull(Field::find(1000));
    }

    /**
     * @covers $field->create()
     */
    public function testCreate(){
        $field = new Field("Par ce que les grilles pains",FieldValueKind::SINGLE_LINE,1);
        $this->assertTrue($field->create());
    }

    /**
     * @covers $field->delete()
     * @depends testCreate
     */
    public function testDelete()
    {
        $field = new field("La question",FieldValueKind::SINGLE_LINE,1);
        $field->create();
        $id = $field->getId();
        $this->assertTrue($field->delete()); // expected to succeed
        $this->assertNull(Field::find($id)); // we should not find it back
    }

    /**
     * @covers Field::where
     */
    public function testWhere()
    {
        $this->assertEquals(1,count(field::where("exercises_id",2)));
        $this->assertEquals(0,count(field::where("exercises_id",6)));
    }

    /**
     * @covers Field::destroy(id)
     * @depends testCreate
     * @depends testFind
     */
    public function testDestroy()
    {
        $field = new Field("testDestroy",FieldValueKind::LIST_OF_LINES,1);
        $field->create(); // to get an id from the db
        $id = $field->getId();
        $this->assertTrue(Field::destroy($id)); // expected to succeed
        $this->assertNull(Field::find($id)); // we should not find it back
    }



}