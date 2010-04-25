<?php
/*
    This file is part of Authake.

    Author: Jérôme Combaz (jakecake/velay.greta.fr)
    Contributors:

    Authake is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Authake is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/


class User extends AuthakeAppModel {
    var $name = 'User';
    var $useTable = "authake_users";
    var $hasAndBelongsToMany = array(
        'Group' => array('className' => 'Authake.Group',
                    'joinTable' => 'authake_groups_users',
                    'foreignKey' => 'user_id',
                    'associationForeignKey' => 'group_id',
//                     'unique' => false,
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                    'limit' => '',
                    'offset' => '',
                    'finderQuery' => '',
                    'deleteQuery' => '',
                    'insertQuery' => ''
        )
    );
    
    
    var $validate = array(
        'login' => array(
            'alphanumeric' => array(
                'rule' => 'alphaNumeric',  
                'message' => 'Only alphabets and numbers allowed'
            ),
            'minlength' => array(
                'rule' => array('minLength', '3'),
                'message' => 'Minimum length of 3 characters'
            ),
            'maxlength' => array(
                'rule' => array('maxLength', '32'),  
                'message' => 'Maximum length of 32 characters'
            )
        )
        
    );

    
    
    function getLoginData($login='', $password='')
    {
        $data = $this->find("login = '".addslashes($login)."' AND password = '".md5($password)."'", array(), null, null, null, 1);

        if (!empty($data)) {
/*            $data['User']['group_ids'][] = 0; // everybody is at least a guest
            $data['User']['group_names'][] = __('Guest', true);
*/
            if (!empty($data['Group'])) {
                foreach($data['Group'] as $group) {
                    $data['User']['group_ids'][] = $group['id'];
                    $data['User']['group_names'][] = $group['name'];
                }
            }
            
            unset($data['User']['password']); // not useful to save the encrypted password in session
            return $data;
        } else
            return false;
        
    }


    function getGroups($id) {
        $groups = $this->findById($id);
        $list = array(0);
        foreach($groups['Group'] as $group)
            $list[] = $group['id'];
        return $list;
    }

}


?>