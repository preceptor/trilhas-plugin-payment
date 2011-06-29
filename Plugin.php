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
 * @category   Payment
 * @package    Payment_Plugin
 * @copyright  Copyright (C) 2005-2010  Preceptor Educação a Distância Ltda. <http://www.preceptoead.com.br>
 * @license    http://www.gnu.org/licenses/  GNU GPL
 */
class Payment_Plugin extends Tri_Plugin_Abstract
{
    protected $_name = "payment";
    
    protected function _createDb()
    {
        $sql = "";
        $this->_getDb()->query($sql);
    }

    public function install()
    {
        $this->_createDb();
    }

    public function activate()
    {
        $this->_addAdminMenuItem('selection-process', 'payment','Payment/index/index');
        
        $this->_addAclItem('payment/index/index', 'teacher, coordinator, institution');
        $this->_addAclItem('payment/index/sign', 'identified');
        $this->_addAclItem('payment/index/matriculate', 'teacher, coordinator, institution');
        $this->_addAclItem('payment/index/reject', 'teacher, coordinator, institution');
    }

    public function desactivate()
    {
        $this->_removeAdminMenuItem('selection-process', 'payment');
        
        $this->_removeAclItem('payment/index/index');
        $this->_removeAclItem('payment/index/sign');
        $this->_removeAclItem('payment/index/matriculate');
        $this->_removeAclItem('payment/index/reject');
        $this->_removeAclItem('payment/index/view');
    }
}