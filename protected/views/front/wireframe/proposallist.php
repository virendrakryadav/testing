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
<div class="col-md-12  margin-bottom-10">
<div class="btn-group width-100">
<button type="button" class="btn-u btn-u-blue width-80">
<i class="fa fa-home home-size18"></i>
Menu
</button>
<button type="button" class="btn-u btn-u-blue btn-u-split-blue dropdown-toggle width-20" data-toggle="dropdown">
<i class="fa fa-angle-down arrow-size18"></i>
<span class="sr-only">Toggle Dropdown</span>                            
</button>
<ul class="dropdown-menu width-100" role="menu">
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
<div class="margin-bottom-30">
<div class="notifi-set">
    <ul>
  <li><a href="#" class="active">New project</a></li>
  <li><a href="#">Open projects</a></li>
  <li><a href="#">Current projects</a></li>
  <li><a href="#">Completed projects</a></li>
  <li><a href="#">All projects</a></li>  
  <li><a href="#">Favorite Doers</a></li>
    </ul>
    </div>
<div class="clr"></div>  
</div>
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
<li><a href="#">Previously hired</a></li>
<li><a href="#">Premium task</a></li>
<li><a href="#">Highly rated</a></li>
<li><a href="#">Potential</a></li>
<li><a href="#">Most valued</a></li>
<li><a href="#">Invited</a></li>
</ul>
</div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Doer name</div>
<div class="col-md-12 pdn-auto">
<div class="col-md-10 no-mrg"><input type="text" placeholder="Enter tasker name" name="" class="form-control"></div>
<div class="col-md-1 no-mrg"><input type="button" class="btn-u btn-u-lg pdn-btn btn-u-sea" value="Go" name=""></div>
</div>
</div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Price range</div>
<div class="col-md-12 pdn-auto">
<div class="advnc_row2">
<input type="hidden" style="margin: 0 0 0 5px;max-width: 240px;width: 233px;" id="price_range" name="price_range">
<div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" style="margin: 0 0 0 5px;max-width: 240px;width: 233px;" id="price_range_slider">
<a style="left: 0%;" class="ui-slider-handle ui-state-default ui-corner-all" href="#"></a>
<a style="left: 100%;" class="ui-slider-handle ui-state-default ui-corner-all" href="#"></a></div>                        
Price range:<span id="priceRange">0-3000</span>
<input type="hidden" id="minprice" value="0" name="minprice">
<input type="hidden" id="maxprice" value="3000" name="maxprice">                    <!--<img src="../images/pricerange.jpg" style=" max-width:248px;width:251px; height:39px;">-->
</div>
</div>
<div class="clr"></div>
</div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Ratings</div>
<div class="col-md-12 pdn-auto">
<img src="../images/rating.png">
</div>
</div>

<div class="advncsearch">
<div class="advnc_row margin-bottom-10">Location</div>
<div class="col-md-12 pdn-auto">
<div class="col-md-12 no-mrg"><select id="category_template" name="category_template" class="form-control mrg5">
<option value="">Select your country/Region</option>
</select></div>
</div>
</div>

</div>
</div>
</div>
</div>

<div class="panel panel-default margin-bottom-20 sky-form">
<div class="panel-heading">
<h4 class="panel-title">
<a href="#collapse-Two" data-parent="#accordion" data-toggle="collapse">
My Projects
<span class="accordian-state"></span>
</a>
</h4>
</div>
<div class="panel-collapse collapse in sky-form" id="collapse-Two">
<div class="panel-body pdn-auto2">
<div class="col-md-12 no-pdn">
<div class="prvlist_box"> <a href="#"><img src="../images/pro_img_71x52.png"></a>
<p class="title">Website Design tester</p>
<p class="date">Done by : John     21-01-2014</p>
<p><a id="loadinstantcategories_542" href="#">View</a></p>
</div>
</div>

<div class="col-md-12 no-pdn">
<div class="prvlist_box"> <a href="#"><img src="../images/pro_img_71x52.png"></a>
<p class="title">Website Design tester</p>
<p class="date">Done by : John     21-01-2014</p>
<p><a id="loadinstantcategories_542" href="#">View</a></p>
</div>
</div>

