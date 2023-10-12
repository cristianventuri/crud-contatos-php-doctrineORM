<?php

namespace Cristian\CrudDoctrine\App\Model;

use Cristian\CrudDoctrine\App\Helper\EntityManagerFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @Entity
 */
class ModelContato {

	/**
	 * @Id
	 * @GeneratedValue
	 * @Column(type="integer")
	 */
  private int $id;

	/**
	 * @Column(type="boolean")
	 */
  private bool $tipo;

	/**
	 * @Column(type="string")
	 */
  private string $descricao;

	/**
	 * @ManyToOne(targetEntity="ModelPessoa", inversedBy="contatos")
	 * @JoinColumn(name="pessoa_id", referencedColumnName="id")
	 */
  // private ModelPessoa $Pessoa;

	/**
	 * @Column(type="integer")
	 */
  private int $pessoa_id;

	/**
	 * Retorna o Identificador de Contato;
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Retorna o Tipo de Contato;
	 *
	 * @return int
	 */
	public function getTipo() {
		return $this->tipo;
	}

	/**
	 * Retorna a Descrição de Contato;
	 *
	 * @return string
	 */
	public function getDescricao() {
		return $this->descricao;
	}

	/**
	 * Retorna o Modelo de Pessoa de Contato;
	 *
	 * @return ModelPessoa
	 */
	// public function getPessoa() {
		//   if(!isset($this->Pessoa)){
			//     $this->Pessoa = new ModelPessoa();
			//   }
			
			// 	return $this->Pessoa;
			// }
			
	/**
	 * Retorna o Modelo de Pessoa de Contato;
	 *
	 * @return int
	 */
	public function getPessoa() {
		return $this->pessoa_id;
	}

	/**
	 * Define o valor para o identificador de Contato;
	 *
	 * @param int $iId  
	 */
	public function setId($iId) {
		$this->id = $iId;
	}
  
	/**
	 * Define o valor para o Tipo de Contato;
	 *
	 * @param bool $bTipo  
	 */
	public function setTipo($bTipo) {
		$this->tipo = $bTipo;
	}
  
	/**
	 * Define o valor para o Descrição de Contato;
	 *
	 * @param string $sDescricao  
	 */
	public function setDescricao($sDescricao) {
		$this->descricao = $sDescricao;
	}

	/**
	 * Define o ModelPessoa do Contato;
	 *
	 * @param ModelPessoa $Pessoa 
	 */
	// public function setPessoa(ModelPessoa $Pessoa) {
	// 	$this->Pessoa = $Pessoa;
	// }

	/**
	 * Define o Id de pessoa;
	 * @param int $iPessoa
	 */
	public function setPessoa($iPessoa) {
		$this->pessoa_id = $iPessoa;
	}

	/**
	 * Insere os dados com base no modelo atual
	 */
	public function insere() {
		$oEntityManager = $this->getEntityManager();
		$oEntityManager->persist($this);
		$oEntityManager->flush($this);
	}

	/**
	 * Deleta os dados com base no modelo atual
	 */
	public function delete() {
		$oEntityManager = $this->getEntityManager();
		$oEntityManager->getRepository($this::class);
		$oContato = $oEntityManager->getReference($this::class, $this->getId());

		if (!is_null($oContato)) {
			$oEntityManager->remove($oContato);
			$oEntityManager->flush($oContato);
		}
	}
	
	/**
	 * Atualiza os dados com base no modelo atual
	 * @param int $id
	 */
	public function update() {
		$oEntityManager = $this->getEntityManager();
		$oRepo = $oEntityManager->getRepository($this::class);
		$oContato = $oRepo->find($this->getId());
		$oContato->setTipo($this->getTipo());
		$oContato->setDescricao($this->getDescricao());
		$oContato->setPessoa($this->getPessoa());
	
		$oEntityManager->flush($oContato);
	}
	
	/**
	 * Realiza a busca de todas as informações do banco
	 * @return array
	 */
	public function buscaDados() {
		$oEntityManager = $this->getEntityManager();
		$oRepo = $oEntityManager->getRepository($this::class);
		return $oRepo->findAll();
	}

	/**
	 * Realiza a bunca de informações com base no identificador do registro
	 * @param int $id
	 * @return object
	 */
	public function buscaDadosPorId(int $id) {
		$oEntityManager = $this->getEntityManager();
		$oRepo = $oEntityManager->getRepository($this::class);
		return $oRepo->find($id);
	}

	/**
	 * Retorna os dados com base na coluna x valor
	 * @param string $column
	 * @param mixed $value
	 * @return array
	 */
	public function buscaDadosPor($column, $value) {
		$oEntityManager = $this->getEntityManager();
		$oRepo = $oEntityManager->getRepository($this::class);
		return $oRepo->findBy([
			$column => $value
		]);
	}

	/**
	 * Retorna o EntityManager
	 * @return EntityManager
	 */
	private function getEntityManager(){
		$oEntityManagerFactory = new EntityManagerFactory();
		return $oEntityManagerFactory->getEntityManager();
	}

};
