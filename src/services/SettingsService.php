<?php

namespace unionco\querybuilder\services;

use craft\db\Query;
use yii\base\Component;
use craft\records\Section;
use craft\records\CategoryGroup;

class SettingsService extends Component
{
    public function getCategoryGroups()
    {
        $groups = (new Query())
            ->from(CategoryGroup::tableName())
        // CategoryGroup::find()
            ->select(['id', 'name', 'handle']);
        return $groups->all();
    }

    public function getChannels()
    {
        $channels = (new Query())
            ->from(Section::tableName())
            ->where(['=', 'type', 'channel'])
            ->select(['id', 'name', 'handle'])
            ->all();
        return $channels;
    }

    public function getStructures()
    {
        $channels = (new Query())
            ->from(Section::tableName())
            ->where(['=', 'type', 'structure'])
            ->select(['id', 'name', 'handle'])
            ->all();
        return $channels;
    }
}
