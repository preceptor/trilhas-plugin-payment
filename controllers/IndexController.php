<?php
/**
 * Trilhas - Learning Management System
 * Copyright (C) 2005-2010  Preceptor Educação a Distância Ltda. <http://www.preceptoead.com.br>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @category   SelectionProcess
 * @package    SelectionProcess_Controller
 * @copyright  Copyright (C) 2005-2010  Preceptor Educação a Distância Ltda. <http://www.preceptoead.com.br>
 * @license    http://www.gnu.org/licenses/  GNU GPL
 */
class Payment_IndexController extends Tri_Controller_Action
{
	/**
	 * Init
 	 *
	 * Call parent init and set title box.
	 *
	 * @return void
	 */
    public function init()
    {
        parent::init();
        $this->_helper->layout->setLayout('admin');
        $this->view->title = "Payment";
    }
	
	/**
	 * Action index.
	 *
	 * @return void
	 */
    public function indexAction()
    {
        
    }

	public function signAction()
	{
        $id  = Zend_Filter::filterStatic($this->_getParam('page'), 'int');

        if ($id) {
            $data['user_id']      = Zend_Auth::getInstance()->getIdentity()->id;
            $data['classroom_id'] = $id;
            $data['status']       = 'waiting';

            $table = new Zend_Db_Table('classroom_user');
            $table->createRow($data)->save();

            $this->view->id = $id;
        }
	}
	
	public function matriculateAction()
	{
		$post = $this->_getAllParams();
        
		if (count($post['interested'])) {
			$table = new Tri_Db_Table('selection_process');
            $tableClassRoom = new Tri_Db_Table('classroom_user');
            
			foreach ($post['interested'] as $interested) {
				$i = explode('-', $interested);

                $row = $tableClassRoom->fetchRow(array('classroom_id = ?' =>  $i[0],
                                                       'user_id' =>  $i[1]));
                $row->status = Application_Model_Classroom::REGISTERED;
                $row->save();

                $this->_helper->_flashMessenger->addMessage('Success');
                $this->_redirect('payment');
			}
		} 
		$this->_helper->_flashMessenger->addMessage('Error');
        $this->_redirect('payment');
	}
	
	/**
	 * Arranges data to select tag
	 *
	 * @param array $datas	
	 * @return array
	 */
	public function toSelect($datas)
	{
		$result = array('' => $this->view->translate('[select]'));
		foreach ($datas as $data) {
			$result[$data['id']] = $data['name'];
		}
		return $result;
	}
}