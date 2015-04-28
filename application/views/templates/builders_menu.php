    <div class="menu" id="menu">
      
      		<div class="main" id="main">
      		  			
      			<h3><span class="fui-list"></span> <?php echo $this->lang->line('elements_heading')?></h3>
      			
      			<ul id="elements">
      				<li><a href="#" id="all"><?php echo $this->lang->line('all_elements')?></a></li>
      			</ul>
      			
      			<hr>
      			
      			<h3><span class="fui-windows"></span> <?php echo $this->lang->line('pages')?></h3>
      			
      			<ul id="pages">
      				<li style="display: none;" id="newPageLI">
      					<input type="text" value="index" name="page">
      					<span class="pageButtons">
      						<a href="" class="fileEdit"><span class="fui-new"></span></a>
      						<a href="" class="fileDel"><span class="fui-cross"></span></a>
      						<a class="btn btn-xs btn-primary btn-embossed fileSave" href="#"><span class="fui-check"></span></a>
      					</span>
      				</li>
      				<?php if( count( $siteData['pages'] ) == 0 ):?>
      				<li class="active">
      					<a href="#page1">index</a>
      					<span class="pageButtons">
      						<a href="" class="fileEdit"><span class="fui-new"></span></a>
      						<a class="btn btn-xs btn-primary btn-embossed fileSave" href="#"><span class="fui-check"></span></a>
      					</span>
      				</li>
      				<?php else:?>
      				
      				<?php $counter = 1;?>
      				
      				<?php foreach( $siteData['pages'] as $page => $frames ):?>
      				<li <?php if( $counter == 1 ):?>class="active"<?php endif;?>>
      					<a href="#page<?php echo $counter;?>"><?php echo $page;?></a>
      					<span class="pageButtons">
      						<a href="" class="fileEdit"><span class="fui-new"></span></a>
      						<?php if( $counter > 1 ):?>
      						<a href="" class="fileDel"><span class="fui-cross"></span></a>
      						<?php endif;?>
      						<a class="btn btn-xs btn-primary btn-embossed fileSave" href="#"><span class="fui-check"></span></a>
      					</span>
      				</li>
      				<?php $counter++;?>
      				<?php endforeach;?>
      				
      				<?php endif;?>
      			</ul>
      	
      			<div class="sideButtons clearfix">
      				<a href="#" class="btn btn-primary btn-sm btn-embossed" id="addPage"><span class="fui-plus"></span> <?php echo $this->lang->line('button_add_page')?></a>
      				<!--<a href="#exportModal" data-toggle="modal" class="btn btn-inverse btn-sm btn-embossed disabled actionButtons"><span class="fui-upload"></span> <?php echo $this->lang->line('button_publish_page')?></a>-->
      			</div>
      	
      		</div><!-- /.main -->
      	
      		<div class="second" id="second">
      		
      			<ul id="element">
      			
      			</ul>
      
      		</div><!-- /.secondSide -->
      	
      	</div><!-- /.menu -->