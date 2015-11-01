<?php
/**
 * Redsys Virtual POS
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */

namespace nkm\RedsysVirtualPos\Message;

use nkm\RedsysVirtualPos\Environment\EnvironmentInterface;
use nkm\RedsysVirtualPos\Util\Helper;
use Psr\Log\LoggerInterface;

/**
 * Part of a communication for a monetary operation (a request or a reponse)
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2014 Javier Zapata <javierzapata82@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/nkm/redsys-virtual-pos
 */
abstract class AbstractMessage implements MessageInterface
{
    const FIELD_BASE_NAMESPACE = '\nkm\RedsysVirtualPos\Field\\';

    /**
     * Environment object
     *
     * @var object
     */
    protected $environment;

    /**
     * Logger object
     *
     * @var object
     */
    private $logger;

    /**
     * The prefix for the names of the sent/received params
     *
     * @var string
     */
    protected $fieldPrefix;

    /**
     * All the fields that can go in a request/response
     *
     * The array's keys should be underscore strings
     * and its values be names of classes extending
     * from AbstractField
     *
     * @var array
     */
    protected $fields;

    /**
     * Holds all the field objects
     * @var array
     */
    protected $params = [];

    /**
     * @var boolean
     */
    protected $isValid;

    /**
     * @var array
     */
    protected $ValidationErrors;

    /**
     * @param EnvironmentInterface  $environment    The environment to set
     */
    public function __construct(EnvironmentInterface $environment, LoggerInterface $logger = null)
    {
        $this->environment = $environment;

        $logger && $this->setLogger($logger);
    }

    /**
     * [setLogger description]
     *
     * @param Psr\Log\LoggerInterface $logger [description]
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Adds a log record at an arbitrary level.
     *
     * @param  mixed   $level   The log level
     * @param  string  $message The log message
     * @param  array   $context The log context
     * @return Boolean Whether the record has been processed
     */
    public function log($level, $message, array $context = [])
    {
        if ($this->logger) {
            return $this->logger->log($level, $message, $context);
        }

        return false;
    }

    /**
     * @return array All the fields that can go in an action
     */
    protected function getFields()
    {
        return (array) $this->fields;
    }

    /**
     * @param array $params     Params and values
     * @return MessageInterface
     */
    public function setParams(Array $params)
    {
        foreach ($params as $paramName => $paramValue) {
            $this->setParam($paramName, $paramValue);
        }

        return $this;
    }

    /**
     * @return array The actions's parameter objects
     */
    public function getParams()
    {
        $params = [];
        $fields = $this->getFields();
        foreach ($fields as $fieldName) {
            $params[$fieldName] = $this->getParam($fieldName);
        }

        return $params;
    }

    /**
     * @param  string   $fieldName  The field's name
     * @param  mixed    $value      The field's value
     * @return MessageInterface
     */
    protected function setParam($fieldName, $value)
    {
        $this->isValid = null;
        $this->validationErrors = null;


        try {
            $fieldClass = $this->resolveFieldClassName($fieldName);
            $rc = new \ReflectionClass($fieldClass);
            $shortName = $rc->getShortName();

            $this->params[$shortName] = $rc->newInstanceArgs([$value]);
        } catch (Exception $e) {
            throw new \RuntimeException("Class `{$fieldClass}` not found.");
        }

        return $this;
    }

    /**
     * @param string $fieldName The field's name
     * @return FieldInterface
     */
    protected function getParam($fieldName)
    {
        $fieldClass = $this->resolveFieldClassName($fieldName);
        $rc = new \ReflectionClass($fieldClass);
        $shortName = $rc->getShortName();

        if (!isset($this->params[$shortName]) || !is_object($this->params[$shortName])) {
            $this->params[$shortName] = $rc->newInstance();
        }

        return $this->params[$shortName];
    }

    /**
     * Returns the result of the field's validation
     * performing it if necessary
     * @return boolean
     */
    public function getIsValid()
    {
        if (is_null($this->isValid)) {
            $this->validate();
        }

        return $this->isValid;
    }

    /**
     * Returns all the errors found on the field's validation
     * performing it if necessary
     * @return array List of validation error messages
     */
    public function getValidationErrors()
    {
        if (is_null($this->validationErrors)) {
            $this->validate();
        }

        return $this->validationErrors;
    }

    /**
     * Validates all the params of the action
     * @return MessageInterface
     */
    abstract protected function validate();

    /**
     * Get the fully qualified name of a field's class
     * @param  string $fieldName The field name
     * @return string            The field class name
     */
    protected function resolveFieldClassName($fieldName)
    {
        // The field name should match its class name
        $fieldPrefix = Helper::stringify($this->fieldPrefix);
        $className = str_replace($fieldPrefix, '', $fieldName);

        // If is not a fully qualified class name
        // append our own base namespace
        if ($className[0] !== '\\') {
            return self::FIELD_BASE_NAMESPACE.$className;
        }

        return $className;
    }
}
