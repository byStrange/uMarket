<?php
namespace app\components;

class Utils
{
    public static function preSelectOptions($dataIds, $existingRelation)
    {
        if (empty($dataIds) || empty($existingRelation)) {
            return [];
        }
        $options = [];
        $existingIds = array_column($existingRelation, "id");
        foreach ($dataIds as $id) {
            $options[$id] = [
                "selected" => in_array($id, $existingIds),
            ];
        }
        return $options;
    }
} ?>

