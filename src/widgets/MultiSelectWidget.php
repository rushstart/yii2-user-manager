<?php

namespace rushstart\user\widgets;

use Yii;
use yii\bootstrap\Html;
use rushstart\user\assets\UserAsset;

class MultiSelectWidget extends \yii\widgets\InputWidget
{

    public $pluginName = 'multiSelect';
    public $search = false;
    public $data;

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run();
        echo Html::activeDropDownList($this->model, $this->attribute, $this->data, ['multiple' => 'true']);
        $this->registerAssets();
    }

    public function registerAssets()
    {
        $view = $this->getView();
        UserAsset::register($view);
        if ($this->search) {
            $script = '$("#' . $this->options['id'] . '").multiSelect({
                        selectableHeader: \'<input type="text" class="form-control ms-filter" autocomplete="off" placeholder="Поиск ...">\',
                        selectionHeader: \'<input type="text" class="form-control ms-filter" autocomplete="off" placeholder="Поиск ...">\',
                        afterInit: function (ms) {
                            var that = this,
                                    $selectableSearch = that.$selectableUl.prev(),
                                    $selectionSearch = that.$selectionUl.prev(),
                                    selectableSearchString = "#" + that.$container.attr("id") + " .ms-elem-selectable:not(.ms-selected)",
                                    selectionSearchString = "#" + that.$container.attr("id") + " .ms-elem-selection.ms-selected";

                            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                                    .on("keydown", function (e) {
                                        if (e.which === 40) {
                                            that.$selectableUl.focus();
                                            return false;
                                        }
                                    });

                            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                                    .on("keydown", function (e) {
                                        if (e.which == 40) {
                                            that.$selectionUl.focus();
                                            return false;
                                        }
                                    });
                        },
                        afterSelect: function () {
                            this.qs1.cache();
                            this.qs2.cache();
                        },
                        afterDeselect: function () {
                            this.qs1.cache();
                            this.qs2.cache();
                        }
        });';
        } else {
            $script = '$("#' . $this->options['id'] . '").multiSelect();';
        }
        $this->getView()->registerJs($script);
    }

}
