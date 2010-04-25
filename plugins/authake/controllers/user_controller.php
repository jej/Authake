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


class UserController extends AuthakeAppController {
  var $name     = 'User';
  var $uses     = array('Authake.User', 'Authake.Rule');
  var $components = array('Email');
  var $helpers = array('Time', 'Htmlbis');
  
  //var $scaffold;
    
    
    function denied()
    {
    // display this view (/app/views/users/denied.ctp) when the user is denied
    }
    
    
    function index() {
        if (!$this->Authake->getUserId()) {
            $this->Session->setFlash(__('Invalid User', true), 'error');
            $this->redirect('/');
        }

        $user = $this->User->read(null, $this->Authake->getUserId());

        if (!empty($this->data)) {

            if ($this->data['User']['password1'] != '') { // password changed
                if ($this->data['User']['password1'] != $this->data['User']['password2']) {
                    $this->Session->setFlash(__('The two passwords do not match!', true), 'error');
                } else {
                    $user['User']['password'] = md5($this->data['User']['password1']);
                    $this->Session->setFlash(__('Password changed!', true), 'success');
                }
            }

            if ($this->data['User']['email'] != $user['User']['email']) {
                $user['User']['emailcheckcode'] = md5(time());
                $user['User']['email'] = $this->data['User']['email'];
                $this->Session->setFlash(__('Email changed but need to be confirmed!', true), 'success');
            }

            //pr($user);
            $this->User->save($user['User']);
            $this->redirect('/');
        }

        //$this->data = null;
        $this->set(compact('user'));
    }
    
    function register() {
        if (!empty($this->data)) {
            
            $this->User->recursive = 0;
            $exist = $this->User->findByLogin($this->data['User']['login']);
            if (!empty($exist)) {
                $this->Session->setFlash(__('This login is already used!', true), 'error');
                return;
            }
            
            $exist = $this->User->findByEmail($this->data['User']['email']);
            if (!empty($exist)) {
                $this->Session->setFlash(__('This email is already registred!', true), 'error');
                return;
            }

            $pwd = $this->__makePassword($this->data['User']['password1'], $this->data['User']['password2']);
            if (!$pwd) return;  // password is invalid...
            $this->data['User']['password'] = $pwd;
            
            $this->data['User']['emailcheckcode'] = md5(time()*rand());
            $this->User->create();
            if ($this->User->save($this->data)) {
            
                // send a mail to finish the registration
                $this->Email->to = $this->data['User']['email'];
                $this->Email->subject = 'Your registration';
                $this->Email->replyTo = 'noreply@example.com';
                $this->Email->from = 'Cake Test Account <noreply@example.com>';
                $this->Email->sendAs = 'text';
                $this->Email->charset = 'utf-8';
                $body = "Please goto ".Configure::read('Authake.baseUrl')."/authake/user/confirmregister/email:{$this->data['User']['email']}/code:{$this->data['User']['emailcheckcode']}";
                
                if ($this->Email->send($body)) {
                    $this->Session->setFlash(__('You will receive an email with a code in order to finish the registration...', true), 'warning');
                } else {
                    $this->Session->setFlash(__('Failed to send the confirmation email. Please contact the administrator at xxx@xxx', true), 'error');
                }
                $this->redirect('/');
            } else {
                $this->Session->setFlash(__('The registration failed!', true), 'error');
            }
        }
    }

    function confirmregister() {
        if (!empty($this->params['named']))
            $this->data['User'] = $this->params['named'];

        if (!empty($this->data)) {
            $this->User->recursive = 0;
            $user = $this->User->find("email != '' AND emailcheckcode != '' AND email='".addslashes($this->data['User']['email'])."' AND emailcheckcode='".addslashes($this->data['User']['code'])."'");
            
            if (empty($user) || $user['User']['emailcheckcode'] != $this->data['User']['code']) {
                $this->Session->setFlash(__('The email and/or registration code is invalid...', true), 'error');
            } else {
                $user['User']['emailcheckcode'] = '';
                
                $this->User->save($user, false);  // pr($this->User->validationErrors);
                $this->Session->setFlash(__('Your registration is confirmed!', true), 'success');
                $this->redirect(array('action'=>'login'));
            }
        }
        
//        $this->set('infos', $this->params['named']);
    }
    
