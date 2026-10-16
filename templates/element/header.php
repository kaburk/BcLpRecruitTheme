<?php
/**
 * BcLpRecruitTheme : baserCMS 5 採用 LP テーマ
 *
 * ヘッダー
 *
 * - ロゴ：テーマ設定のロゴ。未設定ならサイト名を文字で出す
 * - ナビ：本文で「ID設定」をしたブロックの見出しから自動で作る（LpHelper::getNavItems()）
 * - 応募するボタン：公開中の最初のメールフォームへリンクする（LpHelper::getFormUrl()）
 * - メールフォームの画面では、ナビの代わりに「戻る」リンクを出す
 *
 * @var \BaserCore\View\BcFrontAppView $this
 */
$isMailPage = ($this->getRequest()->getParam('plugin') === 'BcMail');
$page = $this->get('page');
$navItems = (!$isMailPage && !empty($page))? $this->Lp->getNavItems($page->contents) : [];
$formUrl = $isMailPage? '' : $this->Lp->getFormUrl();
$hasMenu = ($navItems || $formUrl);

ob_start();
$this->BcBaser->logo(['link' => '']);
$logo = trim(ob_get_clean());
?>
<header class="rc-header">
	<div class="rc-wrap rc-header__inner">
		<a class="rc-header__logo" href="<?= h($this->BcBaser->getUrl('/')) ?>">
			<?php if ($logo): ?>
				<?= $logo ?>
			<?php else: ?>
				<?= h($this->Lp->getSiteLabel()) ?>
			<?php endif ?>
		</a>

		<?php if ($isMailPage): ?>
			<a class="rc-back" href="<?= h($this->BcBaser->getUrl('/')) ?>">← トップページに戻る</a>
		<?php else: ?>
			<?php if ($navItems): ?>
				<nav class="rc-nav" aria-label="ページ内">
					<ul>
						<?php foreach ($navItems as $item): ?>
							<li><a href="#<?= h($item['id']) ?>"><?= h($item['label']) ?></a></li>
						<?php endforeach ?>
					</ul>
				</nav>
			<?php endif ?>
			<?php if ($formUrl): ?>
				<a class="rc-btn rc-btn--sm rc-header__cta" href="<?= h($this->BcBaser->getUrl($formUrl)) ?>">応募する</a>
			<?php endif ?>
			<?php if ($hasMenu): ?>
				<button class="rc-burger" type="button" data-rc-drawer-toggle aria-expanded="false" aria-controls="rc-drawer" aria-label="メニューを開く">
					<svg class="rc-burger__open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
					<svg class="rc-burger__close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
				</button>
			<?php endif ?>
		<?php endif ?>
	</div>

	<?php if (!$isMailPage && $hasMenu): ?>
		<nav class="rc-drawer" id="rc-drawer" aria-label="メニュー" hidden>
			<?php if ($navItems): ?>
				<ul>
					<?php foreach ($navItems as $item): ?>
						<li><a href="#<?= h($item['id']) ?>"><?= h($item['label']) ?></a></li>
					<?php endforeach ?>
				</ul>
			<?php endif ?>
			<?php if ($formUrl): ?>
				<a class="rc-btn" href="<?= h($this->BcBaser->getUrl($formUrl)) ?>">応募する</a>
			<?php endif ?>
		</nav>
	<?php endif ?>
</header>
