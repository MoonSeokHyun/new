<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>
<style>
  .pager-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 24px;
    padding: 16px;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    background: linear-gradient(180deg, #ffffff 0%, #f8faff 100%);
    box-shadow: 0 10px 30px rgba(55, 48, 163, 0.08);
  }

  .pagination > .pk-pagination {
    margin-top: 24px;
  }

  .pk-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    overflow-x: auto;
    padding: 2px 0;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
  }

  .pk-pagination::-webkit-scrollbar {
    display: none;
  }

  .pk-pagination__list {
    list-style: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: max-content;
    min-width: 100%;
    margin: 0;
    padding: 4px;
    white-space: nowrap;
  }

  .pk-pagination__item {
    list-style: none;
    flex: 0 0 auto;
  }

  .pk-pagination__link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    min-height: 44px;
    padding: 0 14px;
    border: 1px solid #c7d2fe;
    border-radius: 999px;
    background: #ffffff;
    color: #3730a3;
    font-size: 14px;
    font-weight: 800;
    line-height: 1;
    white-space: nowrap;
    text-decoration: none;
    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.06);
    transition: background-color 0.16s ease, border-color 0.16s ease, color 0.16s ease, box-shadow 0.16s ease, transform 0.16s ease;
  }

  .pk-pagination__item--nav .pk-pagination__link {
    padding-inline: 16px;
    background: #eef2ff;
  }

  .pk-pagination__link:hover {
    background: #eef2ff;
    border-color: #6366f1;
    color: #4338ca;
    box-shadow: 0 6px 18px rgba(99, 102, 241, 0.16);
    transform: translateY(-1px);
  }

  .pk-pagination__link:focus-visible {
    outline: 3px solid rgba(99, 102, 241, 0.24);
    outline-offset: 2px;
    background: #eef2ff;
    border-color: #6366f1;
    color: #4338ca;
    box-shadow: 0 6px 18px rgba(99, 102, 241, 0.16);
    transform: translateY(-1px);
  }

  .pk-pagination__link--current {
    border-color: #3730a3;
    background: linear-gradient(135deg, #3730a3 0%, #4338ca 100%);
    color: #ffffff;
    box-shadow: 0 12px 24px rgba(55, 48, 163, 0.24);
  }

  .pk-pagination__link--current:hover,
  .pk-pagination__link--current:focus-visible {
    border-color: #3730a3;
    background: linear-gradient(135deg, #3730a3 0%, #4338ca 100%);
    color: #ffffff;
    transform: none;
  }

  @media (max-width: 640px) {
    .pager-wrap {
      padding: 12px 10px;
      border-radius: 18px;
    }

    .pk-pagination__list {
      gap: 6px;
      padding: 2px;
    }

    .pk-pagination__link {
      min-width: 40px;
      min-height: 40px;
      padding: 0 12px;
      font-size: 13px;
    }

    .pk-pagination__item--nav .pk-pagination__link {
      padding-inline: 14px;
    }
  }
</style>

<nav class="pk-pagination" aria-label="<?= esc(lang('Pager.pageNavigation')) ?>">
  <ul class="pk-pagination__list">
    <?php if ($pager->hasPrevious()) : ?>
      <li class="pk-pagination__item pk-pagination__item--nav">
        <a class="pk-pagination__link" href="<?= $pager->getFirst() ?>" aria-label="<?= esc(lang('Pager.first')) ?>">
          <span aria-hidden="true"><?= esc(lang('Pager.first')) ?></span>
        </a>
      </li>
      <li class="pk-pagination__item pk-pagination__item--nav">
        <a class="pk-pagination__link" href="<?= $pager->getPrevious() ?>" aria-label="<?= esc(lang('Pager.previous')) ?>">
          <span aria-hidden="true"><?= esc(lang('Pager.previous')) ?></span>
        </a>
      </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
      <li class="pk-pagination__item<?= $link['active'] ? ' is-active' : '' ?>">
        <?php if ($link['active']) : ?>
          <span class="pk-pagination__link pk-pagination__link--current" aria-current="page">
            <?= esc($link['title']) ?>
          </span>
        <?php else : ?>
          <a class="pk-pagination__link" href="<?= $link['uri'] ?>">
            <?= esc($link['title']) ?>
          </a>
        <?php endif ?>
      </li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
      <li class="pk-pagination__item pk-pagination__item--nav">
        <a class="pk-pagination__link" href="<?= $pager->getNext() ?>" aria-label="<?= esc(lang('Pager.next')) ?>">
          <span aria-hidden="true"><?= esc(lang('Pager.next')) ?></span>
        </a>
      </li>
      <li class="pk-pagination__item pk-pagination__item--nav">
        <a class="pk-pagination__link" href="<?= $pager->getLast() ?>" aria-label="<?= esc(lang('Pager.last')) ?>">
          <span aria-hidden="true"><?= esc(lang('Pager.last')) ?></span>
        </a>
      </li>
    <?php endif ?>
  </ul>
</nav>
