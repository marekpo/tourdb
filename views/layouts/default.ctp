<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <?php echo $this->Html->charset(); ?>
    <title><?php __('Tourenangebot'); ?> :: <?php echo $title_for_layout; ?></title>
    <?php echo $this->Html->meta('icon'); ?>
    <?php echo $this->Html->meta('rss', '/tours/search.rss', array('title' => __('Aktuelle Touren', true))); ?>
    <?php echo $this->Html->meta('rss', array('controller' => 'appointments', 'action' => 'upcomingAppointments', 'ext' => 'rss'), array('title' => __('Aktuelle Anlässe', true))); ?>
    <?php echo $this->Html->css('tourdb'); ?>
    <?php echo $this->Html->css('jquery-ui-1.8.13.custom'); ?>
    <?php echo $this->Html->script('jquery-1.6.1.min'); ?>
    <?php echo $this->Html->script('jquery-ui-1.8.13.custom.min'); ?>
    <?php echo $this->Html->script('tourdb'); ?>
    <?php echo $scripts_for_layout; ?>
  </head>

  <body>
    <div id="page">
      <div id="container">
        <div id="header">
          <?php echo $this->Html->link($this->Html->image('sac_logo.png'), 'http://www.sac-baldern.ch/', array('escape' => false, 'class' => 'saclogo', 'target' => '_blank')); ?>
        </div>

        <div id="topnav">
          <div id="login_box">
<?php
	if($this->Session->check('Auth.User'))
	{
		echo sprintf(__('Eingeloggt als %s', true), $this->Html->tag('span',
			$this->Session->read('Auth.User.username'), array('class' => 'username')));
		echo '&nbsp;|&nbsp;';
		echo $this->Html->link(__('Ausloggen', true), array('controller' => 'users', 'action' => 'logout'));
	}
	else
	{
		echo $this->Html->link(__('Einloggen', true), array('controller' => 'users', 'action' => 'login'));
	}
?>
          </div>
        </div>
        <div id="navheader">
          <div class="inner">
            <?php echo $this->Html->link($this->Html->image('tourdb_logo.png'), array('controller' => 'tours', 'action' => 'search'), array('escape' => false, 'class' => 'sitelogo')); ?>
          </div>
        </div>
        <div id="contentheader">
          <div class="inner">
            <div id="breadcrumbs"><?php echo $this->Html->getCrumbs(' › ', __('Tourenangebot', true)); ?></div>
            <h1><?php echo $title_for_layout; ?></h1>
          </div>
        </div>
        <div id="leftnav">
          <div class="inner">
<?php
	echo $this->element('menu', array(
		'cache' => array(
			'key' => ($this->Session->check('Auth._SessionId') ? $this->Session->read('Auth._SessionId') : 'anonymous'),
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
          <div class="globallinks">
            <?php echo $this->Html->link(__('Hilfe', true), 'http://sac-baldern.ch/joomlaLive/index.php/touren-und-anlaesse/touren-anleitungen', array('target' => '_blank', 'title' => __('Anleitungen, Dokumentation, weitere Quellen', true))); ?>
            <?php echo $this->Html->link(__('Support', true), 'mailto:support-tourenangebot@sac-baldern.ch', array('target' => '_blank', 'title' => __('E-Mail an Support der Sektion schreiben', true))); ?>
            <?php echo $this->Html->link(__('Kontakt', true), 'http://sac-baldern.ch/', array('target' => '_blank', 'title' => __('Allgemeine Infos und Kontakt', true))); ?>
		    <?php echo $this->Html->link(__('Datenschutzbestimmungen', true), array('controller' => 'pages', 'action' => 'display', 'data_privacy_statement')); ?>
		  </div>
          <?php __('©2011-2012 Tourenangebot für SAC Sektion Baldern, Zürich'); ?>
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