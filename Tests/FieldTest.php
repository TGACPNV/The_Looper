<?php

namespace TheLooper\Model;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{


    static function setUpBeforeClass(): void
    {
        $sqlscript = file_get_contents(dirname(__DIR__, 1) . '/Doc/DB/SQL/Script.sql');
        DbConnector::execute($sqlscript);
    }

    /**
     * @covers Field::all()
     */
    public function testall(){
        $expectedAmount = 4;
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

    public function testSave()
    {
        $field = Field::find(1);
        $saveField = $field->label;
        $field->label = "testLabel";
        $this->assertTrue($field->save());
        $this->assertEquals("testLabel",Field::find(1)->label);
        $field->label = $saveField;
        $field->save();
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
        $this->assertEquals(2,count(Field::where("exercises_id",2)));
        $this->assertEquals(1,count(Field::where("exercises_id",3)));
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

    /**
     * @covers $field->takes()
     */
    public function testTake()
    {
        $this->assertEquals(3,count(Field::find(1)->takes()));
        $this->assertEquals(3,count(Field::find(2)->takes()));
        $this->assertEquals(3,count(Field::find(3)->takes()));
    }

    public static function tearDownAfterClass() : void
    {
        DBConnector::execute("DELETE FROM fields WHERE label = :label", ["label" => "Par ce que les grilles pains"]);
    }



}