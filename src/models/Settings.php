<?php
/**
 * Widen plugin for Craft CMS 3.x
 *
 * Widen DAM Field Type for  Craft 3
 *
 * @link      https://union.co
 * @copyright Copyright (c) 2020 UNION
 */

namespace unionco\widen\models;

use unionco\widen\Widen;

use Craft;
use craft\base\Model;

/**
 * @author    UNION
 * @package   Widen
 * @since     0.1.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $authToken = '';

    /**
     * @var string
     */
    public $baseUrl = '';

    // Public Methods
    // =========================================================================

    public function getClientSettings(): array
    {
        return [
            'authToken' => \Craft::parseEnv($this->authToken),
            'baseUrl' => \Craft::parseEnv($this->baseUrl),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['authToken', 'string'],
            ['authToken', 'default', 'value' => ''],
            ['baseUrl', 'string'],
            ['baseUrl', 'default', 'value' => ''],
        ];
    }
}
