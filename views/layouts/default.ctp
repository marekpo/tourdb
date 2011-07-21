<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php __('TourDB'); ?> :: <?php echo $title_for_layout; ?></title>
    <?php echo $this->Html->meta('icon'); ?>
    <?php echo $this->Html->css('tourdb'); ?>
    <?php echo $this->Html->css('jquery-ui-1.8.13.custom'); ?>
    <?php echo $this->Html->script('jquery-1.6.1.min'); ?>
    <?php echo $this->Html->script('jquery-ui-1.8.13.custom.min'); ?>
    <?php echo $this->Html->script('common'); ?>
    <?php echo $scripts_for_layout; ?>
  </head>

  <body>
    <div id="page">
      <div id="container">
        <div id="header">
          <div class="inner">header</div>
        </div>
  
        <div id="topnav">
          <div class="inner">
            topnav
            <div id="login_box">
<?php
	if($this->Session->check('Auth.User'))
	{
		echo sprintf(__('Angemeldet als %s', true), $this->Html->tag('span',
			$this->Session->read('Auth.User.username'), array('class' => 'username')));
		echo '&nbsp;|&nbsp;';
		echo $this->Html->link(__('Abmelden', true), array('controller' => 'users', 'action' => 'logout'));
	}
	else
	{
		echo $this->Html->link(__('Anmelden', true), array('controller' => 'users', 'action' => 'login'));
	}
?>
            </div>
          </div>
        </div>

        <div id="leftnav">
          <div class="inner">
<?php
	echo $this->element('menu', array(
		'cache' => array(
			'key' => ($this->Session->read('Auth.User.id') != null ? $this->Session->read('Auth.User.id') : 'anonymous'),
			'time' => '+1 hour'
		)
	));
?>
          </div>
        </div>

<?php
	$contentClass = Inflector::underscore($this->name);
	$contentClass .= (!empty($this->action) ? ' ' . Inflector::underscore($this->action) : '');
?>
        <div id="content" class="<?php echo $contentClass; ?>">
          <div class="inner">
            <?php echo $this->Session->flash('auth'); ?>
            <?php echo $this->Session->flash(); ?>
            <?php echo $content_for_layout; ?>
          </div>
        </div>

        <div id="footer">
          <div class="inner">footer</div>
        </div>
      </div>
    </div>
<?php
	if(isset($this->Js))
	{
		echo $this->Js->writeBuffer(); 
	}
?>
  </body>
</html>