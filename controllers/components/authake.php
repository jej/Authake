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


class AuthakeComponent extends Object {
  
    var $components = array('Session');
    
    var $_forward = null;
    var $_flashmessage = '';
    
    function startup(&$controller) {
    }

    function beforeFilter(&$controller) { //pr($this);

        // get action path
        $path = $controller->params['url']['url'];
        if ($path != '/') {
            $path = '/'.$path;
        }
        
        $loginAction = Configure::read('Authake.loginAction');
        if ($path != $loginAction) {
            $this->setPreviousUrl(null);
        }
        
        // check session timeout
        $tm = Configure::read('Authake.sessionTimeout');
        if ($tm && $this->isLogged()) {
            $ts = $this->Session->read('Authake.timestamp');
            if ((time()-$ts) > $tm) {
                $this->setPreviousUrl($path);
                $this->logout();
                $this->Session->setFlash(__('Your session expired', true), 'warning');
                $controller->redirect($loginAction);                
            }            
            $this->setTimestamp();
        }
        
        if (!$this->isAllowed($path)) { // check for permissions
            if ($this->isLogged()) { // if denied & logged, write a message
                if ($this->_flashmessage) { // message from the rule (accept path in %s)
                    $this->Session->setFlash(sprintf(__($this->_flashmessage, true), $path), 'error');    // Set Flash message
                }

                $fw = $this->_forward ? $this->_forward : Configure::read('Authake.defaultDeniedAction');
                $controller->redirect($fw);
            } else { // if denied & not loggued, propose to log in
                $this->setPreviousUrl($path);
                $this->Session->setFlash(__('You have to log in to access ', true).$path, 'warning');
                $controller->redirect($loginAction);
            }
            $this->_flashmessage = '';
        }
    }

    
    function setPreviousUrl($url) {
        $this->Session->write('Authake.previousUrl', $url);
    }

    function getPreviousUrl() {
        return $this->Session->read('Authake.previousUrl');
    }

    function isLogged() {
        return ($this->getUserId() !== null);
    }

    function getLogin() {
        return $this->Session->read('Authake.login');
    }

    function getUserId() {
        return $this->Session->read('Authake.id');
    }

    function getGroupIds() {
        $gid = $this->Session->read('Authake.group_ids');
        return (empty($gid) ? array(0) : $gid);
    }

    function getGroupNames() {
        $gn = $this->Session->read('Authake.group_names');
        return (is_array($gn) ? $gn : array(__('Guest', true)));
    }

    function isMemberOf($gid) {
        return in_array($gid, $this->getGroupIds());
    }

    function setTimestamp() {
            $ts = $this->Session->write('Authake.timestamp', time());
        }

    function login($user) {
            $this->Session->write('Authake', $user);
            $this->setTimestamp();
        }

    function logout() {
            $this->Session->del('Authake');
        }

    function getRules($group_ids = null) {
        $force_reload = (time() - $this->Session->read('Authake.cacheRulesTime')) > Configure::read('Authake.rulesCacheTimeout');

        if($force_reload
        || is_array($group_ids)
        || ($cacheRules = $this->Session->read('Authake.cacheRules')) === null
            ) {
            App::import("Model", "Authake.Rule");
            $rule = new Rule;
            $cacheRules = $rule->getRules(is_array($group_ids) ? $group_ids : $this->getGroupIds(), true); // use groups provided or take groups of the users

            if ($group_ids === null) { // cache only if groups of user used
                $this->Session->write('Authake.cacheRules', $cacheRules);
                $this->Session->write('Authake.cacheRulesTime', time());
            }
        }

        return $cacheRules;
    }

    // Function to check the access for the controller / action
    function isAllowed($url = "", $group_ids = null) { // $checkStr: "/name/action/" $group_ids: check again thess groups
        $allow = false;
        $rules = $this->getRules($group_ids);
        foreach( $rules as $data ) {
            if(preg_match("/^({$data['Rule']['action']})$/i", $url, $matches)) {
                $allow = $data['Rule']['permission']; //echo $allow.'=>'.$url.' ** '.$data['Rule']['action'];
                if ($allow == 'Deny') {
                    $allow = false;
                    $this->_forward = $data['Rule']['forward'];
                    $this->_flashmessage = $data['Rule']['message'];
                } else {
                    $allow = true;
                }
            }
        }
        return $allow;
    }


    function getActionsPermissions($group_ids) {
        //pr(getcwd());

        $controllers = $this->_getControllers();
        $rules = $this->getRules($group_ids);
        $actionsList = array();

        foreach($controllers as $controller => $actions) {
            foreach($actions as $k => $action) {
                $con = strtolower($controller);
                $permission = $this->_areGroupsAllowed("/{$con}/{$action}/", $rules);
                $actionsList[$controller][] = array('controller' => $con, 'action' => $action, 'permission' => $permission);
            }
        }

        return $actionsList;

    }


    function _getControllers($lowercase = false) {
        $controllerList = array();
        $controllers = Configure::listObjects('controller');
        App::import('Controller', $controllers);
        
/*  To improve...
        $controllers[]='User';
        $controllers[]='Users';
        $controllers[]='Groups';
        $controllers[]='Rules';
        $controllers[]='Denied';
        App::import('Controller', array('Authake.User', 'Authake.Users', 'Authake.Groups', 'Authake.Rules', 'Authake.Denied'));
*/

        foreach($controllers as $controller) {
            if ($controller != "App") {
                $className = $controller . 'Controller';
                $actions = get_class_methods($className);
                foreach($actions as $k => $v)
                    if ($v{0} == '_') unset($actions[$k]);

                $parentActions = get_class_methods('AppController');
                if ($lowercase) $controller = strtolower($controller);
                $controllersList[$controller] = array_diff($actions, $parentActions);
            }
        }
        
        return $controllersList;
    }



    // Function to check the access for the controller / action
    function _areGroupsAllowed($url = "", $rules) { // $checkStr: "/name/action/" $group_ids: check again thess groups
        $allow = false;
        foreach( $rules as $data ) {
        if(preg_match("/{$data['Rule']['action']}/i", $url, $matches)) {
            $allow = $data['Rule']['permission'];
            if ($allow == 'Deny')
                $allow = false;
            else
                $allow = true;
            }
        }
        return $allow;
    }
    
   
}
    
?>