<?php

namespace database;

/**
 * base request builder for a database
 */
abstract class Request
{
	use \core\Base;

	/**
	 * steps for constructing the query
	 *
	 * @var array
	 */
	const STEPS = [];
	/**
	 * required steps for constructing the query
	 *
	 * @var array
	 */
	const STEPS_REQUIRED = [];
	/**
	 * database connection for this request
	 *
	 * @var \PDO
	 */
	protected \PDO $database;
	/**
	 * parameters for this request
	 *
	 * @var array
	 */
	protected array $parameters = [];
	/**
	 * query for this request
	 *
	 * @var array
	 */
	protected string $query = '';
	/**
	 * add a parameter to the query (condition, order, etc.)
	 *
	 * @param string $name
	 *
	 * @param \database\Parameter $parameter
	 *
	 * @return self
	 */
	public function addParameter(string $name, \database\Parameter $parameter) : self
	{
		if (!\in_array($name, $this::STEPS))
		{
			$GLOBALS['Logger']->log($GLOBALS['lang']['class']['database']['Request']['addParameter']['unknwown'], ['name' => $name, 'parameter' => $parameter]);
			throw \Exception($GLOBALS['locale']['class']['database']['Request']['addParameter']['unknown']);
		}
		$method_add = 'add' . \ucfirst($name);

		if (!\method_exists($this, $method_add))
		{
			$GLOBALS['Logger']->log($GLOBALS['lang']['class']['database']['Request']['addParameter']['no_method'], ['method' => $method_add, 'parameter' => $parameter]);
			throw \Exception($GLOBALS['locale']['class']['database']['addParameter']['no_method']);
		}

		return $this->$method_add($parameter);
	}
	/**
	 * build the query
	 *
	 * @return self
	 */
	public function buildQuery() : self
	{
		$query = '';
		foreach ($this::STEPS as $step)
		{
			$method_check = 'has' . \ucfirst($step) . 's';
			$method_construct = 'construct' . \ucfirst($step) . 's';

			if (\method_exists($this, $method_check) && \method_exists($this, $method_construct))
			{
				if ($this->$method_check())
				{
					$query .= ' ' . $this->$method_construct();
				}
			}
			else if (\in_array($step, $this::STEPS_REQUIRED))
			{
				$GLOBALS['Logger']->log($GLOBALS['lang']['class']['database']['Request']['buildQuery']['step_required'], ['step' => $step]);
				throw new \Exception($GLOBALS['locale']['class']['database']['Request']['buildQuery']['step_required']);
			}
		}
		$this->set('query', $query);

		return $this;
	}
	/**
	 * execute the query with the parameters
	 *
	 * @return array
	 */
	public function execute() : array
	{
		if (\empty($this->get('query')))
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['database']['Request']['execute']['empty_query']);
			throw new \Exception($GLOBALS['locale']['class']['database']['Request']['execute']['empty_query']);
		}
		if (\phosphore_count($this->get('parameters')) === 0)
		{
			$GLOBALS['Logger']->log(\core\Logger::TYPES['warning'], $GLOBALS['lang']['class']['database']['Request']['execute']['empty_parameters']);
			throw new \Exception($GLOBALS['locale']['class']['database']['Request']['execute']['empty_parameters']);
		}

		$request = $this->get('database')->prepare($this->get('query'));

		$request->execute($this->get('parameters'));

		return $request->fetchAll();
	}
	/**
	 * run the request
	 *
	 * @return array
	 */
	public function run() : array
	{
		return $this->buildQuery()->execute();
	}
}

?>
