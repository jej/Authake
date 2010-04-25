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


class Group extends AuthakeAppModel {
  var $name = 'Group';
  var $useTable = "authake_groups";
  var $hasMany = array(
        'Rule' => array(
          'className' => 'Authake.Rule',
          'exclusive' => false,
          'dependent' => false,
          'foreignKey' => 'group_id',
          'order' => 'Rule.order ASC'
        )
      );  

  var $hasAndBelongsToMany = array(
        'User' => array(
          'className' => 'Authake.User',
          'joinTable' => 'authake_groups_users',
          'foreignKey' => 'group_id',
          'associationForeignKey'=> 'user_id',
          'order' => 'id',
          'displayField' => 'login'
        )
      );


/*//    var $hasOne = array(
            'Rule' => array('className' => 'Rule',
                                'foreignKey' => 'group_id',
                                'dependent' => false,
                                'conditions' => '',
                                'fields' => '',
                                'order' => ''
            )
    );

    var $hasMany = array(
            'Rule' => array('className' => 'Rule',
                                'foreignKey' => 'group_id',
                                'dependent' => false,
                                'conditions' => '',
                                'fields' => '',
                                'order' => '',
                                'limit' => '',
                                'offset' => '',
                                'exclusive' => '',
                                'finderQuery' => '',
                                'counterQuery' => ''
            )
    );

    var $hasAndBelongsToMany = array(
            'User' => array('className' => 'User',
                        'joinTable' => 'groups_users',
                        'foreignKey' => 'group_id',
                        'associationForeignKey' => 'user_id',
                        'unique' => false,
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

*/

}
?>