<?php

namespace Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Model\User;
use Model\UserSession;
use Model\UserSessionPeer;
use Model\UserSessionQuery;

/**
 * Base class that represents a query for the 'user_session' table.
 *
 *
 *
 * @method UserSessionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method UserSessionQuery orderByUserid($order = Criteria::ASC) Order by the userId column
 * @method UserSessionQuery orderBySesskey($order = Criteria::ASC) Order by the sesskey column
 * @method UserSessionQuery orderByExpiredat($order = Criteria::ASC) Order by the expiredAt column
 *
 * @method UserSessionQuery groupById() Group by the id column
 * @method UserSessionQuery groupByUserid() Group by the userId column
 * @method UserSessionQuery groupBySesskey() Group by the sesskey column
 * @method UserSessionQuery groupByExpiredat() Group by the expiredAt column
 *
 * @method UserSessionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UserSessionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UserSessionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method UserSessionQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method UserSessionQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method UserSessionQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method UserSession findOne(PropelPDO $con = null) Return the first UserSession matching the query
 * @method UserSession findOneOrCreate(PropelPDO $con = null) Return the first UserSession matching the query, or a new UserSession object populated from the query conditions when no match is found
 *
 * @method UserSession findOneByUserid(int $userId) Return the first UserSession filtered by the userId column
 * @method UserSession findOneBySesskey(string $sesskey) Return the first UserSession filtered by the sesskey column
 * @method UserSession findOneByExpiredat(string $expiredAt) Return the first UserSession filtered by the expiredAt column
 *
 * @method array findById(int $id) Return UserSession objects filtered by the id column
 * @method array findByUserid(int $userId) Return UserSession objects filtered by the userId column
 * @method array findBySesskey(string $sesskey) Return UserSession objects filtered by the sesskey column
 * @method array findByExpiredat(string $expiredAt) Return UserSession objects filtered by the expiredAt column
 *
 * @package    propel.generator.Model.om
 */
abstract class BaseUserSessionQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUserSessionQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'artcms', $modelName = 'Model\\UserSession', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UserSessionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   UserSessionQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UserSessionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UserSessionQuery) {
            return $criteria;
        }
        $query = new UserSessionQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   UserSession|UserSession[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserSessionPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UserSessionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 UserSession A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 UserSession A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `userId`, `sesskey`, `expiredAt` FROM `user_session` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new UserSession();
            $obj->hydrate($row);
            UserSessionPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return UserSession|UserSession[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|UserSession[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return UserSessionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserSessionPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UserSessionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserSessionPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserSessionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UserSessionPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UserSessionPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSessionPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the userId column
     *
     * Example usage:
     * <code>
     * $query->filterByUserid(1234); // WHERE userId = 1234
     * $query->filterByUserid(array(12, 34)); // WHERE userId IN (12, 34)
     * $query->filterByUserid(array('min' => 12)); // WHERE userId >= 12
     * $query->filterByUserid(array('max' => 12)); // WHERE userId <= 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserSessionQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(UserSessionPeer::USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(UserSessionPeer::USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSessionPeer::USERID, $userid, $comparison);
    }

    /**
     * Filter the query on the sesskey column
     *
     * Example usage:
     * <code>
     * $query->filterBySesskey('fooValue');   // WHERE sesskey = 'fooValue'
     * $query->filterBySesskey('%fooValue%'); // WHERE sesskey LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sesskey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserSessionQuery The current query, for fluid interface
     */
    public function filterBySesskey($sesskey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sesskey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sesskey)) {
                $sesskey = str_replace('*', '%', $sesskey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserSessionPeer::SESSKEY, $sesskey, $comparison);
    }

    /**
     * Filter the query on the expiredAt column
     *
     * Example usage:
     * <code>
     * $query->filterByExpiredat('2011-03-14'); // WHERE expiredAt = '2011-03-14'
     * $query->filterByExpiredat('now'); // WHERE expiredAt = '2011-03-14'
     * $query->filterByExpiredat(array('max' => 'yesterday')); // WHERE expiredAt > '2011-03-13'
     * </code>
     *
     * @param     mixed $expiredat The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserSessionQuery The current query, for fluid interface
     */
    public function filterByExpiredat($expiredat = null, $comparison = null)
    {
        if (is_array($expiredat)) {
            $useMinMax = false;
            if (isset($expiredat['min'])) {
                $this->addUsingAlias(UserSessionPeer::EXPIREDAT, $expiredat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expiredat['max'])) {
                $this->addUsingAlias(UserSessionPeer::EXPIREDAT, $expiredat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSessionPeer::EXPIREDAT, $expiredat, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserSessionQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(UserSessionPeer::USERID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserSessionPeer::USERID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserSessionQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Model\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   UserSession $userSession Object to remove from the list of results
     *
     * @return UserSessionQuery The current query, for fluid interface
     */
    public function prune($userSession = null)
    {
        if ($userSession) {
            $this->addUsingAlias(UserSessionPeer::ID, $userSession->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
