<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Personas Controller
 *
 * @property \App\Model\Table\PersonasTable $Personas
 */
class PersonasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $personas = $this->paginate($this->Personas);

        $this->set(compact('personas'));
        $this->set('_serialize', ['personas']);
    }

    /**
     * View method
     *
     * @param string|null $id Persona id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $persona = $this->Personas->get($id, [
            'contain' => ['Asistenciapersonas', 'Clubs', 'Clubsvoluntarios', 'Estudiantes', 'Horariospersonas', 'Pasantes', 'Trabajadores']
        ]);

        $this->set('persona', $persona);
        $this->set('_serialize', ['persona']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $persona = $this->Personas->newEntity();
        if ($this->request->is('post')) {
            $persona = $this->Personas->patchEntity($persona, $this->request->data);
            if ($this->Personas->save($persona)) {
                $this->Flash->success(__('Se guardado el registro.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Ocurrio un error, has un nuevo intento.'));
            }
        }
        $this->set(compact('persona'));
        $this->set('_serialize', ['persona']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Persona id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $persona = $this->Personas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $persona = $this->Personas->patchEntity($persona, $this->request->data);
            if ($this->Personas->save($persona)) {
                $this->Flash->success(__('Se ha guardado el registro correctamente.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Ocurrio un error, has un nuevo intento.'));
            }
        }
        $this->set(compact('persona'));
        $this->set('_serialize', ['persona']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Persona id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $persona = $this->Personas->get($id);
        if ($this->Personas->delete($persona)) {
            $this->Flash->success(__('El registro se ha eliminado'));
        } else {
            $this->Flash->error(__('Ocurrio un error, has un nuevo intento.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
