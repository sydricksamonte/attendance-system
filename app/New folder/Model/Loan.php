<?php
class Loan extends AppModel{
				public $validate = array(
												'amount' => array(
																'alphaNumeric' => array(
																				'rule'     => '/^[^%#\/*@!,qwertyuiopasdfghjklzxcvbnm<>]+$/',
																																'message'  => 'Invalid amount'
																																)));
																																}
?>
