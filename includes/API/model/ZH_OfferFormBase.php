<?php

namespace Develtio\ZonesHewalex\API\model;

if (!defined('ABSPATH')) {
    die;
}

/**
 * Class ZH_OfferForm
 */
class ZH_OfferFormBase
{
    protected $offerForm;
    protected $formGroups;
    protected $formModels;
    protected $slcModels;

    public function render($url)
    {
        ob_start();
            include($url);
            $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    public function renderPCWB($url, $report)
    {
        ob_start();
            $offerReport = $report;
            include($url);
            $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    public static function getDatasetItem(array $offer, string $path, string $id)
    {
        $dataset = data_get($offer, $path, []);
        $item = array_first($dataset, function ($item) use ($id) {
            return $item['id'] == $id;
        });
        return $item;
    }

    public static function getDatasetItemValue(array $offer, string $path, string $id)
    {
        $item = self::getDatasetItem($offer, $path, $id);
        return $item['value'] ?? $item['selectedId'] ?? null;
    }

    public function setExactOffer($offerForm)
    {
        $this->offerForm = $offerForm;
        return $this;
    }

    public function getExactFormWithModels($optionsArr, $contactArr, $params)
    {
        return $this->getOfferFormModelsWithResults($this->formModels, array_merge($optionsArr, $contactArr), $params);
    }

    public function getExactOfferSlcResults($data, $params = [])
    {
        return $this->getOfferFormModelsWithResults($this->slcModels, $data, $params);
    }

    private function getOfferFormModelsWithResults($models, $formData, $params = [])
    {
        /* sort models */
        uasort($models, function ($x, $y) {
            return ($x['order'] ?? 1) < ($y['order'] ?? 1) ? -1 : 1;
        });

        /* assign form values to models */
        foreach ($formData as $formOption) {
            if (!($models[$formOption['id']] ?? null)) {
                continue;
            }

            if ($formOption['value'] ?? null) {
                $models[$formOption['id']]['value'] = $formOption['value'];
            }

            $type = $models[$formOption['id']]['type'] ?? '';
            if (($formOption['value'] ?? null) && $type === 'checkbox') {
                $models[$formOption['id']]['displayValue'] = $formOption['value'] == '1' ? 'Tak' : 'Nie';
            }
            if ($formOption['selectedId'] ?? null) {
                $selectedId = $formOption['selectedId'];
                $models[$formOption['id']]['selectedId'] = $selectedId;
                $models[$formOption['id']]['selected'] = array_first($models[$formOption['id']]['options'], function ($item) use ($selectedId) {
                    return $item['id'] === $selectedId;
                });
            }
        }

        /* unset models without value */
        $exactModels = array_filter($models, function ($model) {
            return isset($model['value']) || isset($model['selectedId']);
        });

        /* group models by defined groups */
        if ($params['grouped'] ?? false) {
            $groups = $this->formGroups;
            /* sort groups */
            uasort($groups, function ($x, $y) {
                if(isset($x['order']) && isset($y['order']))
                {
                    return $x['order'] < $y['order'] ? -1 : 1;
                }
            });


            /* assign models to groups */
            $group = $groups['form'];
            $this->initGroup($group, $exactModels, $groups);

            return $group;
        }

        return $exactModels;
    }

    protected function initGroup(&$group, $models, $groups)
    {
        if ($group['subgroupsIds'] ?? null) {
            $group['groups'] = [];
            foreach ($group['subgroupsIds'] as $subgroupId) {
                $this->initGroup($groups[$subgroupId], $models, $groups);
                $group['groups'][] = $groups[$subgroupId];
            }
            return;
        }

        $group['models'] = $this->getGroupModels($group, $models);
    }

    protected function getGroupModels($group, $models)
    {
        return array_filter($models,
            function ($model) use ($group) {
                return in_array($group['id'], $model['group'] ?? []);
            }
        );
    }
}