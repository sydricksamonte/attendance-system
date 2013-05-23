<?php

echo '<h1>'.$empname['Employee']['last_name'].', '.$empname['Employee']['first_name'].'</h1>';

	foreach ($emploans as $loan):

	$loanType= $loan['Loan']['loan_type'];
	if($loanType==0){
		echo '<br>SSS <br> Amount:'.$loan['Loan']['amount'].
					'<br>Start Date: '.$loan['Loan']['start_date'].
					'<br>End Date: '.$loan['Loan']['end_date'];
	}else if($loanType==1){
    echo '<br>HMDF <br> Amount: '.$loan['Loan']['amount'].
          '<br>Start Date: '.$loan['Loan']['start_date'].
          '<br>End Date: '.$loan['Loan']['end_date'];
  }
echo '<br>'.$this->Html->link('Edit',array('controller'=>'Loans','action' => 'edit_emp_loan_loan', $empname['Employee']['id'],$loan['Loan']['id']));
	endforeach;
?>
