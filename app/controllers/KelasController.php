<?php
declare(strict_types=1);

use Phalcon\Di;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Http\Request;
use Phalcon\Mvc\View;
use App\Forms\AddclassForm;
use Phalcon\Paginator\Adapter\NativeArray as ArrayPaginator;

class KelasController extends ControllerBase
{

    public $form;
    public $kelas;
    public function initialize()
    {

        $this->authorized();
        $this->form = new AddclassForm();
        $this->kelas = new Kelas();
    }

    public function indexAction()
    {
        $query = $this->modelsManager->createQuery('SELECT * FROM Kelas');
        
        $result = $query->execute();
        $this->view->setVar('result', $result);

    }

    public function addClassAction(){
        $this->tag->setTitle('BIMBIM::Tambah Kelas');
        $this->view->form = new AddclassForm();

    }

    public function addClassSubmitAction(){

        $mapel = $this->request->get('mapel');
        $ruang = $this->request->get('ruang');
        $waktu = $this->request->get('waktu');

        $this->kelas->setMapel($mapel);
        $this->kelas->setPengajar($this->session->get('AUTH_ID'));
        $this->kelas->setRuang($ruang);
        $this->kelas->setWaktu($waktu);

        $this->form->bind($_POST, $this->kelas);

        if (!$this->form->isValid()) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'addClass',
                ]);
                return;
            }
        }
        if (!$this->kelas->save()) {
            foreach ($this->kelas->getMessages() as $m) {
                $this->flash->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'addClass',
                ]);
                return;
            }
        }
        $this->view->disable();
        $this->flashSession->success('kelas berhasil dibuat');
       
        return $this->response->redirect('kelas/addClass');

    }

    public function editAction($classId){
        //if(!$this->request->isPost()){
        
        $conditions = ['id'=>$classId];
        $this->kelas = Kelas::findFirst([
            'conditions' => 'id=:id:',
            'bind' => $conditions,
        ]);

        $this->view->form = new AddclassForm($this->kelas, [
            "edit" => true
        ]);
        
    }
    
    /**
     * Edit Kelas Action Submit
     * @method: POST
     * @param: title
     * @param: description
     */

    public function editSubmitAction(){
        if (!$this->request->isPost()) {  
            return $this->response->redirect('user/profile');
        }
        $id = $this->request->getPost('id', 'int');
        $this->kelas = Kelas::findFirstById($id);

        $mapel = $this->request->getPost('mapel');
        $ruang = $this->request->getPost('ruang');
        $waktu = $this->request->getPost('waktu');
        $pengajar = $this->session->get('AUTH_ID');

        $this->kelas->setMapel($mapel);
        $this->kelas->setPengajar($pengajar);
        $this->kelas->setRuang($ruang);
        $this->kelas->setWaktu($waktu);

        $success = $this->kelas->update();

        if($success){
            $this->flashSession->success("Kelas telah diupdate");;
            return $this->response->redirect('user/profile');
        } else {
            $this->flashSession->error("Gagal mengupdate Kelas");
            return $this->response->redirect('kelas/edit/'.$id);
        }
        
          
    }

    public function deleteAction($classId){
        // $conditions2 = ['kelas_id' =>$classId];
        // $ambil = Ambil::find([
        //     'conditions' => 'kelas_id=:kelas_id:',
        //     'bind' => $conditions2,
        // ]);
        // $ambil->delete();
        $ambil = Ambil::find([
            'kelas_id = ?1',
            'bind' => [
                
                1 => $classId,
            ],
        ]);
        if($ambil->delete()===false){
            $messages = $ambil->getMessages();
            foreach ($messages as $message) {
                $this->flash->error($message);
            }
        }

        $conditions = ['id'=>$classId];
        $this->kelas = Kelas::findFirst([
            'conditions' => 'id=:id:',
            'bind' => $conditions,
        ]);
        
        if ($this->kelas->delete() === false) {
            $messages = $this->kelas->getMessages();
            foreach ($messages as $message) {
                $this->flash->error($message);
            }
        } else {
            return $this->response->redirect('user/profile');
        }
    }

    public function userAction(){
        if($this->session->get('AUTH_ROLE')=='siswa'){
            $query = $this->modelsManager->createQuery('SELECT * FROM Ambil where siswa=:siswa:');

            $result = $query->execute([
                'siswa' => $this->session->get('AUTH_ID'),
            ]);
            $this->view->setVar('result', $result);
        }
        else {
            $query = $this->modelsManager->createQuery('SELECT * FROM Kelas where pengajar= :pengajar:');

            $result = $query->execute([
                'pengajar' => $this->session->get('AUTH_ID'),
            ]);
            $this->view->setVar('result', $result);
        }

    }

    public function searchAction() {
        $searched = $this->request->get('search');
        
        $query = $this->modelsManager->createQuery("SELECT * FROM Kelas where mapel LIKE '%" . $searched. "%' ");

        $result = $query->execute();
        $this->view->setVar('result', $result);

        // $searched = $this->request->get('search');
        // if ($searched !== null) {
        //     $this->kelas = Kelas::find("mapel LIKE '%" . $searched. "%' ");
        //     // var_dump($questions['question_id']); die();
        //     $this->view->kelas = $this->kelas;
        // }
        //$this->view->searched = $searched;
    }

    

}

