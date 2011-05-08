<!DOCTYPE html>
<html>
  <head>
    <?php echo $this->Html->charset(); ?>
    <title><?php __('TourDB'); ?> :: <?php echo $title_for_layout; ?></title>
    <?php echo $this->Html->meta('icon'); ?>
    <?php echo $this->Html->css('tourdb'); ?>
    <?php echo $scripts_for_layout; ?>
  </head>

  <body>
    <div id="page">
      <div id="container">
        <div id="header">
          header
        </div>
  
        <div id="topnav">
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

        <div id="leftnav">
          leftnav
        </div>

        <div id="content">
          <?php echo $this->Session->flash(); ?>
          <?php echo $content_for_layout; ?>
        </div>

        <div id="footer">
          footer
        </div>
      </div>
    </div>
  </body>
</html>