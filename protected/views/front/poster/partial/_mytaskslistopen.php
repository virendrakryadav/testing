<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $task,
        'itemView' => '_mytaskslist',
        'template'=>'{items} {pager}',
        'viewData' => array('dataProvider' => $task)
    ));
?>
