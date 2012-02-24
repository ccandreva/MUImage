<?php
/**
 * MUImage.
 *
 * @copyright Michael Ueberschaer
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package MUImage
 * @author Michael Ueberschaer <kontakt@webdesign-in-bremen.com>.
 * @link http://www.webdesign-in-bremen.com
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Thu Feb 23 22:43:24 CET 2012.
 */

/**
 * Selection api base class
 */
class MUImage_Api_Base_Selection extends Zikula_AbstractApi
{
    /**
     * Get list of identifier fields for a given object type.
     *
     * @param string  $args['ot'] The object type to be treated (optional)
     *
     * @return array List of identifier field names.
     */
    public function getIdFields($args)
    {
        $objectType = $this->determineObjectType($args, 'getIdFields');
        $entityClass = 'MUImage_Entity_' . ucfirst($objectType);
        $objectTemp = new $entityClass();
        $idFields = $objectTemp->get_idFields();
        return $idFields;
    }

    /**
     * Select a single entity.
     *
     * @param string  $args['ot']       The object type to retrieve (optional)
     * @param mixed   $args['id']       The id (or array of ids) to use to retrieve the object (default=null).
     * @param boolean $args['useJoins'] Whether to include joining related objects (optional) (default=true).
     *
     * @return mixed Desired entity object or null.
     */
    public function getEntity($args)
    {
        if (!isset($args['id'])) {
            return LogUtil::registerArgsError();
        }
        $objectType = $this->determineObjectType($args, 'getEntity');
        $repository = $this->getRepository($objectType);

        $idValues = $args['id'];
        $useJoins = isset($args['useJoins']) ? ((bool)$args['useJoins']) : true;

        $idFields = $this->getIdFields(array('ot' => $objectType));

        $entity = $repository->selectById($idValues, $useJoins);

        return $entity;
    }

    /**
     * Select a list of entities by different criteria.
     *
     * @param string  $args['ot']       The object type to retrieve (optional)
     * @param string  $args['where']    The where clause to use when retrieving the collection (optional) (default='').
     * @param string  $args['orderBy']  The order-by clause to use when retrieving the collection (optional) (default='').
     * @param boolean $args['useJoins'] Whether to include joining related objects (optional) (default=true).
     *
     * @return Array with retrieved collection and amount of total records affected by this query.
     */
    public function getEntities($args)
    {
        $objectType = $this->determineObjectType($args, 'getEntities');
        $repository = $this->getRepository($objectType);

        $where = isset($args['where']) ? $args['where'] : '';
        $orderBy = isset($args['orderBy']) ? $args['orderBy'] : '';
        $useJoins = isset($args['useJoins']) ? ((bool)$args['useJoins']) : true;

        return $repository->selectWhere($where, $orderBy, $useJoins);
    }

    /**
     * Select a list of entities by different criteria.
     *
     * @param string  $args['ot']             The object type to retrieve (optional)
     * @param string  $args['where']          The where clause to use when retrieving the collection (optional) (default='').
     * @param string  $args['orderBy']        The order-by clause to use when retrieving the collection (optional) (default='').
     * @param integer $args['currentPage']    Where to start selection
     * @param integer $args['resultsPerPage'] Amount of items to select
     * @param boolean $args['useJoins']       Whether to include joining related objects (optional) (default=true).
     *
     * @return Array with retrieved collection and amount of total records affected by this query.
     */
    public function getEntitiesPaginated($args)
    {
        $objectType = $this->determineObjectType($args, 'getEntitiesPaginated');
        $repository = $this->getRepository($objectType);

        $where = isset($args['where']) ? $args['where'] : '';
        $orderBy = isset($args['orderBy']) ? $args['orderBy'] : '';
        $currentPage = isset($args['currentPage']) ? $args['currentPage'] : 1;
        $resultsPerPage = isset($args['resultsPerPage']) ? $args['resultsPerPage'] : 25;
        $useJoins = isset($args['useJoins']) ? ((bool)$args['useJoins']) : true;

        if ($orderBy == 'RAND()') {
            // random ordering is disabled for now, see https://github.com/Guite/MostGenerator/issues/143
            $orderBy = $repository->getDefaultSortingField();
        }

        return $repository->selectWherePaginated($where, $orderBy, $currentPage, $resultsPerPage, $useJoins);
    }

    /**
     * Select tree of given object type.
     *
     * @param string $args['ot'] The object type to retrieve (optional)
     * @param string $methodName Name of calling method
     */
    protected function determineObjectType($args, $methodName = '')
    {
        $objectType = isset($args['ot']) ? $args['ot'] : '';
        $utilArgs = array('api' => 'selection', 'action' => $methodName);
        if (!in_array($objectType, MUImage_Util_Controller::getObjectTypes('api', $utilArgs))) {
            $objectType = MUImage_Util_Controller::getDefaultObjectType('api', $utilArgs);
        }
        return $objectType;
    }

    /**
     * Return repository instance for a certain object type.
     *
     * @param string $objectType The desired object type.
     *
     * @return mixed Repository class instance or null.
     */
    protected function getRepository($objectType = '')
    {
        if (empty($objectType)) {
            return LogUtil::registerArgsError();
        }
        return $this->entityManager->getRepository('MUImage_Entity_' . ucfirst($objectType));
    }

}
