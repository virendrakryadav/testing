<div class="container content">

<!--Left bar start here-->
<div class="col-md-3">
<!--Dashbosrd start here-->
<div class="margin-bottom-30">
<div class="grad-box">
<div class="col-md-12"><h2 class="heading-md color-orange">erandoo</h2></div>
<div class="col-md-12">
<span class="das-col"><a href="#"><img src="../images/das-ic-1.png"></a> </span>
<span class="das-col"><a href="#"><img src="../images/das-ic2.png"></a> </span>
<span class="das-col"><a href="#"><img src="../images/das-ic3.png"></a> </span>  
</div>
<div class="col-md-12 margin-bottom-10">
<div class="btn-group width-100">
<button class="btn-u btn-u-blue width-80" type="button">
<i class="fa fa-home home-size18"></i>
Menu
</button>
<button data-toggle="dropdown" class="btn-u btn-u-blue btn-u-split-blue dropdown-toggle width-20" type="button">
<i class="fa fa-angle-down arrow-size18"></i>
<span class="sr-only">Toggle Dropdown</span>                            
</button>
<ul role="menu" class="dropdown-menu width-100">
<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
<li><a href="#"><i class="fa fa-cog"></i> Notification Settings</a></li>
<li><a href="#"><i class="fa fa-search"></i> Find Doer</a></li>
<li><a href="#"><i class="fa fa-search"></i> Find Project</a></li>
</ul>
</div>
</div>
<div class="clr"></div>             
</div>
</div>
<!--Dashbosrd start here-->

<!--left nav start here-->
<!--<div class="margin-bottom-30">
<div class="notifi-set">
    <ul>
  <li><a href="#" class="active">Completed projects</a></li>
  <li><a href="#">Favorite Posters</a></li>
    </ul>
    </div>
<div class="clr"></div>  
</div>-->
<!--left nav Ends here-->

<!--Filter Start here-->
<div class="margin-bottom-30">
<div id="accordion" class="panel-group">
<div class="panel panel-default margin-bottom-20 sky-form">
<div class="panel-heading">
<h4 class="panel-title">
<a href="#collapseOne" data-parent="#accordion" data-toggle="collapse">
Filter
<span class="accordian-state"></span>
</a>
</h4>
</div>
<div class="panel-collapse collapse in sky-form" id="collapseOne">
<div class="panel-body no-pdn">
<div class="col-md-12 no-mrg">

<div class="advncsearch">
<div class="advnc_row">
<div class="fltbtn_cont"><a href="javascript:void(0)" class="btn-u rounded btn-u-red" id="resetFilter">Reset Filter</a></div>
<div class="fltbtn_cont1"></div>
<div id="saveFilter" class="fltbtn_cont2">
<a href="#" class="btn-u rounded btn-u-sea" id="saveFilter">Save filter</a> 
</div>
<div class="clr"></div></div>
<div id="saveFilterForm"></div>
</div>

<div class="smartsearch">
<ul>
<li><a href="#">All</a></li>
<li><a href="#">Open</a></li>
<li><a href="#">Close</a></li>
<li><a href="#">Awarded</a></li>
<li><a href="#">Cancel</a></li>
</ul>
</div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Project Type</div>
<div class="col-md-12 pdn-auto">
<div class="col-md-12 no-mrg"><input type="text" placeholder="Enter project name" name="" class="form-control"></div>
</div>
<div class="clr"></div></div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Category</div>
<div class="col-md-12 pdn-auto">
<div class="advnc_row2">
<div class="advnc_row3">
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>Web designing</label>
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>Mobile application</label></div>
<div class="advnc_col6"><label class="checkbox"><input type="checkbox" value="" name=""><i></i>Web designing</label>
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>Mobile application</label></div>
</div>
</div>
<div class="clr"></div></div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Skills</div>
<div class="col-md-12 pdn-auto">
<div class="advnc_row2">
<div class="advnc_row3">
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>Cake PHP</label>
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>Core PHP</label>
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>Html code</label>
<label class="checkbox"><input type="checkbox" value="" name=""><i></i>MYSQL</label><label class="checkbox"><input type="checkbox" value="" name=""><i></i>Zend Framework</label>
</div>
</div>
</div>
<div class="clr"></div></div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Project name</div>
<div class="col-md-12 pdn-auto">
<div class="col-md-10 no-mrg"><input type="text" class="form-control" name="" placeholder="Enter project name"></div>
<div class="col-md-1 no-mrg"><input type="button" name="" value="Go" class="btn-u btn-u-lg pdn-btn btn-u-sea"></div>
</div>
<div class="clr"></div></div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Price range</div>
<div class="col-md-12 pdn-auto">
<div class="advnc_row2">
                        <input type="hidden" name="price_range" id="price_range" style="margin: 0 0 0 5px;max-width: 240px;width: 233px;"><div id="price_range_slider" style="margin: 0 0 0 5px;max-width: 240px;width: 233px;" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><a href="#" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 0%;"></a><a href="#" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 100%;"></a></div>                        Price range:<span id="priceRange">0-3000</span>
                        <input type="hidden" name="minprice" value="0" id="minprice">                        <input type="hidden" name="maxprice" value="3000" id="maxprice">                    <!--<img src="../images/pricerange.jpg" style=" max-width:248px;width:251px; height:39px;">-->
                    </div>
