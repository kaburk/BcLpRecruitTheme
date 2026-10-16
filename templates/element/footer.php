<?php
/**
 * BcLpRecruitTheme : baserCMS5 採用 LP テーマ
 *
 * フッター
 *
 * - 主催者名・問い合わせ先：ウィジェットエリア（テキストウィジェット）で編集する
 * - コピーライト：サイト名と年から自動で出す
 *
 * @var \BaserCore\View\BcFrontAppView $this
 */
?>
<footer class="rc-footer">
	<div class="rc-wrap">
		<div class="rc-footer__inner">
			<?php $this->BcBaser->widgetArea() ?>
		</div>
		<small class="rc-footer__copy">&copy; <?= date('Y') ?> <?= h($this->Lp->getSiteLabel()) ?></small>
	</div>
</footer>
