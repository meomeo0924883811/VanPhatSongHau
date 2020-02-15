<?php
namespace Admin\Controller;

use Cake\Filesystem\Folder;
require_once(ROOT .DS. 'src'.DS. 'Lib' . DS .'image_load.php');
use image_load;

/**
 * News Controller
 *
 *
 * @method \Admin\Model\Entity\News[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NewsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $news = $this->paginate($this->News);

        $this->set(compact('news'));
    }

    /**
     * View method
     *
     * @param string|null $id News id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $news = $this->News->get($id, [
            'contain' => []
        ]);

        $this->set('news', $news);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $news = $this->News->newEntity();
        if ($this->request->is('post')) {
            $news = $this->News->patchEntity($news, $this->request->getData());

            if ($this->News->save($news)) {
                //  Image handler
                if(file_exists(WWW_ROOT . $news->thumbnail)){
                    $this->imageSavingHandler($news);
                    $this->News->save($news);
                }
                //  Image handler
                $this->Flash->success(__('The image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The news could not be saved. Please, try again.'));
        }
        $this->set(compact('news'));
    }

    function imageSavingHandler($news){
        $image_path = 'files/upload/thumbnails/' . $news->id;
        $dir_image = new Folder(WWW_ROOT . $image_path, true, 0777);
        $news->thumbnail =  $this->moveResizeImage(
            $news->thumbnail,
            str_replace('files/upload/temp/', '', $news->thumbnail),
            $image_path);
        $folder = new Folder(WWW_ROOT . 'files/upload/temp');
        $folder->delete();
        $folder = new Folder(WWW_ROOT . 'files/upload/temp', true, 0777);

    }
    function moveResizeImage($image_path = null, $file_name= null, $thumb_path = null){
        if(file_exists($image_path))
        {
            $img = new image_load();
            $img->load($image_path);
//            $img->resize_to_width(600);
            $img->save($thumb_path.'/'.$file_name,100);
            return $thumb_path.'/'.$file_name;
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id News id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $news = $this->News->get($id, [
            'contain' => []
        ]);

        $original_image = $news->thumbnail;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $news = $this->News->patchEntity($news, $this->request->getData());
            if ($this->News->save($news)) {

                if(file_exists($news->thumbnail) && $original_image != $news->thumbnail){
                    $this->imageSavingHandler($news);
                    $this->News->save($news);
                }

                $this->Flash->success(__('The news has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The news could not be saved. Please, try again.'));
        }
        $this->set(compact('news'));
    }

    /**
     * Delete method
     *
     * @param string|null $id News id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $news = $this->News->get($id);
        if ($this->News->delete($news)) {
            $this->Flash->success(__('The news has been deleted.'));
        } else {
            $this->Flash->error(__('The news could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
