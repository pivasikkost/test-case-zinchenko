<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\CustomFormatConverter;
use yii\widgets\LinkPager;
use app\widgets\PaginationCounters;

/* @var $this yii\web\View */
/* @var $title' string */
/* @var $orders' array */
/* @var $pagination' yii\data\Pagination; */
/* @var $modes' => array */
/* @var $statuses' => array */
/* @var $searchTypes' => array */
/* @var $orderLabels' => array */
/* @var $services' => array */
/* @var $params' => array */

$this->title = $title;
?>
<ul class="nav nav-tabs p-b">
    <?php $statuses = ['' => 'All'] + $statuses ?>
    <?php foreach ($statuses as $key => $status): ?>
        <li class="<?=
                (isset($params['status']) && ctype_digit($params['status']) && ($params['status'] == $key))
                || ($key === '' && (!isset($params['status']) || $params['status'] === ''))
                ? 'active'
                : ''
        ?>">
            <a href="<?= Url::current([
                            'status' => $key,
                            'mode' => null,
                            'service_id' => null,
                            'page' => null
                         ], true)
            ?>">
                <?= Yii::t('app', $status) ?>
            </a>
        </li>
    <?php endforeach; ?>
    <li class="pull-right custom-search">
        <form class="form-inline" method="get">
            <input hidden type="text" name="status" value="<?= isset($params['status']) ? $params['status'] : '' ?>" />
            <div class="input-group">
                <input type="text"
                       name="search"
                       class="form-control"
                       value="<?= isset($params['search']) ? $params['search'] : '' ?>"
                       placeholder="<?= Yii::t('app', 'Search orders') ?>"
                >
                <span class="input-group-btn search-select-wrap">
                    <select class="form-control search-select" name="search-type">
                        <?php foreach ($searchTypes as $key => $type): ?>
                            <option value="$key"
                                    <?= (isset($params['search-type']) && $params['search-type'] == $key)
                                        ? 'selected'
                                        : ''
                                    ?>
                            >
                                <?= $orderLabels[$type] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
                </span>
            </div>
        </form>
    </li>
</ul>
<table class="table order-table">
    <thead>
    <tr>
        <th><?= Yii::t('app', 'ID') ?></th>
        <th><?= Yii::t('app', 'User') ?></th>
        <th><?= Yii::t('app', 'Link') ?></th>
        <th><?= Yii::t('app', 'Quantity') ?></th>
        <th class="dropdown-th">
            <div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle"
                        type="button"
                        id="dropdownMenu1"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="true"
                >
                    <?= Yii::t('app', 'Service') ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li class="<?= !isset($params['service_id']) ? 'active' : '' ?>">
                        <a href="<?= Url::current(['service_id' => null, 'page' => null], true) ?>">
                            <?= Yii::t('app', 'All') .'('. $pagination->totalCount .')' ?>
                        </a>
                    </li>
                    <?php foreach ($services as $key => $service): ?>
                        <li class="<?= (isset($params['service_id']) && $params['service_id'] == $key)
                                        ? 'active'
                                        : ''
                        ?>">
                            <a href="<?= Url::current(['service_id' => $key, 'page' => null], true) ?>">
                                <span class="label-id"><?= $service['orders_count'] ?></span>
                                <?= Yii::t('app', $service['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </th>
        <th><?= Yii::t('app', 'Status') ?></th>
        <th class="dropdown-th">
            <div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle"
                        type="button" id="dropdownMenu1"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="true"
                >
                    <?= Yii::t('app', 'Mode') ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li class="<?= !isset($params['mode']) ? 'active' : '' ?>">
                        <a href="<?= Url::current(['mode' => null, 'page' => null], true) ?>">
                            <?= Yii::t('app', 'All') ?>
                        </a>
                    </li>
                    <?php foreach ($modes as $key => $mode): ?>
                        <li class="<?= (isset($params['mode']) && $params['mode'] == $key) ? 'active' : '' ?>">
                            <a href="<?= Url::current(['mode' => $key, 'page' => null], true) ?>">
                                <?= Yii::t('app', $mode) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </th>
        <th><?= Yii::t('app', 'Created') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= $order['user'] ?></td>
            <td class="link"><?= $order['link'] ?></td>
            <td><?= $order['quantity'] ?></td>
            <td class="service">
                <span class="label-id"><?= $services[$order['service_id']]['orders_count'] ?></span>
                <?= Yii::t('app', $services[$order['service_id']]['name']) ?>
            </td>
            <td><?= Yii::t('app', $order['status']) ?></td>
            <td><?= Yii::t('app', $order['mode']) ?></td>
            <td>
                <span class="nowrap"><?= CustomFormatConverter::getDateText($order['created_at']) ?></span>
                <span class="nowrap"><?= CustomFormatConverter::getTimeText($order['created_at']) ?></span>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="row">
    <div class="col-sm-8">
          <nav>
              <?= LinkPager::widget(['pagination' => $pagination]) ?>
          </nav>
    </div>
    <?= PaginationCounters::widget([
            'pagination' => $pagination,
            'options' => ['class' => 'col-sm-4 pagination-counters']
    ]) ?>
    <div class="col-sm-4 push-sm-8 text-right">
        <?= Html::a(
                Yii::t('app', 'Save result'),
                $params + ['export'],
                ['class' => 'link', 'target' => 'blank']
        ) ?>
    </div>
</div>
