<?php $this->load->view('admin/header'); ?>
<nav>
<?php $this->load->view('admin/left_menu'); ?> 
</nav>
<section class="main-content">
	<h1>Contacts</h1>
	    <?php
		$frmAttrs   = array("id"=>'viewFrm','class' => 'view_contacts');
		echo  form_open_multipart('#',$frmAttrs); 
	    ?>
	
	    	<div>
		    	<label for="user_id">Name</label>
			<input type="text" id="name" name="name" value="<?php echo $contacts['name'];?>" readonly="readonly">
			
		</div>
		<div>
		    	<label for="user_id">Email</label>
			<input type="text" id="email" name="email" value="<?php echo $contacts['email'];?>" readonly="readonly">		
		</div>	
		<div>
		    	<label for="user_id">Contact No.</label>
			<input type="text" id="phone" name="phone" value="<?php echo $contacts['contact_no'];?>" readonly="readonly">	
		</div>	
		<div>
		    	<label for="user_id">Comment</label>
			<textarea id="comment" name="comment"readonly="readonly"><?php echo $contacts['comment'];?></textarea>
		</div>		    	
	    <?=form_close()?>	   
</section>

<?php $this->load->view('admin/footer'); ?> 