<div class="col-md-12 no-pdn">
<div class="prvlist_box"> <a href="#"><img src="../images/pro_img_71x52.png"></a>
<p class="title">Website Design tester</p>
<p class="date">Done by : John     21-01-2014</p>
<p><a id="loadinstantcategories_542" href="#">View</a></p>
</div>
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

<div class="proposal_cont">
<div class="proposal_list">
<div class="tasker_row1">
<div class="proposal_prof2"><img src="../images/tasker-img.jpg"></div>
<div class="proposal_col">
<div class="proposal_row">
<p class="proposal_title"><a href="#">Clean out tivoli enterprise console database </a></p>
<div class="proposal_col4 ">Post date: <span class="date">07-04-2013 </span></div>
<div class="proposal_col4 ">Bid start date: <span class="date">07-04-2013 </span></div>
<div class="proposal_col4 ">Project type: <span class="date">virtual</span></div>
<div class="proposal_col4 ">Category: <span class="date">admin</span></div>
<div class="proposal_col4 ">Estimated price: <span class="date">$230</span></div>
<div class="proposal_col4"><span class="mile_away">Skills</span></div>
<div class="proposal_col4"><span class="mile_away">Location</span></div>
</div>              
</div>
<div class="proposal_row3">
  <div class="total_task2"><span class="counttext">Total Proposal</span> <span class="countbox">10</span></div>
  <div class="total_task2"><span class="counttext">Average rating</span> <span class="countbox"><img src="../images/rating.png"></span></div>
  <div class="total_task2"><span class="counttext">Average price</span> <span class="countbox">$200</span></div>
 <div class="invite-cont"> 
<div class="total_task3"><input type="button" class="btn" value="Cancel" name=""></div>
<div class="total_task3"><input type="button" class="btn" value="View" name=""></div>
</div>
</div>
</div>
</div>
</div>

<h2 class="h2 text-30a">Proposals List</h2>

<div class="margin-bottom-30">
<div class="sortby-row margin-bottom-20"> 
<div class="ntointrested">
<label class="checkbox"><input type="checkbox" name="" value=""><i></i>Show not interested</label>
</div>                     
<div class="col-md-3 sortby-noti no-mrg">
<select class="form-control mrg3">
<option>Sort by</option>
</select>
</div>
</div>


<!--Tasker list start here-->
<div class="col-md-12 no-mrg">

<div class="proposal_list margin-bottom-10">
<div class="tasker_row1">
<div class="proposal_col1">
<div class="proposal_prof">
<img src="../images/tasker-img.jpg">
<div class="premiumtag2"><img src="../images/premium-item.png"></div>
<div class="ratingtsk"><img src="../images/rating.png"></div></div>
<div class="pro-icon-cont">
<div class="proposal_rating">
<div class="iconbox3"><img src="../images/yes.png"></div>
<div class="iconbox4"><img src="../images/bell.png"></div>
<div class="iconbox4"><img src="../images/fevorite.png"></div>
</div>
<div class="total_task">Task completed: <span class="mile_away">10</span></div>
<div class="proposal_btn"><a class="btn-u rounded btn-u-sea display-b" href="#">Hire me</a></div>
<div class="proposal_btn"><a class="btn-u rounded btn-u-blue display-b" href="#">Message</a></div>
</div>
</div>

<div class="proposal_col2">
<div class="proposal_row">
<div class="newcol1">
<p class="tasker_name"><a href="#">John Smith <span class="tasker_city">NYK</span></a></p>
<div class="tasker_col4 "><span class="date">Date: 6-4-2014</span></div>
<div class="tasker_col4 "><span class="mile_away">1.5 miles away</span> </div>
<div class="tasker_col4"><span class="proposal_price">$200</span></div>
</div>
<div class="newcol2">
<div class="taskerhired taskerlist_total"><span class="taskercount">10</span><br>Total</div><div class="taskerhired otherhired"><span class="taskercount">10</span><br>Others</div>
<div class="taskerhired taskerlist_network"><span class="taskercount">5</span><br> Networks</div>
<div class="taskerhired taskerlist_youhired"><span class="taskercount">2</span><br> You hired</div>
</div>
</div>  
<div class="proposal_row1">
<div class="total_task">Skills: <span class="graytext">Carpentry, Woodworking, Plumbing</span></div>

