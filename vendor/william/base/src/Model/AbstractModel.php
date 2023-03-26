<?php
declare(strict_types=1);

namespace William\Base\Model;

use William\Base\Exception\NoSuchIdException;
use William\Base\Exception\SystemInitFailureException;

/**
 * Class Product
 *
 * @package William\Base\Model
 */
class AbstractModel extends \William\Base\Model\AbstractDb
{
    /** @var string */
    protected string $table = '';

    /** @var string */
    protected string $primary = '';

    /** @var string */
    protected string $class = '';

    /** @var AbstractResourceModel|null */
    protected ?AbstractResourceModel $resourceModel = null;

    /** @var AbstractCollection|null  */
    private ?AbstractCollection $collection = null;

    /** @var string  */
    private string $collectionClass = AbstractCollection::class;

    /** @var string  */
    private string $resourceModelClass = AbstractResourceModel::class;

    /**
     * @param array $data
     * @throws SystemInitFailureException
     */
    public function __construct(array $data = [])
    {
        $this->class = get_class($this);
        parent::__construct($data);
        $this->_init();
    }

    /**
     * @return void
     */
    public function _init()
    {
        $this->collectionClass = AbstractCollection::class;
        $this->resourceModelClass = AbstractResourceModel::class;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData(
            $this->getData('primary')
        );
    }

    /**
     * @return AbstractResourceModel|null
     */
    public function getResourceModel()
    {
        if (null == $this->resourceModel) {
            $this->resourceModel = new $this->resourceModelClass(
                [
                    'table' => $this->table,
                    'primary' => $this->primary
                ]
            );
        }
        return $this->resourceModel;
    }

    /**
     * @return AbstractCollection
     */
    public function getCollection()
    {
        if (null == $this->collection) {
            $this->collection = new $this->collectionClass(
                [
                    'table' => $this->table,
                    'primary' => $this->primary,
                    'model_class' => $this->class
                ]
            );
        }
        return $this->collection;
    }

    /**
     * @return array|bool|\mysqli_result
     * @throws \Exception
     */
    public function save()
    {
        return $this->getResourceModel()->save($this);
    }

    /**
     * @param $id
     * @return false|mixed|object|\stdClass|AbstractModel|null
     * @throws \Exception
     */
    public function load($id)
    {
        $query = $this->dbConnector->query(
            sprintf('select * from %s where %s = %s LIMIT 1', $this->table, $this->primary, $id)
        );
        $instance = mysqli_fetch_object($query);
        if (!$instance) {
            throw new NoSuchIdException('No found');
        }
        return new $this->class((array)$instance);
    }

//    /**
//     * @return array
//     */
//    public function __debugInfo()
//    {
//        $vars = get_object_vars($this);
//        foreach ($vars as $prop => $value) {
//            try {
//                $rp = new \ReflectionProperty(__CLASS__, $prop);
//                if ($rp->isPrivate() || $rp->isProtected()) {
//                    unset($vars[$prop]);
//                }
//            } catch (\ReflectionException $e) {
//            }
//        }
//        return $vars;
//    }
}
