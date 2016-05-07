 <!--wrap 开始--> 
  <div class="wrap_mhlist autoHeight"> 
   <div class="wrap_intro_l widthEigLeft con_left"> 
    <div class="wrap_intro_l_comic"> 
     <div class="comic_i"> 
      <div class="comic_i_img"> 
       <a href="#"><img src="<?php echo $comic_base_url.$comic->coverurl ?>" alt="" width="207" height="278" /></a> 
      </div> 
     </div> 
     <div class="comic_deCon"> 
      <h1><a href=""><?php echo $comic->name ?></a></h1> 
      <div class="comic_deCon_pf"></div> 
      <ul class="comic_deCon_liO"> 
       <li>作者：<?php echo $comic->author ?></li> 
       <li>状态：<?php echo $comic->status ?></li> 
       <li>题材：<?php echo $comic->types ?></li> 
      </ul> 
      <div class="cur_rule"></div> 
      <p class="comic_deCon_d"><?php echo $comic->description ?></p> 
      <a href="<?php echo $comic_base_url.$comic->coverdir.$comicnumlist[0]->dirname ?>/page.html" target="_blank" class="beread_btn"><span></span>开始阅读</a> 
     </div> 
    </div> 
    <div class="zj_list autoHeight"> 
     <div class="zj_list_head"> 
      <span class="zj_list_head_tb"></span> 
      <h2>章节<em class="c_3">列表</em></h2> 
      <!--<span class="zj_list_head_dat">[ 更新时间：2016-05-06 ]</span>-->
     </div> 
     <div class="tab-content zj_list_con autoHeight tab-content-selected"> 
      <ul class="list_con_li autoHeight"> 
		<?php foreach($comicnumlist as $_comicnum){ ?>
       <li><a href="<?php echo $comic_base_url.$comic->coverdir.$_comicnum->dirname ?>/page.html" target="_blank"><span class="list_con_tb"></span><span class="list_con_zj"><?php echo $_comicnum->numname; ?></span></a></li> 
	   <?php } ?>
      </ul> 
      <div class="fg"></div> 
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
        <li><a href="#">连载</a> </li> 
        <li><a href="#">完结</a> </li> 
       </ul> 
      </div> 
      <div class="public_com"> 
       <span class="subjec_img"></span> 
       <span class="statu_title">题材</span> 
       <ul class="sear_cate"> 
        <li><a class="cat" href="">全部</a></li> 
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
        <li><a class="cat" href="#>全部</a></li> 
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