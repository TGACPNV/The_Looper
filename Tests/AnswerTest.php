<?php
namespace TheLooper\Model;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    static function setUpBeforeClass(): void
    {
        $sqlscript = file_get_contents(dirname(__DIR__, 1) . '/Doc/DB/SQL/Script.sql');
        DbConnector::execute($sqlscript);
    }

    /**
     * @covers Answer::all()
     */
    public function testAll()
    {
        $this->assertEquals(12,count(Answer::all()));
    }

    /**
     * @covers Answer::find(id)
     */
    public function testFind()
    {
        $this->assertInstanceOf(Answer::class,Answer::find(1));
        $this->assertNull(Answer::find(1000));
    }

    /**
     * @covers $Answer->create()
     */
    public function testCreate()
    {
        $Answer = new Answer();
        $Answer->response = "UnitTest";
        $Answer->field = Field::find(3);
        $Answer->take = Take::find(2);
        $this->assertTrue($Answer->create());
    }

    /**
     * @covers $Answer->save()
     */
    public function testSave()
    {
        $Answer = Answer::find(1);
        $saveresponse = $Answer->response;
        $Answer->response = "newname";
        $this->assertTrue($Answer->save());
        $this->assertEquals("newname",Answer::find(1)->response);
        $Answer->response = $saveresponse;
        $Answer->save();
    }

    /**
     * @covers $Answer->delete()
     */
    public function testDelete()
    {
        $Answer = Answer::make(['response' => "PHPUnit", 'field' => Field::find(3), 'take' => Take::find(3)]);
        $Answer->create();
        $id = $Answer->id;
        $this->assertTrue($Answer->delete()); // expected to succeed
        $this->assertNull(Answer::find($id)); // we should not find it back
    }

    /**
     * @covers Answer::destroy(id)
     */
    public function testDestroy()
    {
        $Answer = Answer::make(['response' => "PHPUnit", 'field' => Field::find(3), 'take' => Take::find(3)]);
        $Answer->create();
        $id = $Answer->id;
        $this->assertTrue(Answer::destroy($id)); // expected to succeed
        $this->assertNull(Answer::find($id)); // we should not find it back
    }

    public static function tearDownAfterClass() : void
    {
        DBConnector::execute("DELETE FROM Answers WHERE response = :response", ["response" => "UnitTest"]);
    }
}