<?php

class Task
{
	private $db = null;

	function __construct($db)
	{
		$this->db = $db;
	}

	/**
	* Добавление задания
	* @param $params array
	* @return mixed
	*/

	function add($params)
	{
		$stmt = $this->db ->prepare("INSERT INTO task (description, user_id, assigned_user_id) VALUES (?, ?, ?)");
		$stmt->bindParam(1, $params['description'], PDO::PARAM_STR);
		$stmt->bindParam(2, $params['user_id'], PDO::PARAM_STR);
		$stmt->bindParam(3, $params['assigned_user_id'], PDO::PARAM_STR);
		return $stmt->execute();
		
	}

	/**
	 * Удаление задания
	* @param $id int
	* @return mixed
	*/
	function delete($id)
	{
		$sth = $this->db->prepare('DELETE FROM `task` WHERE id=:id');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		return $sth->execute();
	}

	/**
	* @param $id int
	* @param $params array
	* @return mixed
	*/
	function update($id, $params)
	{
		if (count($params) == 0) {
			return false;
		}
		$update = [];
		foreach ($params as $param => $value) {
			$update[] = $param.'`=:'.$param;
		}
		$sth = $this->db->prepare('UPDATE `book` SET `'.implode(', `', $update).' WHERE `id`=:id');

		if (isset($params['name'])) {
			$sth->bindValue(':name', $params['name'], PDO::PARAM_INT);
		}
		if (isset($params['author'])) {
			$sth->bindValue(':author', $params['author'], PDO::PARAM_STR);
		}
		if (isset($params['year'])) {
			$sth->bindValue(':year', $params['year'], PDO::PARAM_INT);
		}
		if (isset($params['genre'])) {
			$sth->bindValue(':genre', $params['genre'], PDO::PARAM_STR);
		}
		$sth->bindValue(':id', $id, PDO::PARAM_INT);

		return $sth->execute();
	}

	/**
	* Получение всех получение всех заданий
	* @return array
	*/
	public function findAll($id_in_session, $sortBy = '')
	{
		$sth = $this->db->prepare("SELECT ts.id AS task_id, 
							ts.description, 
							ts.user_id,
							ts.assigned_user_id,
							ts.date_added,
							ts.is_done,
							us.id,
							us.login
	FROM task AS ts JOIN user AS us ON us.id = ts.assigned_user_id WHERE ts.user_id = {$id_in_session}.{$sortBy}");
		if ($sth->execute()) {
			return $sth->fetchAll();
		}
		return false;
	}
	// выборка всех пользователей
	public function findAllUsers(){
		
		
			$stmt = $this->db->prepare("SELECT * FROM user ORDER BY login");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	}
	
	public function findAllAssigned($id_in_session)
	{
		$sth = $this->db->prepare("SELECT ts.id AS task_id, 
							ts.description, 
							ts.date_added,
							ts.is_done,
							us.login
		FROM task AS ts JOIN user AS us ON us.id = ts.user_id WHERE ts.assigned_user_id = {$id_in_session}");
		if ($sth->execute()) {
			return $sth->fetchAll();
		}
		return false;
	}
	// Авторизация
	public function findAuth($log, $pass)
	{
		$stmt = $this->db->prepare("SELECT * FROM user WHERE login = :login AND password = :password");
		
		$stmt->execute(['login'=>$log, 'password'=>md5($pass)]);
		
		return $stmt->fetch(PDO::FETCH_ASSOC); 
		
		}
	// Проверка на существование зарегистрированного логина	
	public function checkLogin($login){
		
		$stmt = $this->db->prepare("SELECT * FROM user WHERE login = '{$login}'");
		$stmt->execute();
		if($stmt->rowCount() > 0){
			return true;
		}
			return false;
	}
	// Регистрация
	public function regist($login, $password){
		
	$stmt = $this->db->prepare("INSERT INTO user (login, password) VALUES (:login, :password)");
	$stmt->execute(['login' =>$login, 'password' =>md5($password)]);
	if($stmt->rowCount() === 1){
		return true;
	}
	return false;
	}

	/**
	 * Получение одного задания
	 * @param $id int
	 * @return array
	 */
	public function find($id)
	{
		$sth = $this->db->prepare("SELECT id, description, is_done FROM task WHERE id = :id");
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		return $sth->fetch(PDO::FETCH_ASSOC);
		
	}
	// Выполнение задания
	public function updateStatus($id){
		
		$stmt = $this->db->prepare("UPDATE task SET is_done = 1 WHERE id = :id");
		return $stmt->execute(['id' => $id ]);
	}
	// Редактирование задания
	public function updateTask($id, $params){
		
		$stmt = $this->db ->prepare("UPDATE task SET description = ?, is_done = ? WHERE id = ?");
		$stmt->bindParam(1, $params['description'], PDO::PARAM_STR);
		$stmt->bindParam(2, $$params['is_done'], PDO::PARAM_STR);
		$stmt->bindParam(3, $id, PDO::PARAM_STR);
		$stmt->execute();
	}
	// Закрепление задания за другим пользователем
	
	public function taskAssign($id, $params){
		
	 
		$stmt = $this->db->prepare("UPDATE task SET assigned_user_id = :user_id WHERE id = :task_id AND user_id = :id_in_session");
		$stmt->execute(['user_id' => $params['assigned_user_id'], 'task_id' => $params['task_id'], 'id_in_session'=> $id]);
		
		
	}
}

