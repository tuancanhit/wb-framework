<?php
declare(strict_types=1);

namespace William\Base\Model;

use Exception;
use mysqli_result;
use William\Base\Exception\SystemInitFailureException;

/**
 * Class Product
 *
 * @package William\Base\Model
 */
class AbstractResourceModel extends AbstractDb
{
    /**
     * @param array $data
     * @throws SystemInitFailureException
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * @param AbstractModel $model
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function save(AbstractModel $model)
    {
        if ($model->getId()) {
            return $this->update(...func_get_args());
        }
        return $this->insert(...func_get_args());
    }

    /**
     * @throws Exception
     */
    public function insert(AbstractModel $model)
    {
        $query = sprintf(
            'INSERT INTO %s (%s) VALUES (%s);',
            $this->getData('table'),
            implode(',', array_keys($model->getData())),
            sprintf('"%s"', implode('","', $model->getData())),
        );
        return $this->dbConnector->query($query);
    }

    /**
     * @param AbstractModel $model
     * @return bool|mysqli_result
     * @throws Exception
     */
    protected function update(AbstractModel $model)
    {
        $primary = $this->getData('primary');
        $query = 'UPDATE ' . $this->getData('table') . ' SET ' . implode(', ', array_filter(array_map(
                function ($key, $value) use ($primary) {
                    if ($key == $primary) {
                        return null;
                    }
                    return sprintf('%s="%s"', $key, $value);
                },
                array_keys($model->getData()),
                $model->getData()
            ))) . ' WHERE ' . $primary . ' = ' . $model->getData(
                $primary
            );
        return $this->dbConnector->query($query);
    }
}
