<?php

require_once 'CoreController.php';

class TaskController extends CoreController
{
	
	/**
	 * Добавление задания
	 * @param $params array
	 * @return mixed
	 */
	function postAdd($params, $post)
	{
		$id_in_session = self::checkLogged()['id'];
		
		if (isset($post['description'])) {
			$taskAdd = $this->model->add([
				'description' => $post['description'],
				'user_id' => $id_in_session,
				'assigned_user_id' => $id_in_session
				
			]);
			if ($taskAdd) {
				header('Location: /lesson5.2/');
			}
		}
	}

	/**
	 * Удаление задания
	 * @param $id
	 */
	public function getDelete($params)
	{
		if (isset($params['id']) && is_numeric($params['id'])) {
			$isDeleted = $this->model->delete($params['id']);
			if ($isDeleted) {
				header('Location: /lesson5.2/');
			}
		}
	}
	/**
	 * Выполнение задания
	 * @param $id
	 */
	public function getDone($params)
	{
		if (isset($params['id']) && is_numeric($params['id'])) {
			$isDone = $this->model->updateStatus($params['id']);
			if ($isDone) {
				header('Location: /lesson5.2/');
			}
		}
	}
	
	

	/**
	 * Форма редактирования задания
	 * @param $id
	 */
	public function getUpdate($params){
		$login_in_session = self::checkLogged()['login'];
		if (isset($params['id']) && is_numeric($params['id'])) {
				
				$taskToEdit = $this->model->find($params['id']);
				echo $this->render('view2.html',['taskToEdit'=> $taskToEdit]);
			}
		
	}
	


	/**
	 * Изменение задания
	 * @param $id
	 */

	public function postUpdate($params, $post)
	{
		if (isset($params['id']) && is_numeric($params['id'])) {
			$updateParam = [];
			if (isset($post['description'])) {
				$updateParam['description'] = $post['description'];
			}
			if (isset($post['is_done'])) {
				$updateParam['is_done'] = $post['is_done'];
			}
			
			$this->model->updateTask($params['id'], $updateParam);
			header('Location: /lesson5.2/');
			
		}
	}

	/**
	 * Вывод всех заданий
	 * @return array
	 */
	public function getList()
	{
		
		$id_in_session = self::checkLogged()['id'];
		$login_in_session = self::checkLogged()['login'];
	// Вызываем функцию для сортировки, по умолчанию она возвращает пустую строку
		$sortBy = $this->getSort();
		$tasks = $this->model->findAll($id_in_session, $sortBy);
		$users = $this->model->findAllUsers();
		$tasksAssigned = $this->model->findAllAssigned($id_in_session);
		echo $this->render('view1.html', ['tasks' => $tasks, 'tasksAssigned' => $tasksAssigned , 'users' =>$users,	
		'login_in_session' => $login_in_session]);
		
	}
	// Сортировка по заданному полю
	
	public function getSort(){
		
		if(isset($_GET['sort_by']) AND ($_GET['sort_by'] === 'description' 
										OR $_GET['sort_by'] === 'is_done' 
										OR $_GET['sort_by'] === 'date_added')){
			$sortBy = $_GET['sort_by'];
			$sortBy = " ORDER BY {$sortBy}";
			return $sortBy;
			}
			return '';
	}
	
	public function postAssign($params, $post){
		$assignData = [];
		$id_in_session = self::checkLogged()['id'];
		if(isset($post['assigned_user_id'])){
			$assignData['assigned_user_id'] = $post['assigned_user_id'];
		}
		if(isset($params['task_id'])){
			$assignData['task_id'] = $params['task_id'];
		}
		
		$this->model->taskAssign($id_in_session, $assignData);
		header('Location: /lesson5.2/');
		
	}
	
	
	
	public static function checkLogged()
    {
        // Если сессия есть, вернем идентификатор пользователя
        if (isset($_SESSION['users'])) {
            return $_SESSION['users'];
        }

        header("Location: ?/user/auth");
    }
	
	

}

