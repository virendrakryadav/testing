<div class="margin-bottom-30">
    <div id="accordion" class="panel-group">
        <?php $this->renderPartial('//tasker/_proposaldetailfilter',array('task' => $task,'maxPrice' => $maxPrice ,'minPrice' => $minPrice ));?>
        <?php $this->renderPartial('//tasker/_proposalssidebar',array('task' => $task,'proposals' => $proposals));?>
    </div>
</div>