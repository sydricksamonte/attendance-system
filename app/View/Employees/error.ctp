<div class="span14">
<div align="right">
<a href="javascript:window.history.back()"><--Back</a>
</div>
<?php echo $this->Form->create('Employee', array( 'onsubmit' => 'return confirm(" Are you sure you want to continue?");')); ?>
  <h2>Logs</h2>
  <div><table class="table-bordered"><thead><tr><th>
<?php if ($schedFound != null) { echo 'Schedule(s) tracked on this date: '; ?> </th></tr></thead><br><tbody><tr><td>
<?php $i = 0; foreach ($schedFound as $u): 
			 ?><?php {	echo $u['CHECKTIME'] . ' - ' . $u['CHECKTYPE']; $i++; ?><br><?php }
		endforeach;}
      else { echo 'No schedule found on this date on the database'; }
 ?>
</td></tr></tbody></table></div></div><br>


  <table class="table table-bordered">
    <tr>
      <td>Employee ID:</td>
      <td><?php echo $employee['Employee']['id'];?></td>
    </tr>
    <tr>
      <td>First Name:</td>
      <td><?php echo $employee['Employee']['first_name'] ;?></td>
    </tr>
    <tr>
      <td>Last Name:</td>
 <td><?php echo $employee['Employee']['last_name'] ;?></td>
    </tr>
      <tr>
      <td>Date:</td>
      <td><?php  echo $curr_date_ymd;?> </td>
    </tr>
      <tr>
      <td>Log In:</td>
      <td style='color:red'><?php if ($checkIn == null){echo "ERROR. PLEASE UPDATE LOGIN TIME";}  echo $this->Form->input('Checkinout.CHECKTIME',array('label' => false, 'type' => 'datetime','selected' => $curr_date_ymd.' '.date('H:i:s',strtotime($checkIn)) ));?>
 </td>
    </tr>
   <tr>
      <td>Log Out:</td>
      <td style='color:red'><?php if ($checkOut == null){echo "ERROR. PLEASE UPDATE LOGOUT TIME";}  echo $this->Form->input('Checkinout.CHECKTIME2',array('label' => false, 'type' => 'datetime','selected' => $curr_date_ymd.' '.date('H:i:s',strtotime($checkOut))));?>
     </td>
  </tr>
<!--hidden fields-->
<?php
echo $this->Form->input('Checkinout.USERID', array('value' => $employee['Employee']['userinfo_id'], 'type' => 'hidden'));
echo $this->Form->input('Checkinout.CHECKTYPE', array('value' => 'I', 'type' => 'hidden'));

?>
  </tr>
</table>
    <?php echo $this->Form->end('Add Log' );?>
</div>

