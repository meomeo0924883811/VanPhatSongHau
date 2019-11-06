<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="">
	<img src="<?php echo $this->request->webroot; ?>admin/backend/layout/img/logo-big.png" alt=""/>
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<?php echo $this->Form->create('User', array('autocomplete'=>'off')) ?>
		<h3 class="form-title"><?php echo __('Change password') ?></h3>
        <?php echo $this->Flash->render(); ?>

        <div class="alert alert-danger display-block">
            <button class="close" data-close="alert"></button>
            <span><?php echo __('Your password had over 60 days, please change password!!'); ?></span>
        </div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password', 'autocomplete' => 'off', 'required' => 'required', 'label'=>false)); ?>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">New password</label>
			<?php echo $this->Form->input('new_password', array('type'=>'password','id'=> 'new_password','class' => 'form-control', 'placeholder' => 'New password', 'autocomplete' => 'off', 'required' => 'required', 'label'=>false)); ?>
		</div>
		<div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Re-enter new password</label>
            <?php echo $this->Form->input('reenter_new_password', ['type'=>'password','class' => 'form-control', 'placeholder' => 'Re-enter the new password', 'autocomplete' => 'off', 'required' => 'required', 'label'=>false]);?>
        </div>
		<div class="form-actions">
			<button type="submit" class="btn btn-success uppercase"><?php echo __('Change password') ?></button>
		</div>
	</form>
	<!-- END LOGIN FORM -->
</div>
<div class="copyright">
	© 2018
</div>
<!-- END LOGIN -->