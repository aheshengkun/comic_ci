  <!--wrap_mhlist 开始--> 
  <div class="wrap_mhlist autoHeight"> 
   <div class="wrap_mhlist_l con_left"> 
    <div class="wrap_list_head"> 
     <div class="list_head_mid"> 
      <div class="head_title"> 
       <span class="head_ico_o"></span> 
       <h2>漫画<em class="c_3">列表</em></h2> 
      </div> 
     </div> 
    </div> 
    <div class="wrap_list_con"> 
     <span class="list_con_t">排序：</span> 
     <ul class="list_con_tabs "> 
      <li><a class=" tab-option-selected" href="#">更新时间</a>| </li> 
      <li><a class=" " href="#">热门人气</a></li> 
     </ul> 
     <div class="tab-con tab-content-selected autoHeight"> 
      <ul class="list_con_li"> 
	   <?php foreach($comiclist as $_comic){ ?>
		 <li><a target="_blank" class="comic_img" href="<?php echo base_url() ?>?comicname=<?php echo $_comic->name ?>"><img class="lazy" width="118" height="158" src="<?php echo $comic_base_url.$_comic->coverurl ?>" data-original="" /></a><span class="comic_list_det"><h3> <a target="_blank" href="<?php echo base_url() ?>?comicname=<?php echo $_comic->name ?>"><?php echo $_comic->name ?></a></h3><p>作者：<?php echo $_comic->author ?></p><p>题材：<?php echo $_comic->types ?></p> <p>状态：<?php echo $_comic->status ?></p> <a target="_blank" class="read_btn" href="<?php echo base_url() ?>?comicname=<?php echo $_comic->name ?>">开始阅读</a></span></li> 
	   <?php } ?>
      </ul> 
	  <div id="pagelist">
		  <ul>
			<?php echo $page; ?>
			<li class="pageinfo">第<?php echo $curPage;?>页</li>
			<li class="pageinfo">共<?php echo $totalPage;?>页</li>
		  </ul>
	  </div>
     </div> 
    </div> 
   </div> 
   <div class="wrap_mhlist_r con_right autoHeight"> 
    <div class="mhlist_r_search autoHeight"> 
     <div class="mhlist_r_head"> 
      <span class="head_ico_t"></span> 
      <h2>漫画<em class="c_3">检索</em></h2> 
      <span class="h_eng">RETRIEVE</span> 
     </div> 
     <div class="mhlist_r_con"> 
      <div class="public_com"> 
       <span class="statu_img"></span> 
       <span class="statu_title">状态</span> 
       <ul class="sear_cate"> 
        <li><a class="cat" href="#">全部</a> </li> 
        <li><a href="#">连载中</a> </li> 
        <li><a href="#">已完结</a> </li> 
       </ul> 
      </div> 
      <div class="public_com"> 
       <span class="subjec_img"></span> 
       <span class="statu_title">题材</span> 
       <ul class="sear_cate"> 
        <li><a class="cat" href="#">全部</a> </li> 
        <span id="subjectMatter"> 
			<?php foreach($typelist as $_type){ ?>
				<li><a href="#"><?php echo $_type->type; ?></a></li> 
			<?php } ?>
         </span> 
       </ul> 
      </div> 
      <div class="public_com"> 
       <span class="zm_img"></span> 
       <span class="statu_title">字母</span> 
       <ul class="sear_cate"> 
        <li><a class="cat" href="#">全部</a></li> 
        <li><a href="#">A</a></li> 
        <li><a href="#">B</a></li> 
        <li><a href="#">C</a></li> 
        <li><a href="#">D</a></li> 
        <li><a href="#">E</a></li> 
        <li><a href="#">F</a></li> 
        <li><a href="#">G</a></li> 
        <li><a href="#">H</a></li> 
        <li><a href="#">I</a></li> 
        <li><a href="#">J</a></li> 
        <li><a href="#">K</a></li> 
        <li><a href="#">L</a></li> 
        <li><a href="#">M</a></li> 
        <li><a href="#">N</a></li> 
        <li><a href="#">O</a></li> 
        <li><a href="#">P</a></li> 
        <li><a href="#">Q</a></li> 
        <li><a href="#">R</a></li> 
        <li><a href="#">S</a></li> 
        <li><a href="#">T</a></li> 
        <li><a href="#">U</a></li> 
        <li><a href="#">V</a></li> 
        <li><a href="#">W</a></li> 
        <li><a href="#">X</a></li> 
        <li><a href="#">Y</a></li> 
        <li><a href="#">Z</a></li> 
        <li><a href="#">0~9</a></li> 
       </ul> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div> 
 </body>
</html>