    function login()
    {
        if ($this->Authake->isLogged()) {
            $this->Session->setFlash(__('You are already logged in!', true), 'info');
            $this->redirect('/');
        }
        
        if (!empty($this->data) ) {
            $login  = $this->data['User']['login'];
            $password = $this->data['User']['password'];
            
            $user = $this->User->findByLogin($login);
            
            if (empty($user)) {
                $this->Session->setFlash(__('Invalid login or password!', true), 'error');
                return;
            }
            
            // check for locked account
            if ($user['User']['id'] != 1 and $user['User']['disable']) {
                $this->Session->setFlash(__('Your account is disabled!', true), 'error');
                $this->redirect('/');
            }

            // check for expired account
            $exp = $user['User']['expire_account'];
            if ($user['User']['id'] != 1 and $exp != '0000-00-00' and strtotime($exp) < time()) {
                $this->Session->setFlash(__('Your account has expired!', true), 'error');
                $this->redirect('/');
            }
            
            // check for not confirmed email
            if ($user['User']['emailcheckcode'] != '') {
                $this->Session->setFlash(__('You registration has not been confirmed!', true), 'warning');
                $this->redirect(array('action'=>'confirmregister'));
            }
            
            $userdata = $this->User->getLoginData($login, $password);
            
            if (empty($userdata)) {
                $this->Session->setFlash(__('Invalid login or password!', true), 'error');
                return;
            } else {
                $next = $this->Authake->getPreviousUrl();
                $this->Authake->login($userdata['User']);
                $this->Session->setFlash(__('You are logged in as ', true).$userdata['User']['login'], 'success');
                $this->redirect($next !== null ? $next : '/');
            }
        }
    }
    

    function mypassword() {
        $this->User->recursive = 0;
        
        if (!empty($this->data)) {
            $loginoremail = $this->data['User']['loginoremail'];
            if ($loginoremail) {
                $user = $this->User->findByLogin($loginoremail);
            }
            if (empty($user)) {
                $user = $this->User->findByEmail($loginoremail);
            }
            
            if (!empty($user)) { // ok, login or email is ok
                $md5 = $user['User']['passwordchangecode'] = md5(time()*rand());
                if ($this->User->save($user)) {
                
                    // send a mail with code to change the pw
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = 'Your password';
                    $this->Email->replyTo = 'noreply@example.com';
                    $this->Email->from = 'Cake Test Account <noreply@example.com>';
                    $this->Email->sendAs = 'text';
                    $this->Email->charset = 'utf-8';
                    echo $body = "Please goto ".Configure::read('Authake.baseUrl')."/authake/user/changemypassword/email:{$user['User']['email']}/code:{$md5}";
                     
                    if ($this->Email->send($body) ) {
                        $this->Session->setFlash(__('If data provided is correct, you should receive a mail with instructions to change your password...', true), 'warning');
                    } else {
                        $this->Session->setFlash(__('Failed to send a email to change your password. Please contact the administrator at xxx@xxx', true), 'error');
                    }
                } else {
                    $this->Session->setFlash(__('Failed to change your password. Please contact the administrator at xxx@xxx', true), 'error');
                }
            } else {
                $this->Session->setFlash(__('If data provided is correct, you should receive a mail with instructions to change your password...', true), 'warning');
            }
            $this->redirect('/');
        }
    }

    function changemypassword() {
        if (!empty($this->data)) {
            $this->User->recursive = 0;
            
            $pwd = $this->__makePassword($this->data['User']['password1'], $this->data['User']['password2']);
            if ($pwd) {
                $user = $this->User->find("email = '".addslashes($this->data['User']['email'])."' AND passwordchangecode='".addslashes($this->data['User']['code'])."'");
                if (empty($user)) { // bad code or email
                    $this->Session->setFlash(__('Bad identification data!', true), 'error');
                } else {
                    $user['User']['password'] = $pwd;
                    $user['User']['passwordchangecode'] = '';
                    $this->User->save($user);
                    
                    $this->Session->setFlash(__('Your password is changed. Log in now!', true), 'success');
                    $this->redirect(array('action'=>'login'));
                }
            }
        }
        
        if (!empty($this->params['named']))
            $this->data['User'] = $this->params['named'];
    }

    function logout()
    {
        if ($this->Authake->isLogged()) {
            $this->Authake->logout();
            $this->Session->setFlash(__('You are logged out!', true), 'info');
        }
        $this->redirect('/');
    }

}

?>