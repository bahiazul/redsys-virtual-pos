<?php
/**
 * Redsys Virtual POS
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */

namespace nkm\RedsysVirtualPos\Message;

use nkm\RedsysVirtualPos\Environment\EnvironmentInterface;
use nkm\RedsysVirtualPos\Util\Helper;
use Psr\Log\LoggerInterface;

/**
 * A message is a part of a communication for a monetary operation
 * (i.e. a request or a reponse).
 *
 * @package    Redsys Virtual POS
 * @author     Javier Zapata <javierzapata82@gmail.com>
 * @copyright  2021 Javier Zapata <javierzapata82@gmail.com>
 * @license    https://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       https://github.com/jzfgo/redsys-virtual-pos
 */
abstract class AbstractMessage implements MessageInterface
{
    const FIELD_BASE_NAMESPACE = '\nkm\RedsysVirtualPos\Field\\';

    /**
     * The environment object.
     *
     * @var \nkm\RedsysVirtualPos\Environment\EnvironmentInterface
     */
    protected $environment;

    /**
     * The logger implementation.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * The prefix for the names of the sent/received params.
     *
     * @var string
     */
    protected $fieldPrefix;

    /**
     * The name of all the fields that can go in a message.
     * Its values should be names of classes extending from AbstractField.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * All the Field objects indexed by its class shortname.
     *
     * @var array
     */
    protected $params = [];

    /**
     * Indicates if this message is valid after its been validated.
     *
     * @var boolean
     */
    protected $isValid;

    /**
     * All the validation error messages after a failed validation.
     *
     * @var array
     */
    protected $validationErrors;

    /**
     * Create a new message instance.
     *
     * @param EnvironmentInterface $environment The environment to set
     * @param LoggerInterface|null $logger      An optional logger
     */
    public function __construct(EnvironmentInterface $environment, LoggerInterface $logger = null)
    {
        $this->environment = $environment;

        $logger && $this->setLogger($logger);
    }

    /**
     * Sets a logger implementation.
     *
     * @param Psr\Log\LoggerInterface $logger The logger implementation
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
     * Get the name of all the fields that can go in a message.
     *
     * @return array The field names
     */
    protected function getFields()
    {
        return (array) $this->fields;
    }

    /**
     * Set multiple message parameters (fields and its values)
     *
     * @param array $params     Field values indexed by its class shortname
     * @return MessageInterface
     */
    public function setParams(array $params)
    {
        foreach ($params as $paramName => $paramValue) {
            $this->setParam($paramName, $paramValue);
        }

        return $this;
    }

    /**
     * Get the values of all of this message parameters
     *
     * @return array    Field objects indexed by its class shortname
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
     * Set the value of a specific parameter.
     *
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
        } catch (\Exception $e) {
            throw new \RuntimeException("Class `{$fieldClass}` not found.");
        }

        return $this;
    }

    /**
     * Get the value of a specific parameter.
     *
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
     * Returns the result of this message validation,
     * performing it if necessary.
     *
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
     * Returns all the error messages generated after a failed validation,
     * performing it if necessary.
     *
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
     * Validates all the params of the action.
     *
     * @return MessageInterface
     */
    abstract protected function validate();

    /**
     * Get the fully qualified name of a field's class.
     *
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
