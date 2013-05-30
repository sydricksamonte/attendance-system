<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'Imperium Attendance System');
?>
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
        <?php echo $this->Html->image('out.png',array('url'=>array('controller' => 'Users', 'action' => 'logout')));?>
    	<?php echo $this->Html->link('Logout',array('controller' => 'Users', 'action' => 'logout'))?>
   	</div>

<center>
		<div id="header">
			<!--h1>
			<?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1-->
		</div>
<table><tr><td style="padding:30px;">
		<div class="colorw">
			<h2>Menu</h2>
			<!--div class="btn btn-primary">
			<?php #echo $this->Html->image('user--plus.png');?>
			<?php #echo $this->Html->link('Add new employees',array('controller' => 'Employees','action' => 'add_employee'))?>
			</div-->
			
			<div class="btn btn-primary">
				<?php echo $this->Html->image('users.png');?>
				<?php echo $this->Html->link('Employees',array('controller'=>'Employees','action' => 'index'))?>
			</div>
			<br>
			<div class="btn btn-primary">
				<?php echo $this->Html->image('calendar-search-result.png');?>
				<?php #echo $this->Html->link('Shifts',array('controller' => 'Shifts', 'action' => 'index'))?>
				<?php echo $this->Html->link('Shifts',array('controller' => 'Schedules', 'action' => 'index'))?>
			</div>

			<br>
			<div class="btn btn-primary">
				<?php echo $this->Html->image('clipboard--plus.png');?>
				<?php echo $this->Html->link('Holidays',array('controller'=>'Holidays','action'=>'index'))?>
			</div>

			<br>
			<div class="btn btn-primary">
				<?php echo $this->Html->image('application-search-result.png');?>
				<?php echo $this->Html->link('Groups',array('controller' => 'Groups', 'action' => 'index'))?>
			</div>

			<br>
			<div class="btn btn-primary">
				<?php echo $this->Html->image('users.png');?>
				<?php echo $this->Html->link('Users', array('controller'=>'Users', 'action'=>'index'))?>
			</div>
      <div class="btn btn-primary">
        <?php echo $this->Html->image('calendar.png');?>
        <?php echo $this->Html->link('Cutoffs', array('controller'=>'Cutoffs', 'action'=>'view'))?>
      </div>

            <br>
      		<br>
			<div class="btn btn-primary">
				<?php echo $this->Html->image('address-book--plus.png');?>
				<?php echo $this->Html->link('Update Logsheet',array('controller'=>'Employees','action'=>'upload'))?>
			</div>

			<!--br>
				<div class="btn btn-primary">
				<?php# echo $this->Html->image('ui-search-field.png');?>
				<?php# echo $this->Html->link('History',array('controller' => 'Histories','action' => 'searchall'))?>
			</div-->

			<!--br>
			<div class="btn btn-primary">
				<?php #echo $this->Html->image('calendar--plus.png');?>
				<?php #echo $this->Html->link('Add Shift',array('controller' => 'Shifts', 'action' => 'add'))?>
			</div-->
		
      <div class="btn btn-primary">
      <?php echo $this->Html->image('user--plus.png');?>
      <?php echo $this->Html->link('Add Employee',array('controller' => 'Employees','action' => 'add_employee'))?>
      </div>

			<br>
			<div class="btn btn-primary">
				<?php echo $this->Html->image('clipboard-search-result.png');?>
				<?php echo $this->Html->link('Add Holiday', array('controller'=>'Holidays', 'action'=>'add'))?>
			</div>

			<br>
			<div class="btn btn-primary">
				<?php echo $this->Html->image('address-book--plus.png');?>
				<?php echo $this->Html->link('Add Group',array('controller' => 'Groups', 'action' => 'add'))?>
			</div>

			<br>
			<div class="btn btn-primary">
				<?php echo $this->Html->image('address-book.png');?>
				<?php echo $this->Html->link('Add Loan', array('controller'=>'Loans', 'action'=>'emp_loan'))?>
			</div>

			<br>
			<div class="btn btn-primary">
				<?php echo $this->Html->image('user--plus.png');?>
				<?php echo $this->Html->link('Add User', array('controller'=>'Users', 'action'=>'add'))?>
			</div>

      <div class="btn btn-primary">
        <?php echo $this->Html->image('calendar-search-result.png');?>
        <?php echo $this->Html->link('Payslip',array('controller' => 'Totals', 'action' => 'gotopayslip'))?>
      </div>

		</div>
</td><td>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
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
