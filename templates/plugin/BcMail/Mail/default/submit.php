<?php
/**
 * BcLpRecruitTheme : baserCMS5 採用 LP テーマ
 *
 * メールフォーム：完了
 *
 * 完了メッセージは、メールフォーム設定の「送信完了メッセージ」で編集する
 *
 * @var \BcMail\View\MailFrontAppView $this
 * @var \BcMail\Model\Entity\MailContent $mailContent
 */
use Cake\Core\Configure;

if (Configure::read('debug') == 0 && $mailContent->redirect_url) {
	$this->BcBaser->meta(['http-equiv' => 'Refresh'], null, ['content' => '5;url=' . $mailContent->redirect_url, 'block' => true]);
}
?>
<section class="rc-fhero">
	<div class="rc-wrap rc-wrap--narrow">
		<p class="rc-eyebrow">Thank you</p>
		<h1 class="rc-fhero__title">送信が完了しました</h1>
		<?php $this->BcBaser->element('lp_steps', ['current' => 3]) ?>
	</div>
</section>
<section class="rc-fsec">
	<div class="rc-wrap rc-wrap--narrow">
		<div class="rc-fcard rc-done">
			<span class="rc-done__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 5 5 9-10"/></svg></span>
			<h2 class="rc-done__title">お申し込みありがとうございます</h2>
			<div class="rc-done__message">
				<?php if ($this->BcBaser->mailFormThanksExists()): ?>
					<?php $this->BcBaser->mailFormThanks() ?>
				<?php else: ?>
					<p>内容を確認のうえ、担当者よりご入力のメールアドレスへご連絡します。</p>
				<?php endif ?>
			</div>
			<div class="rc-done__actions">
				<a class="rc-btn rc-btn--ghost" href="<?= h($this->BcBaser->getUrl('/')) ?>">トップページへ戻る</a>
			</div>
		</div>
	</div>
</section>
