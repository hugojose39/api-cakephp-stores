<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

/**
 * Stores Controller
 *
 * @method \App\Model\Entity\Store[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StoresController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index(): Response
    {
        // Pagina os registros de lojas e seus endereços associados
        $stores = $this->paginate($this->Stores->find()->contain(['Addresses']));

        // Monta a resposta
        $response = $this->response
            ->withType('application/json')
            ->withStatus(200)
            ->withStringBody(json_encode($stores));

        return $response;
    }

    /**
     * Show method
     *
     * @param string|null $id Store id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function show(?string $id = null): Response
    {
        // Obtém os detalhes da loja com o ID especificado, incluindo os endereços associados
        $store = $this->Stores->get($id, [
            'contain' => ['Addresses'],
        ]);

        // Monta a resposta
        $response = $this->response
            ->withType('application/json')
            ->withStatus(200)
            ->withStringBody(json_encode($store));

        return $response;
    }

    /**
     * Create method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful create, renders view otherwise.
     */
    public function create(): Response
    {
        // Cria uma nova entidade de loja vazia
        $store = $this->Stores->newEmptyEntity();
        // Verifica se a requisição é do tipo POST
        if ($this->request->is('post')) {
            // Preenche a entidade de loja com os dados da requisição, incluindo os dados do endereço associado
            $store = $this->Stores->patchEntity($store, $this->request->getData(), [
                'associated' => ['Addresses'],
            ]);

            // Cria uma nova entidade de endereço com os dados fornecidos
            $address = $this->Stores->Addresses->newEntity($this->request->getData('address') ?? []);

            // Atribui o endereço à entidade da loja
            $store->set('Addresses', $address);

            // Salva a loja
            if ($this->Stores->save($store)) {
                // Monta a resposta
                $response = $this->response
                    ->withType('application/json')
                    ->withStatus(201)
                    ->withStringBody(json_encode($store));
                return $response;
            }

            // Em caso de erro, retorna uma resposta de erro
            $errors = $store->getErrors();
            return $this->response
                ->withType('application/json')
                ->withStatus(400)
                ->withStringBody(json_encode(['error' => $errors]));
        }
    }

    /**
     * Update method
     *
     * @param string|null $id Store id.
     * @return \Cake\Http\Response|null|void Redirects on successful update, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function update(?string $id = null): Response
    {
        // Obtém os detalhes da loja com o ID especificado, incluindo os endereços associados
        $store = $this->Stores->get($id, [
            'contain' => ['Addresses'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $store = $this->Stores->patchEntity($store, $this->request->getData());

            // Cria uma nova entidade de endereço com os dados fornecidos
            $address = $this->Stores->Addresses->newEntity($this->request->getData('address') ?? []);

            // Atribui o endereço à entidade da loja
            $store->set('Addresses', $address);

            // Salva os dados da loja
            if ($this->Stores->save($store)) {
                // Monta a resposta
                $response = $this->response
                    ->withType('application/json')
                    ->withStatus(200)
                    ->withStringBody(json_encode($store));

                return $response;
            }
        }

        // Em caso de erro, retorna uma resposta de erro
        $errors = $store->getErrors();
        return $this->response
            ->withType('application/json')
            ->withStatus(400)
            ->withStringBody(json_encode(['error' => $errors]));
    }

    /**
     * Delete method
     *
     * @param string|null $id Store id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): Response
    {
        // Permite apenas os métodos POST e DELETE
        $this->request->allowMethod(['post', 'delete']);
        // Obtém os detalhes da loja com o ID especificado
        $store = $this->Stores->get($id);

        // Deleta a loja
        if ($this->Stores->delete($store)) {
            // Monta a resposta
            return $this->response
                ->withType('application/json')
                ->withStatus(204);
        }

        // Em caso de erro, retorna uma resposta de erro
        return $this->response
            ->withType('application/json')
            ->withStatus(400)
            ->withStringBody(json_encode(['error' => 'Não foi possível excluir a loja']));
    }
}
