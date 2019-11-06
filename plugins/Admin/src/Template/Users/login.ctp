<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
	<!--<a href="">
	<img src="<?php /*echo $this->request->webroot; */?>admin/backend/layout/img/logo-big.png" alt=""/>
	</a>-->
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<?php echo $this->Form->create('User', array('autocomplete'=>'off')) ?>
		<h3 class="form-title"><?php echo __('Login') ?></h3>
        <?php echo $this->Flash->render(); ?>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Email</label>
			<?php echo $this->Form->input('email', array('type' => 'email', 'class' => 'form-control', 'required' => true, 'autofocus' => true, 'placeholder' => 'Email address', 'autocomplete'=>'off', 'label'=>false)); ?>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<?php echo $this->Form->input('password', array('class' => 'form-control', 'required' => true, 'placeholder' => 'Password', 'autocomplete'=>'off', 'label'=>false)); ?>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-success uppercase">Login</button>
		</div>
	</form>
	<!-- END LOGIN FORM -->
</div>
<div class="copyright">
	© 2018
</div>
<!-- END LOGIN -->