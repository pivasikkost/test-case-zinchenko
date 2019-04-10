<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\models\Orders;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\orders\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
?>
<ul class="nav nav-tabs p-b">
    <li class="<?= !isset($params['status']) || $params['status'] == '' ? 'active' : '' ?>">
        <a href="<?= Url::current(['status' => null, 'mode' => null, 'service_id' => null, 'page' => null], true) ?>"><?= Yii::t('app', 'All orders') ?></a>
    </li>
    <?php foreach ($statuses as $key => $status): ?>
        <li class="<?= (isset($params['status']) && $params['status'] != '' && $params['status'] == $key) ? 'active' : '' ?>">
            <a href="<?= Url::current(['status' => $key, 'mode' => null, 'service_id' => null, 'page' => null], true) ?>">
                <?= Yii::t('app', $status) ?>
            </a>
        </li>
    <?php endforeach; ?>
    <li class="pull-right custom-search">
      <form class="form-inline" method="get">
        <input hidden type="text" name="r" value="orders">
        <input hidden type="text" name="status" value="<?= isset($params['status']) ? $params['status'] : '' ?>" />
        <div class="input-group">
          <input type="text" name="search" class="form-control" value="<?= isset($params['search']) ? $params['search'] : '' ?>" placeholder="Search orders">
          <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
                <?php foreach ($searchTypes as $key => $type): ?>
                    <option value="$key" <?= (isset($params['search-type']) && $params['search-type'] == $key) ? 'selected' : '' ?>>
                        <?= Yii::t('app', $orderLabels[$type]) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
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
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
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
                <li class="<?= (isset($params['service_id']) && $params['service_id'] == $key) ? 'active' : '' ?>">
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
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
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
            <td><?= Yii::t('app', Orders::getStatusText($order['status'])) ?></td>
            <td><?= Yii::t('app', Orders::getModeText($order['mode'])) ?></td>
            <td>
              <span class="nowrap"><?= Orders::getDateText($order['created_at']) ?></span>
              <span class="nowrap"><?= Orders::getTimeText($order['created_at']) ?></span>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <div class="row">
    <div class="col-sm-8">
      <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
    <div class="col-sm-4 pagination-counters">
      <div class="col-sm-12">
      <?php if ($pagination->getPageCount() > 1): ?>
        <?= $pagination->getPage() + 1 ?>
          to
        <?= $pagination->getPageCount() ?>
          of
        <?= $pagination->totalCount ?>
      <?php else: ?>
        <?= $pagination->totalCount ?>
      <?php endif ?>
      </div>
      <div class="col-sm-12">
      <?= Html::a(Yii::t('app', 'Save result'), $params+['export'], ['class' => 'link']) ?>
      </div>
    </div>

  </div>
