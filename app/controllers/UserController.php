<?php
declare(strict_types=1);
use App\Forms\LoginForm;
use App\Forms\RegisterForm;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;


class UserController extends ControllerBase
{

    public function indexAction()
    {
        
    }

    public function loginAction(){
        $this->tag->setTitle('BIMBIM::Login');
        if ($this->isLoggedIn()) {
            return $this->response->redirect('user/profile');
        }
        $this->view->form = new LoginForm();
    }

    public function loginSubmitAction(){

          // check request
          if (!$this->request->isPost()) {
            return $this->response->redirect('user/login');
        }

        # https://docs.phalconphp.com/en/3.3/security#csrf

        //Validate CSRF token
        // if (!$this->security->checkToken()) {
        //     $this->flashSession->error("Invalid Token");
        //     return $this->response->redirect('user/login');
        // }

        //$this->loginForm->bind($_POST, $user);
        // check form validation
        // if (!$this->loginForm->isValid()) {
        //     foreach ($this->loginForm->getMessages() as $message) {
        //         $this->flashSession->error($message);
        //         $this->dispatcher->forward([
        //             'controller' => $this->router->getControllerName(),
        //             'action'     => 'login',
        //         ]);
        //         return;
        //     }
        // }
        
        // login with database
        $id   = $this->request->getPost('id');
        $password = $this->request->getPost('password');

        /**
         * Users::findFirst();
         * $user->findFirst();
         */
        $user = Users::findFirst([ 
            'id = :id:',
            'bind' => [
               'id' => $id,
            ]
        ]);
            
        // Check User Active
        if ($user->active != 1) {
            $this->flashSession->error("User Deactivate");
            return $this->response->redirect('user/login');
        }
        
        # Doc :: https://docs.phalconphp.com/en/3.3/security
        if ($user) {
            $hashedPass = hash('MD5', $user->password);
           
            if ($this->security->checkHash($password, $user->password))
            {
                # https://docs.phalconphp.com/en/3.3/session#start

                // Set a session
                $this->session->set('AUTH_ID', $user->id);
                $this->session->set('AUTH_NAME', $user->name);
                $this->session->set('AUTH_ROLE', $user->role);
                $this->session->set('AUTH_CREATED', $user->created);
                $this->session->set('AUTH_UPDATED', $user->updated);
                $this->session->set('IS_LOGIN', 1);

                //$this->flashSession->success("Login Success");
                return $this->response->redirect('user/profile');
            }
        } else {
            // To protect against timing attacks. Regardless of whether a user
            // exists or not, the script will take roughly the same amount as
            // it will always be computing a hash.
            $this->security->hash(rand());
        }

        // The validation has failed
        $this->flashSession->error("Invalid login");
        return $this->response->redirect('user/login');
    }

    public function registerAction(){
        $this->tag->setTitle('BIMBIM::Register');
        $this->view->form = new RegisterForm();
    }

    public function registerSubmitAction(){
        $form = new RegisterForm(); 
        $user = new Users();
        $request = new Request();
        
        // check request
        if (!$this->request->isPost()) {
            return $this->response->redirect('user/register');
        }

        $form->bind($_POST, $user);
        // check form validation

        // $user->assign(
        //     $this->request->getPost(),
        //     [
        //         'name',
        //         'id',
        //         'role',
        //         'password'

        //     ]
        // );
        if (!$form->isValid()) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'register',
                ]);
                return;
            }
        }
        
        
        # Doc :: https://docs.phalconphp.com/en/3.3/security
        $user->setPassword($this->security->hash($this->request->getPost('password')));
        $user->setName($this->request->getPost('name'));
        $user->setId($this->request->getPost('id'));
        $user->setRole($this->request->getPost('role'));
        $user->setActive(1);
        //$user->setCreated(time());
        //$user->setUpdated(time());
        
        # Doc :: https://docs.phalconphp.com/en/3.3/db-models#create-update-records
        if (!$user->save()) {
            foreach ($user->getMessages() as $m) {
                $this->flashSession->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'register',
                ]);
                return;
            }
        }

        // $success = $user->save();
        

        // if($success) {
        //     echo 'acoount registered';
        //     $this->view->disable();
        // }

        // $this->view->message = $message;

        /**
         * Send Email
         */
        // $params = [
        //     'name' => $this->request->getPost('name'),
        //     'link' => "http://localhost/_Phalcon/demo-app2/signup"
        // ];
        // $mail->send($this->request->getPost('email', ['trim', 'email']), 'signup', $params);

        $this->flashSession->success('Thanks for registering!');
        return $this->response->redirect('user/register');

        $this->view->disable();
    }

    public function profileAction()
    {
        $this->authorized();
    }

    /**
     * User Logout
     */
    public function logoutAction()
    {
        # https://docs.phalconphp.com/en/3.3/session#remove-destroy

        // Destroy the whole session
        $this->session->destroy();
        return $this->response->redirect('user/login');
    }

    public function takeClassAction($classId){
        $ambil = new Ambil();
        
        $kelas = Kelas::findFirstById($classId);
        //$kelas = new Kelas();
        //$siswa = new Siswa();

        $ambil->setSiswa($this->session->get('AUTH_ID'));
        $ambil->setKelas($classId);
        $ambil->setMapel($kelas->mapel);
        $ambil->setPengajar($kelas->pengajar);
        $ambil->setRuang($kelas->ruang);
        $ambil->setWaktu($kelas->waktu);

        $ambil->save();
        $this->flashSession->success('Kelas berhasil diambil');
        return $this->response->redirect('user/profile');

    }

    public function unenrollAction($classId){
        $ambil = Ambil::findFirst([
            'siswa = ?1 AND kelas_id = ?2',
            'bind' => [
                1 => $this->session->get('AUTH_ID'),
                2 => $classId,
            ],
        ]);

        if ($ambil->delete() === false) {
            $messages = $ambil->getMessages();
            foreach ($messages as $message) {
                $this->flash->error($message);
            }
        } else {
            return $this->response->redirect('user/profile');
        }
        
    }
    
    

}

