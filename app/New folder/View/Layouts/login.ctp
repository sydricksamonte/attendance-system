<!DOCTYPE html>
<html>
<head>
  <?php echo $this->Html->charset(); ?>
  <title>
    <?php echo $cakeDescription ?>:
    <?php echo $title_for_layout; ?>
  </title>
  <?php
    echo $this->Html->meta('icon');

    echo $this->Html->css('cake.generic');
    echo $this->Html->css('bootstrap');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
  ?>
</head>
<body>
&nbsp;&nbsp;

<?php echo $this->Html->image('logo.jpg',array('alt'=>'CAKEPHP'))?>
<font face="Brush Script MT" size=6></font>
  <div id="container">
    <div class="colorwhite" align="right">
    </div>

    <div id="header">
    <div id="content">

<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php #echo __('Please enter your username and password');
											echo __('Login'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    </fieldset>
<div class="actions">
<?php echo $this->Form->end(__('Login')); ?>
</div>
    </div>
</td></tr></table>
    <div id="footer">
      <?php /*echo $this->Html->link(
          $this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
          'http://www.cakephp.org/',
          array('target' => '_blank', 'escape' => false)
        );
        */
      ?>
    </div>
  </div>
  <?php echo $this->element('sql_dump'); ?>
</body>
</html>

