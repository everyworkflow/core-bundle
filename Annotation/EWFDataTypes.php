<?php
namespace EveryWorkflow\CoreBundle\Annotation;

/**
 * @Annotation
 */
class EWFDataTypes {
    /**
     * Name of DataTypes
     */
    public $type;

    /**
     * Set Default data
     */
    public $default;

    /**
     * @return int
     */
    public $minLength;

    /**
     * @return int
     */
    public $maxLength;

    /**
     * @return boolean
     *
     */
    public $required;

    /**
     * name of filed that need to get saved in mongodb
     *
     */
    public $mongofield;

    /**
     * @return boolean
     */
    public $readonly;

    /**
     * @return boolean
     */
    public $sortOrder;

    /**
     *
     */
    public $front_type;
}