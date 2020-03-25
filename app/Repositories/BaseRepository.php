<?php
namespace App\Repositories;
abstract class BaseRepository
{
	protected $limit = 10;
	protected $skip = 0;
	protected $entity = null;
	protected $Configuracao = null;
	protected $ConfFotocapa = null;
	protected $Api = null;
	public function __construct() {
		$this->Api = new ApiCollection;
		#$this->Configuracao = $app->configuracoes();
		#$this->ConfFotocapa = $app->FotocapaTipos();
	}
	/**
	 * Retorna lista de registros
	 *
	 * @return mixed
	 */
	public function all($columns = array('*')) {
		return $this->entity->skip($this->skip)->take($this->limit)->get($columns);
	}
	/**
	 * Retorna um único registro
	 *
	 * @param $cod int|string Código identificador
	 *
	 * @return mixed
	 */
	public function find($id, $columns = array('*')) {
		return $this->entity->find($id, $columns);
	}
	/**
	 * Carrega informações de outros relacionamentos da entidade.
	 *
	 * @param array $relations Array com os nomes dos relacionamentos a serem carregados
	 *
	 * @return mixed
	 */
	public function load(array $relations){
		return $this->entity->load($relations)->get();
	}
    /**
    * @param int $perPage
    * @param array $columns
    * @return mixed
    */
    public function paginate($perPage = 15, $columns = array('*')) {
		return $this->entity->paginate($perPage, $columns);
	}
    /**
    * @param array $data
    * @return mixed
    */
    public function create(array $data) {
		return $this->entity->create($data);
	}
    /**
    * @param array $data
    * @param $id
    * @param string $field
    * @return mixed
    */
    public function update(array $data, $id, $field="id") {
		return $this->entity->where($field, '=', $id)->update($data);
	}
    /**
    * @param $id
    * @return mixed
    */
    public function delete($id) {
		return $this->entity->destroy($id);
	}   
    /**
    * @param $id
    * @return mixed
    */
    public function deleteBy($field, $value) {
		return $this->entity->where($field, $value)->delete();
	}   
   
    /**
    * @param $field
    * @param $value
    * @param array $columns
    * @return mixed
    */
    public function findBy($field, $value, $columns = array('*')) {
		return $this->entity->where($field, '=', $value)->first($columns);
	}  
   
    /**
    * @param $match
    * @param array $columns
    * @return mixed
    */
    public function findMultipleWhere($match, $columns = array('*')) {
		return $this->entity->where($match)->get($columns);
	}
}