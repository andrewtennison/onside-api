<?php
namespace Tests\Model;
use \Tests\Test;

class Article extends Test
{
//    private $article;
    
    public function setUp()
    {
        parent::setUp();
        $this->markTestSkipped();
//        $this->article = \Onside\Model\Article::getModelFromArray(array('name' => 'name of article'));
    }
    
    public function tearDown()
    {
        
        parent::tearDown();
    }
    
    public function testArticle()
    {}
}
