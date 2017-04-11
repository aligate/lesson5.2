<?php

require_once 'CoreController.php';

class UserController extends CoreController{
	
	
	
	// Регистрация
	// Выводим форму
	
	public function getRegist()
	{
	
	echo $this->render('regist.html');
	}
	
	// Регистрируем
	
	public function postRegist($params, $post){
	$login = '';	
	$message = [];
	if(isset($_POST['regist']))
	{

	$login = trim(addslashes($_POST['login']));
	$password = trim(addslashes($_POST['password']));

	if($login==='')
	{
		$message['error'][] = "Введите новый логин";
	}
	if($password==='') 
	{
		$message['error'][] = "Придумайте ваш пароль";
	}

	
	if($this->model->checkLogin($login))
	{
	$message['error'][] = "Пользователь с данным логином уже существует";
	}
	if(empty($message['error']))
	{
	
	if($this->model->regist($login, $password))
		{
		
		$message['result'][] = "Вы успешно зарегистрированы, вы можете авторизоваться";
		}
	}
	}
	echo $this->render('regist.html', ['message'=>$message, 'login' => $login]);	
}


// Авторизация. Вывод формы
public function getAuth()
{
	
	echo $this->render('login.html');
}
	
	// Вход на сайт авторизованным пользователем
	public function postAuth($params, $post){
		
	$log = '';
	$pass = '';
	$message = [];
		
	if(isset($post['auth']))
{
	$array = [];
	$log = trim(addslashes($post['login']));
	$pass = trim(addslashes($post['password']));

	if($log === '')
	{
		$message[] = "Введите ваш логин";
	}
	if($pass === '') 
	{
		$message[] = "Введите ваш пароль";
	}
	if(!$this->model->findAuth($log, $pass)){
		
		$message[] = "Неверные входные данные";
	}
	else{
		$is_auth = $this->model->findAuth($log, $pass);
		
		$_SESSION['users'] = $is_auth;
	
		header('Location: /lesson5.2/');
		
	}
}
	echo $this->render('login.html', ['message' => $message, 'log' => $log]);
	}
	

	// Выход
	public function getLogout(){
		session_start();
		session_destroy();
		header('Location: ?/user/auth/');
		
	}


}


?>