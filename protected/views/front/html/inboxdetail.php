<script>
$(document).ready(function(){
$(".inbox_smart2").mCustomScrollbar();
$(".inboxdetail_cont").mCustomScrollbar();
 }); 
</script>


 <div class="page-container pagetopmargn">
<div class="inbox_cont">
<!--Left side bar start here-->
  <div class="inbox_left">
  <!--Top search start here-->
  <div class="left_search">
<div class="left_searchcol1">
<img src="<?php  echo CommonUtility::getPublicImageUri( "in-searchic.png" ) ?>" />
 </div>
<div class="left_searchcol2"><input name="" type="text" placeholder="Search messages"/></div>
<div class="left_searchcol3">
<img src="<?php  echo CommonUtility::getPublicImageUri( "in-closeic.png" ) ?>" />
</div>
  </div>
  <!--Top search Ends here-->
  
  <!--Smart search start here-->
  <div class="inbox_smart2">
  <ul>
<li><a href="#" class="active">Show all</a></li>
<li><a href="#">Task title 1<span class="messcount">12</span></a></li>
<li><a href="#">Task title 2</a></li>
<li><a href="#">Task title 3</a></li>
<li><a href="#">Task title 4 </a></li>
<li><a href="#">Task title 5</a></li>
<li><a href="#">Task title 6</a></li>
<li><a href="#">Task title 7</a></li>
<li><a href="#">Task title 8 </a></li>
<li><a href="#">Task title 9</a></li>
  </ul>
  </div>
  <!--Smart search ends here-->
  
  
   <!--filter start here-->
  <div class="inbox_filter">
  <h2>Filter</h2>
  <ul>
  <li><a href="#">Hosting detail<span class="messcount">12</span></a></li>
  <li><a href="#">Payment</a></li>
  <li><a href="#">Dispute<span class="messcount">3</span></a></li>
  <li>
  <div class="infiltercol1"><label>Date</label>
<input type="text" placeholder="Select date" name=""></div>
  </li>
  </ul>
  </div>
  <!--filter ends here-->
  
  
  </div>
<!--Left side bar ends here-->

<!--Right side content start here-->
<div class="rightbar">

<!--top head sort by start here-->
<div class="sortby_row">
<div class="ntointrested">
<div class="selectall"><input type="checkbox" value="" name=""> Sletect all</div>
<div class="innav">
<ul>
<li><a href="#">Archive</a></li>
<li><a href="#">Delete</a></li>
</ul>
</div>
</div>   
<div class="sortby">
<select class="span1" name="archive">
<option>Mark</option>
</select>
<select class="span2" name="archive">
<option>Sort by</option>
</select>
</div>
</div>
<!--top head sort by ends here-->


<!--right message start here-->
<div class="controls-row pdn6"> 
 
<!--reply start here-->  
<div class="inboxdetail_cont">
<div class="replymess">
<div class="inboxdetail_row2">
<div class="item_labelblue">
<span class="proposal_label_blue">Open</span>
</div>
<div class="inboximg"><img src="<?php  echo CommonUtility::getPublicImageUri( "prv_img.jpg" ) ?>" /></div>
<p class="task_name"><a href="#">Let us deep clean your windows or carpet</a></p>
<div class="proposal_col4 ">Post date: <span class="date">07-04-2013 </span></div>
<div class="proposal_col4 ">Total message: <span class="date">10</span></div>
</div>

<div class="inboxdetail_row1">
<div class="replymess2">Me <span class="date">07-04-2013 </span></div>
<div class="replymess3">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim </div>
<div class="reply_col3"><a class="interested_btn" href="#">Mark as read</a></div>
<div class="reply_col3"><a href="#"><img src="<?php  echo CommonUtility::getPublicImageUri( "tag.png" ) ?>" /></a></div>
</div>

<div class="inboxdetail_row1">
<div class="replymess2">Walter <span class="date">10-04-2013 </span></div>
<div class="replymess3">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim </div>
<div class="reply_col3"><a class="interested_btn" href="#">Mark as unread</a></div>
<div class="reply_col3"><a href="#"><img src="<?php  echo CommonUtility::getPublicImageUri( "tag.png" ) ?>" /></a></div>
</div>

<div class="inboxdetail_row1">
<div class="replymess2">Me <span class="date">11-04-2013 </span></div>
<div class="replymess3">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim </div>
<div class="reply_col3"><a class="interested_btn" href="#">Mark as read</a></div>
<div class="reply_col3"><a href="#"><img src="<?php  echo CommonUtility::getPublicImageUri( "tag.png" ) ?>" /></a></div>
</div>

<div class="inboxdetail_row1">
<div class="replymess2">Walter <span class="date">12-04-2013 </span></div>
<div class="replymess3">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim </div>
<div class="reply_col3"><a class="interested_btn" href="#">Mark as unread</a></div>
<div class="reply_col3"><a href="#"><img src="<?php  echo CommonUtility::getPublicImageUri( "tag.png" ) ?>" /></a></div>
</div>

<div class="inboxdetail_row1">
<div class="replymess2">Me <span class="date">12-04-2013 </span></div>
<div class="replymess3">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim </div>
<div class="reply_col3"><a class="interested_btn" href="#">Mark as read</a></div>
<div class="reply_col3"><a href="#"><img src="<?php  echo CommonUtility::getPublicImageUri( "tag.png" ) ?>" /></a></div>
</div>

</div>

</div>
<!--reply ends here-->           
</div>
<!--right message ends here-->

</div>
</div>
<!--Right side content ends here-->

</div>
</div>