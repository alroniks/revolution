<?php

namespace MODX\Revolution;

use MODX\Revolution\Sources\modAccessMediaSource;
use xPDO\Om\xPDOSimpleObject;
use xPDO\xPDO;

/**
 * Represents a person or system that will access modX.
 *
 * {@internal Implement a derivative to define the behavior and attributes of
 * an actual user or system that is intended to access modX or a modX service.}
 */
abstract class modPrincipal extends xPDOSimpleObject
{
    /** @var modX|xPDO $xpdo */
    public $xpdo;

    /** A collection of key-value pairs identifying policy authority. */
    protected $attributes = [];

    /**
     * Load attributes of the principal that define access to secured objects.
     *
     * {@internal Implement this function in derivatives to control how your
     * user class uses the MODX ABAC (Attribute-Based Access Control) security
     * model}
     *
     * @abstract
     *
     * @param array   $targets  The target modAccess classes to load attributes from.
     * @param string  $context Context to check within, defaults to current  context.
     * @param bool    $reload  If true, the attributes will be reloaded and the session updated.
     */
    abstract public function loadAttributes(array $targets, $context = '', $reload = false);

    /**
     * Get the attributes for this principal.
     *
     * @param array   $targets An array of target modAccess classes to load.
     * @param string  $context The context to check within. Defaults to active context.
     * @param bool    $reload  If true, the attributes will be reloaded and the session updated.
     *
     * @return array An array of attributes on the principal
     */
    public function getAttributes($targets = [], $context = '', $reload = false)
    {
        echo modAccessContext::class;

        $def = [
            modAccessContext::class,
            modAccessResourceGroup::class,
            modAccessCategory::class,
            modAccessMediaSource::class,
            modAccessNamespace::class
        ];

        print_r($def);
        die();

        $context = !empty($context) ? $context : $this->xpdo->context->get('key');
        if (!is_array($targets) || empty($targets)) {
            $targets = explode(',', $this->xpdo->getOption('principal_targets', null,
                'modAccessContext,modAccessResourceGroup,modAccessCategory,sources.modAccessMediaSource,modAccessNamespace'));
            array_walk($targets, 'trim');
        }

        $this->loadAttributes($targets, $context, $reload);

        return $this->attributes[$context];
    }
}