</div>
<div class="clr"></div></div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Date</div>
<div class="col-md-12 pdn-auto">
<div class="col-md-12 no-mrg"><input type="text" class="form-control" name="" placeholder="Select date"></div>
<div class="clr"></div></div>
</div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Ratings</div>
<div class="col-md-12 pdn-auto">
<img src="../images/rating.png">
</div>
<div class="clr"></div></div>


</div>
</div>
</div>
</div>

</div>
<div class="clr"></div>
</div>
<!--Filter Ends here-->


</div>
<!--Left bar Ends here-->

<!--Right part start here-->
<div class="col-md-9 sky-form">
<h2 class="h2 text-30a">My Projects</h2>

<div class="margin-bottom-30">
<div class="sortby-row margin-bottom-20"> 
<div class="ntointrested"> Found 100 results</div>                     
<div class="col-md-3 sortby-noti no-mrg">
<select class="form-control mrg3">
<option>Sort by</option>
</select>
</div>
</div>


<!--Tasker list start here-->
<div class="col-md-12 no-mrg">
<div class="proposal_list task_list margin-bottom-10">
<div class="item_labelblue"><span class="task_label_text3">Open</span></div>
<div class="tasker_row1">
<div class="proposal_col1">
<div class="proposal_prof">
<img src="../images/tasker-img.jpg">
<div class="ratingtsk"><div class="rating_bar"></div></div>
</div>
</div>

<div class="proposal_col2">
<div class="proposal_row">
<p class="tasker_name"><a href="#">Project for translation<span class="premium">Premium</span></a> </p>
<div class="proposal_col4 ">Posted by: <a href="#">Walter</a></div>
<div class="proposal_col4 ">Post date: <span class="date">May 23, 2014</span></div>
<div class="proposal_col4 ">Task type: <span class="date">Virtual</span></div>
<div class="proposal_col4 ">Category: <span class="date">Translation</span></div>
<div class="publctask">Care for established lawns by mulching, aerating, weeding, grubbing and removing thatch, and trimming and edging around flower beds, walks, and walls.</div>
</div>             
</div>
<div class="proposal_row1">
<div class="total_task4"><span class="countbox"><img src="../images/bell.png"></span></div>
<div class="total_task4"><span class="counttext">Rating</span> <span class="countbox"><img src="../images/rating.png"></span></div>
<div class="total_task4"><span class="counttext">Price</span> <span class="countbox">$200</span></div>
<div class="total_task5"><a href="#">View proposal</a></div>
<div class="total_task5"><a href="#">Share</a></div>
<div class="total_task5"><a href="#">Review</a></div>
</div>
</div>
</div>

<div class="proposal_list task_list2 margin-bottom-10">
<div class="item_labelblue"><span class="task_label_text3">Open</span></div>
<div class="tasker_row1">
<div class="proposal_col1">
<div class="proposal_prof">
<img src="../images/tasker-img.jpg">
<div class="ratingtsk"><div class="rating_bar"></div></div>
</div>
</div>

<div class="proposal_col2">
<div class="proposal_row">
<p class="tasker_name"><a href="#">Hiring of website designer</a></p>
<div class="proposal_col4 ">Posted by: <a href="#">Walter</a></div>
<div class="proposal_col4 ">Post date: <span class="date">May 23, 2014</span></div>
<div class="proposal_col4 ">Task type: <span class="date">Virtual</span></div>
<div class="proposal_col4 ">Category: <span class="date">Translation</span></div>
<div class="publctask">Care for established lawns by mulching, aerating, weeding, grubbing and removing thatch, and trimming and edging around flower beds, walks, and walls.</div>
</div>              
</div>
<div class="proposal_row1">
<div class="total_task4"><span class="countbox"><img src="../images/bell.png"></span></div>
<div class="total_task4"><span class="counttext">Rating</span> <span class="countbox"><img src="../images/rating.png"></span></div>
<div class="total_task4"><span class="counttext">Price</span> <span class="countbox">$200</span></div>
<div class="total_task5"><a href="#">View proposal</a></div>
<div class="total_task5"><a href="#">Share</a></div>
<div class="total_task5"><a href="#">Review</a></div>
</div>
</div>
</div>

</div>
<!--Tasker list ends here-->
<div class="clr"></div>
</div>

</div>


