<?php
namespace app\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * PaginationCounters displays the current position as well as the total number of entries.
 * If the number of records is placed on 1 page, simply output the number of records.
 *
 * PaginationCounters works with a [[Pagination]] object which specifies the total number
 * of pages and the current page number.
 *
 * Note that PaginationCounters only generates text.
 *
 * @author Konstantin Zosimenko <pivasikost@gmail.com>
 * @since 2.0
 */
class PaginationCounters extends Widget
{
    /**
     * @var Pagination the pagination object that this counters are associated with.
     * You must set this property in order to make PaginationCounters work.
     */
    public $pagination;
    /**
     * @var array HTML attributes for counters container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'pagination-counters'];

    /**
     * Initializes counters.
     */
    public function init()
    {
        parent::init();

        if ($this->pagination === null) {
            throw new InvalidConfigException('The "pagination" property must be set.');
        }
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated counters.
     */
    public function run()
    {
        $pagination = $this->pagination;
        $pageCount = $pagination->getPageCount();
        $page = $pagination->getPage();
        if ($pageCount > 1) {
            $text = $page * $pagination->pageSize + 1;
            $text .= ' ' . Yii::t('app', 'to') . ' ';
            $to = $page * $pagination->pageSize + $pagination->pageSize;
            $text .= ($to < $pagination->totalCount) ? $to : $pagination->totalCount;
            $text .= ' ' . Yii::t('app', 'of') . ' ';
            $text .= $pagination->totalCount;
        } else {
            $text = $pagination->totalCount;
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        return Html::tag($tag, $text, $options);
    }
}
