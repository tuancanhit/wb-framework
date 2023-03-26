<?php
declare(strict_types=1);

namespace William\Base\Model;

use William\Base\Exception\SystemInitFailureException;

/**
 * Class AbstractCollection
 *
 * @package William\Base\Model
 */
class AbstractCollection extends \William\Base\Model\AbstractDb
{
    /** @var int|null */
    protected ?int $limit = null;

    /** @var int|null */
    protected ?int $offset = null;

    /** @var array */
    protected array $filters = [];

    /**
     * @param array $data
     * @throws SystemInitFailureException
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->_init();
    }

    /**
     * @return void
     */
    public function _init()
    {
        if (null == $this->getModelClass()) {
            $this->setData('model_class', AbstractModel::class);
        }
    }

    /**
     * @param string $field
     * @param mixed  $value
     * @param string $operator
     * @return $this
     */
    public function addFieldToFilter(string $field, $value, $operator = null)
    {
        $operator = $operator ?? '=';
        if (strtoupper($operator) == 'IN' && is_array($value)) {
            $value = sprintf('("%s")', implode('","', $value));
        } else {
            $value = sprintf('"%s"', $value);
        }
        $this->filters[] = [
            'field' => $field,
            'value' => $value,
            'operator' => $operator
        ];
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function loadAll()
    {
        $query = sprintf('select * from %s', $this->getMainTable());
        if (!empty($conditions = $this->resolveFilter())) {
            $query = sprintf('%s %s', $query, $conditions);
        }
        if (!empty($limit = $this->resolveLimit())) {
            $query = sprintf('%s %s', $query, $limit);
        }

        $query = $this->dbConnector->query($query);
        $result = [];
        $modelClass = $this->getModelClass();
        while ($row = mysqli_fetch_object($query)) {
            $result[] = new $modelClass((array)$row);
        }
        return $result;
    }

    /**
     * @return string|null
     */
    protected function resolveLimit()
    {
        if ($this->limit > 0) {
            return sprintf('LIMIT %s', $this->limit);
        }
        return null;
    }

    /**
     * @return string
     */
    protected function resolveFilter()
    {
        $conditions = '';
        foreach ($this->filters as $filter) {
            $conditions .= sprintf('%s %s %s', $filter['field'], $filter['operator'], $filter['value']);
        }
        if (!$conditions) {
            return null;
        }
        return sprintf('WHERE %s', $conditions);
    }
}
