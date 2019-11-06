<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * Samples Controller
 *
 * @property \Admin\Model\Table\SamplesTable $Samples
 *
 * @method \Admin\Model\Entity\Sample[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SamplesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $samples = $this->paginate($this->Samples);

        $this->set(compact('samples'));
    }

    /**
     * View method
     *
     * @param string|null $id Sample id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sample = $this->Samples->get($id, [
            'contain' => []
        ]);

        $this->set('sample', $sample);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sample = $this->Samples->newEntity();
        if ($this->request->is('post')) {
            $sample = $this->Samples->patchEntity($sample, $this->request->getData());
            if ($this->Samples->save($sample)) {
                $this->Flash->success(__('The sample has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sample could not be saved. Please, try again.'));
        }
        $this->set(compact('sample'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sample id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sample = $this->Samples->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sample = $this->Samples->patchEntity($sample, $this->request->getData());
            if ($this->Samples->save($sample)) {
                $this->Flash->success(__('The sample has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sample could not be saved. Please, try again.'));
        }
        $this->set(compact('sample'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sample id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sample = $this->Samples->get($id);
        if ($this->Samples->delete($sample)) {
            $this->Flash->success(__('The sample has been deleted.'));
        } else {
            $this->Flash->error(__('The sample could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function change_status()
    {
        $this->autoRender = false;
        $response = array('status' => 0);
        if($this->request->is('ajax')){
            $id = isset($this->request->data['id']) ? $this->request->data['id'] : 0;
            $field = isset($this->request->data['field']) ? $this->request->data['field'] : "";
            if($id > 0 && $field != ""){
                $sample = $this->Samples->get($id);
                $status = $sample->$field;
                $change_status = $status == 1 ? 0 : 1;
                $sample->$field = $change_status;
                if($this->Samples->save($sample)){
                    $response = array(
                        'status' => 1,
                        'data' => array(
                            'id' => $sample->id,
                            'status' => $change_status
                        )
                    );
                }
                else{
                    $response = array('status' => -1);
                }
            }
        }
        $this->response->body(json_encode($response));
        $this->response->type('json');
        return $this->response;
    }
}
