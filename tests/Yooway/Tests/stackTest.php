<?php
use PHPUnit\Framework\TestCase;

use Yooway\Scenario\Model\Matrix;
use Yooway\Scenario\Model\WineList;
use Yooway\Scenario\Model\Questions;
require __DIR__.'/../../../src/Yooway/Scenario/Model/Matrix.php';
require __DIR__.'/../../../src/Yooway/Scenario/Model/Questions.php';
require __DIR__.'/../../../src/Yooway/Scenario/Model/WineList.php';

class StackTest extends TestCase
{
    public function testMatrix()
    {
        $matrix=new Matrix();
        $this->assertNotEquals($matrix,"");
        $questions=new Questions();
        $q=$questions->findQuestion("question4");
        $winelist=new WineList();
        $selectionnes=$winelist->getList();

        $matrix->pushElement(4,$q);
        $matrix->pushWines($selectionnes);
        $directives=$matrix->getDirectives();
        print_r($directives);
    }
    public function testQuestions()
    {
        $questions=new Questions();
        $this->assertNotEquals($questions,"");
        $q=$questions->findQuestion("question4");
        $this->assertNotEquals($q,"");
        
    }
    public function testWineList()
    {
        $winelist=new WineList();
        $nb=count($winelist->list);
//        print_r($winelist->list);
        $selectionnes=$winelist->getList();
        $this->assertEquals($nb,count($selectionnes));

        $winelist->removeWine(9);
        $selectionnes=$winelist->getList();
        $this->assertEquals($nb-1,count($selectionnes));

        $winelist->removeCriteriaBoolean("color","red");
        $selectionnes=$winelist->getList();
        $nb2=count($selectionnes);       
        $winelist->reset();
        $winelist->removeCriteriaBoolean("color","white");
        $selectionnes=$winelist->getList();
        $nb2+=count($selectionnes);
        $this->assertEquals($nb,$nb2);

    }
}
?>