</div>  

<div class="proposal_row2"><strong>Description:</strong> Care for established lawns by mulching, aerating, weeding, grubbing and removing thatch, and 
trimming and edging around flower beds, walks, and walls. Plant seeds, bulbs, foliage, flowering plants, grass, 
ground covers, trees, and shrubs, and apply mulch for protection, using gardening tools... <a href="#">view detail</a></div>            
</div>
</div>
</div>

<div class="proposal_list margin-bottom-10">
<div class="tasker_row1">
<div class="proposal_col1">
<div class="proposal_prof">
<img src="../images/tasker-img.jpg">
<div class="premiumtag2"><img src="../images/premium-item.png"></div>
<div class="ratingtsk"><img src="../images/rating.png"></div></div>
<div class="pro-icon-cont">
<div class="proposal_rating">
<div class="iconbox3"><img src="../images/yes.png"></div>
<div class="iconbox4"><img src="../images/bell.png"></div>
<div class="iconbox4"><img src="../images/fevorite.png"></div>
</div>
<div class="total_task">Task completed: <span class="mile_away">10</span></div>
<div class="proposal_btn"><a class="btn-u rounded btn-u-sea display-b" href="#">Hire me</a></div>
<div class="proposal_btn"><a class="btn-u rounded btn-u-blue display-b" href="#">Message</a></div>
</div>
</div>

<div class="proposal_col2">
<div class="proposal_row">
<div class="newcol1">
<p class="tasker_name"><a href="#">John Smith <span class="tasker_city">NYK</span></a></p>
<div class="tasker_col4 "><span class="date">Date: 6-4-2014</span></div>
<div class="tasker_col4 "><span class="mile_away">1.5 miles away</span> </div>
<div class="tasker_col4"><span class="proposal_price">$200</span></div>
</div>
<div class="newcol2">
<div class="taskerhired taskerlist_total"><span class="taskercount">10</span><br>Total</div><div class="taskerhired otherhired"><span class="taskercount">10</span><br>Others</div>
<div class="taskerhired taskerlist_network"><span class="taskercount">5</span><br> Networks</div>
<div class="taskerhired taskerlist_youhired"><span class="taskercount">2</span><br> You hired</div>
</div>
</div>  
<div class="proposal_row1">
<div class="total_task">Skills: <span class="graytext">Carpentry, Woodworking, Plumbing</span></div>

</div>  

<div class="proposal_row2"><strong>Description:</strong> Care for established lawns by mulching, aerating, weeding, grubbing and removing thatch, and 
trimming and edging around flower beds, walks, and walls. Plant seeds, bulbs, foliage, flowering plants, grass, 
ground covers, trees, and shrubs, and apply mulch for protection, using gardening tools... <a href="#">view detail</a></div>            
</div>
</div>
</div>

<div class="proposal_list margin-bottom-10">
<div class="tasker_row1">
<div class="proposal_col1">
<div class="proposal_prof">
<img src="../images/tasker-img.jpg">
<div class="premiumtag2"><img src="../images/premium-item.png"></div>
<div class="ratingtsk"><img src="../images/rating.png"></div></div>
<div class="pro-icon-cont">
<div class="proposal_rating">
<div class="iconbox3"><img src="../images/yes.png"></div>
<div class="iconbox4"><img src="../images/bell.png"></div>
<div class="iconbox4"><img src="../images/fevorite.png"></div>
</div>
<div class="total_task">Task completed: <span class="mile_away">10</span></div>
<div class="proposal_btn"><a class="btn-u rounded btn-u-sea display-b" href="#">Hire me</a></div>
<div class="proposal_btn"><a class="btn-u rounded btn-u-blue display-b" href="#">Message</a></div>
</div>
</div>

