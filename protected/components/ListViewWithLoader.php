<?php
Yii::import('zii.widgets.CListView');
class ListViewWithLoader extends CListView
{

public $preItemsTag = '';
public $postItemsTag = '';

public function renderItems()
{
    echo $this->preItemsTag."\n";
    echo UtilityHtml::getAjaxLoading("rootCategoryLoadingImg");
    $data=$this->dataProvider->getData();
    if(($n=count($data))>0)
    {
        $owner=$this->getOwner();
        $render=$owner instanceof CController ? 'renderPartial' : 'render';
        $j=0;
        foreach($data as $i=>$item)
        {
            $data=$this->viewData;
            $data['index']=$i;
            $data['data']=$item;
            $data['widget']=$this;
            $owner->$render($this->itemView,$data);
            if($j++ < $n-1)
                echo $this->separator;
        }
    }
    else
        $this->renderEmptyText();
    echo $this->postItemsTag."\n";

}


 }
 
// $pre_html = '<table><thead><th>Codice Account</th><th>Nome</th></thead><tbody>';
//$post_html = '</tbody></table>';
//
//$this->widget('zii.widgets.PlainCListView', array(
//                    'dataProvider'=>$dataProvider,
//                    'itemView'=>'_view', 
//                    'preItemsTag'=>$pre_html,
//                    'postItemsTag'=>$post_html,
//                    'summaryText'=>'Sono visualizzati i record da {start} a {end} su un totale di {count} libri',
//                    'pager' => Array(
//                    'header' => 'Vai alla pagina',
//                    'prevPageLabel' => 'Indietro',
//                    'nextPageLabel' => 'Avanti',
//                        ),
//                    'sortableAttributes'=>array('titolo'),
//                    'enableSorting'=>0,
//
//
//
//));
?>