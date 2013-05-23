<?php
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
				

				public function check($username)
				{
								$exist = $this->find('count', array('conditions' => array('username' => $username)));
								if ($exist == 0)
								{
												return false;
								}
								else
								{
												return true;
                }
				}
				public function checkIfExistEdit($username)
				{
					
								$exist = $this->find('count', array('conditions' => array('username' => $username)));
			echo $exist . "a";					
			if ($exist == 0)
			{
							return false;
			}
			else
			{
							return true;
			}
				}

				public $validate = array(

												'first_name' => array(
																'alphaNumeric' => array(
																				'rule'     => '/^[^%#\/*@!1234567890.]+$/',
																				'required' => true,
																				'message'  => 'Invalid input'
																				),
																'between' => array(
																				'rule'    => array('between', 2, 15),
																				'message' => 'Between 2 to 15 characters'
																				)
																),        
												'last_name' => array(
																'alphaNumeric' => array(
																				'rule'     => '/^[^%#\/*@!1234567890.]+$/',
																				'required' => true,
																				'message'  => 'Invalid input'
																				),
																'between' => array(
																				'rule'    => array('between', 2, 15),
																				'message' => 'Between 2 to 15 characters'
																				)

																),
												'username' => array(
																				'password' => array(
																								'rule'     => 'alphaNumeric',
																								'required' => true,
																								'message'  => 'Alphabets and numbers only'
																								),
																				'between' => array(
																								'rule'    => array('between', 5, 15),
																								'message' => 'Between 5 to 15 characters'
																								)
																				),
												'password' => array(
																				'alphaNumeric' => array(
																								'rule'     => 'alphaNumeric',
																								'required' => true,
																								'message'  => 'Alphabets and numbers only'
																								),
																				'between' => array(
																								'rule'    => array('minLength', 8),
																								'message' => 'Must be 8 or more characters long'
																								)

																				),
												);
				public function beforeSave($options = array()) {
								if (isset($this->data['User']['password'])) {
							    $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
								}
								return true;
				}

}