<div class="proposal_col2">
<div class="proposal_row">
<div class="newcol1">
<p class="tasker_name"><a href="#">John Smith <span class="tasker_city">NYK</span></a></p>
<div class="tasker_col4 "><span class="date">Date: 6-4-2014</span></div>
<div class="tasker_col4 "><span class="mile_away">1.5 miles away</span> </div>
<div class="tasker_col4"><span class="proposal_price">$200</span></div>
</div>
<div class="newcol2">
<div class="taskerhired taskerlist_total"><span class="taskercount">10</span><br>Total</div><div class="taskerhired otherhired"><span class="taskercount">10</span><br>Others</div>
<div class="taskerhired taskerlist_network"><span class="taskercount">5</span><br> Networks</div>
<div class="taskerhired taskerlist_youhired"><span class="taskercount">2</span><br> You hired</div>
</div>
</div>  
<div class="proposal_row1">
<div class="total_task">Skills: <span class="graytext">Carpentry, Woodworking, Plumbing</span></div>

</div>  

<div class="proposal_row2"><strong>Description:</strong> Care for established lawns by mulching, aerating, weeding, grubbing and removing thatch, and 
trimming and edging around flower beds, walks, and walls. Plant seeds, bulbs, foliage, flowering plants, grass, 
ground covers, trees, and shrubs, and apply mulch for protection, using gardening tools... <a href="#">view detail</a></div>            
</div>
</div>
</div>

<div class="proposal_list margin-bottom-10">
<div class="tasker_row1">
<div class="proposal_col1">
<div class="proposal_prof">
<img src="../images/tasker-img.jpg">
<div class="premiumtag2"><img src="../images/premium-item.png"></div>
<div class="ratingtsk"><img src="../images/rating.png"></div>
</div>
<div class="pro-icon-cont">
<div class="proposal_rating">
<div class="iconbox3"><img src="../images/yes.png"></div>
<div class="iconbox4"><img src="../images/bell.png"></div>
<div class="iconbox4"><img src="../images/fevorite.png"></div>
</div>
<div class="total_task">Task completed: <span class="mile_away">10</span></div>
<div class="proposal_btn"><a class="btn-u rounded btn-u-sea display-b" href="#">Hire me</a></div>
<div class="proposal_btn"><a class="btn-u rounded btn-u-blue display-b" href="#">Message</a></div>
</div>
</div>

<div class="proposal_col2">
<div class="proposal_row">
<div class="newcol1">
<p class="tasker_name"><a href="#">John Smith <span class="tasker_city">NYK</span></a></p>
<div class="tasker_col4"><span class="date">Date: 6-4-2014</span></div>
<div class="tasker_col4"><span class="mile_away">1.5 miles away</span> </div>
<div class="tasker_col4"><span class="proposal_price">$200</span></div>
</div>
<div class="newcol2">
<div class="taskerhired taskerlist_total"><span class="taskercount">10</span><br>Total</div><div class="taskerhired otherhired"><span class="taskercount">10</span><br>Others</div>
<div class="taskerhired taskerlist_network"><span class="taskercount">5</span><br> Networks</div>
<div class="taskerhired taskerlist_youhired"><span class="taskercount">2</span><br> You hired</div>
</div>
</div>  
<div class="proposal_row1">
<div class="total_task">Skills: <span class="graytext">Carpentry, Woodworking, Plumbing</span></div>

</div>  

<div class="proposal_row2"><strong>Description:</strong> Care for established lawns by mulching, aerating, weeding, grubbing and removing thatch, and 
trimming and edging around flower beds, walks, and walls. Plant seeds, bulbs, foliage, flowering plants, grass, 
ground covers, trees, and shrubs, and apply mulch for protection, using gardening tools... <a href="#">view detail</a>
</div>            
</div>
</div>
</div>

</div>
<!--Tasker list ends here-->
</div>

</div>


