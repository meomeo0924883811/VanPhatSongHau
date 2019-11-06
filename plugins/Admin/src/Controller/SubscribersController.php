<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;
use Cake\Filesystem\File;

/**
 * Subscribers Controller
 *
 *
 * @method \Admin\Model\Entity\Subscriber[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubscribersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $option = ['conditions' => []];
        if (!empty($search = $this->request->getQuery('search'))) {
            $option['conditions'][] = [
                "OR" => [
                    'name LIKE' => "%" .$search. "%",
                    'phone LIKE' => "%" .$search. "%",
                ]
            ];
        }
        $this->paginate = $option;
        $subscribers = $this->paginate($this->Subscribers);

        $this->set(compact('subscribers'));
    }

    /**
     * View method
     *
     * @param string|null $id Subscriber id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subscriber = $this->Subscribers->get($id, [
            'contain' => []
        ]);

        $this->set('subscriber', $subscriber);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subscriber = $this->Subscribers->newEntity();
        if ($this->request->is('post')) {
            $subscriber = $this->Subscribers->patchEntity($subscriber, $this->request->getData());
            if ($this->Subscribers->save($subscriber)) {
                $this->Flash->success(__('The subscriber has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriber could not be saved. Please, try again.'));
        }
        $this->set(compact('subscriber'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Subscriber id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subscriber = $this->Subscribers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subscriber = $this->Subscribers->patchEntity($subscriber, $this->request->getData());
            if ($this->Subscribers->save($subscriber)) {
                $this->Flash->success(__('The subscriber has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subscriber could not be saved. Please, try again.'));
        }
        $this->set(compact('subscriber'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subscriber id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subscriber = $this->Subscribers->get($id);
        if ($this->Subscribers->delete($subscriber)) {
            $this->Flash->success(__('The subscriber has been deleted.'));
        } else {
            $this->Flash->error(__('The subscriber could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function export() {
        $this->loadModel('Subscribers');

        $writer = WriterFactory::create(Type::XLSX);
        $filePath = new File(WWW_ROOT . 'files' . DS . 'excel' . DS . 'products.xlsx');
        $writer = WriterFactory::create(Type::XLSX); // for XLSX files
        if (!$filePath->exists()) {

            //$folder = new Folder(WWW_ROOT . 'files' . DS . 'excel');
            $file = new File(WWW_ROOT . 'files' . DS . 'excel' . DS . 'products.xlsx', true, 0644);
        }
        $filePath = WWW_ROOT . 'files' . DS . 'excel' . DS . 'products.xlsx';

        $defaultStyle = (new StyleBuilder())
            ->setFontName('Arial')
            ->setFontSize(11)
            ->setShouldWrapText(false)
            ->build();
        $writer->setDefaultRowStyle($defaultStyle)
            ->openToFile($filePath);
        $header = array(
            'id' => 'Id',
            'name' => 'Name',
            'phone' => 'Phone',
        );

        $fields = array_keys($header);
        $row_header = array_values($header);
        $writer->addRow($row_header);

        $subscribers = $this->Subscribers
            ->find('all')
            ->toArray();
        foreach ($subscribers as $subscriber) {
            $i = 0;
            $row = array();
            foreach ($header as $key => $value) {
                $row[] = $subscriber[$key];
            }
            $writer->addRow($row);
        }
        $writer->addRow(['']);
        $writer->addRow(['']);
        $writer->addRow(['Total', count($subscribers)]);
        $writer->close();
        $this->response->file($filePath, array(
            'download' => true,
            'name' => rand() . '_subscribers.xlsx'
        ));
        return $this->response;
    }
}
