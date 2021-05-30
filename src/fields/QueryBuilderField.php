<?php

namespace unionco\querybuilder\fields;

use yii\db\Schema;
use craft\base\Field;
use craft\helpers\Json;
use craft\base\ElementInterface;
use craft\base\PreviewableFieldInterface;
use unionco\querybuilder\QueryBuilderPlugin;
use unionco\querybuilder\assetbundles\querybuilder\QueryBuilderAsset;

class QueryBuilderField extends Field implements PreviewableFieldInterface
{
    private $service;
    public function init()
    {
        parent::init();
        $this->service = QueryBuilderPlugin::$plugin->settings;
    }
    public static function displayName(): string
    {
        return \Craft::t('app', 'QueryBuilder');
    }

    public function getColumnContentType(): string
    {
        return Schema::TYPE_TEXT;
    }

    public static function hasContentColumn(): bool
    {
        return true;
    }

    public function normalizeValue($value, ElementInterface $element = null)
    {
        if (\is_string($value)) {
            $value = Json::decodeIfJson($value);
        }

        return $value;
    }

    public function serializeValue($value, ElementInterface $element = null)
    {
        $serialized = [];
        $serialized = $value;
        return parent::serializeValue($serialized, $element);
    }

    public function getSettingsHtml()
    {
        $view = \Craft::$app->getView();
        $view->registerAssetBundle(QueryBuilderAsset::class);

        // $categoryGroups = $this->service->getCategoryGroups();

        return $view->renderTemplate(
            'query-builder-field/_field/settings',
            [
                'field' => $this,
                'categoryGroups' => $this->service->getCategoryGroups(),
                'channels' => $this->service->getChannels(),
                'structures' => $this->service->getStructures(),
            ]
        );
    }

    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $view = \Craft::$app->getView();
        $view->registerAssetBundle(QueryBuilderAsset::class);
        $id = $view->formatInputId($this->handle);
        $namespaceId = $view->namespaceInputId($id);

        $jsVariables = Json::encode([
            'id' => $namespaceId,
            'name' => $this->handle,
        ]);
        $view->registerJs('new App(' . $jsVariables . ');');

        return $view->renderTemplate(
            'querybuilder/_field/input',
            [
                'id' => $id,
                'name' => $this->handle,
                'field' => $this,
                'element' => $element,
            ]
        );
    }
}
