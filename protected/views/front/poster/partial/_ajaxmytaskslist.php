 <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $task,
            'itemView' => '_mytaskslist',
            'viewData' => array('dataProvider' => $task)
        ));
        ?>
		
		