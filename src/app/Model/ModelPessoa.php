<?php

namespace Cristian\CrudDoctrine\App\Model;

use Cristian\CrudDoctrine\App\Helper\EntityManagerFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @Entity
 */
class ModelPessoa {

	/**
	 * @Id
	 * @GeneratedValue
	 * @Column(type="integer")
	 */
  private int $id;

	/**
	 * @Column(type="string")
	 */
	private string $nome;
	
	/**
	 * @Column(type="string")
	 */
  private string $cpf;


	/**
	 * @OneToMany(targetEntity="ModelContato", mappedBy="Pessoa")
	 */
	private Collection $contatos;

	public function __construct(){
		$this->contatos = new ArrayCollection();
	}

	/**
	 * Retorna o Identificador de Pessoa;
	 *
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Retorna o Nome de Pessoa;
	 *
	 * @return string
	 */
	public function getNome() {
		return $this->nome;
	}

	/**
	 * Retorna o CPF de Pessoa;
	 *
	 * @return string
	 */
	public function getCpf() {
		return $this->cpf;
	}

	/**
	 * Define o valor para o identificador de Pessoa;
	 *
	 * @param int $iId  
	 * @return int
	 */
	public function setId($iId) {
		$this->id = $iId;
	}
  
	/**
	 * Define o valor para o Nome de Pessoa;
	 *
	 * @param string $sNome  
	 */
	public function setNome($sNome) {
		$this->nome = $sNome;
	}

	/**
	 * Define o valor para o CPF de Pessoa;
	 *
	 * @param string $sCpf 
	 */
	public function setCpf($sCpf) {
		$this->cpf = $sCpf;
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
		$oPessoa = $oEntityManager->getReference($this::class, $this->getId());

		if (!is_null($oPessoa)) {
			$oEntityManager->remove($oPessoa);
			$oEntityManager->flush($oPessoa);
		}
	}
	
	/**
	 * Atualiza os dados com base no modelo atual
	 * @param int $id
	 */
	public function update() {
		$oEntityManager = $this->getEntityManager();
		$oRepo = $oEntityManager->getRepository($this::class);
		$oPessoa = $oRepo->find($this->getId());
		$oPessoa->setNome($this->getNome());
		$oPessoa->setCpf($this->getCpf());
		$oEntityManager->flush($oPessoa);
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
	 * Persiste o Modelo
	 * @return ModelPessoa
	 */
	public function persisteModelo() {
		$oEntityManager = $this->getEntityManager();
		$oEntityManager->persist($this);
		return $this;
	}
	
	/**
	 * Retorna o EntityManager
	 * @return EntityManager
	 */
	private function getEntityManager(){
		$oEntityManagerFactory = new EntityManagerFactory();
		return $oEntityManagerFactory->getEntityManager();
	}


	/**
	 *Retorna o valor de contatos
	 * @return  mixed
	 */
	public function getContato() {
		return $this->contatos;
	}

	/**
	 * Define o valor de contatos
	 *
	 * @param ModelContato $contatos  
	 */
	public function setContato(ModelContato $contato) {
		$this->contatos[] = $contato;
	}
};
