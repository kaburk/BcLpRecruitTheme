<?php
/**
 * BcLpRecruitTheme : baserCMS 5 採用 LP テーマ
 *
 * メールフォーム：確認
 *
 * @var \BcMail\View\MailFrontAppView $this
 * @var bool $freezed 確認画面かどうか（入力エラーのときは false）
 */
if ($freezed) {
	$this->Mailform->freeze();
}
?>
<section class="rc-fhero">
	<div class="rc-wrap rc-wrap--narrow">
		<?php if ($freezed): ?>
			<p class="rc-eyebrow">Confirm</p>
			<h1 class="rc-fhero__title">入力内容の確認</h1>
			<p class="rc-fhero__lead">以下の内容でよろしければ、「送信する」を押してください。</p>
		<?php else: ?>
			<p class="rc-eyebrow">Entry form</p>
			<h1 class="rc-fhero__title"><?php $this->BcBaser->contentsTitle() ?></h1>
			<div class="rc-fhero__lead"><?php $this->Mail->description() ?></div>
		<?php endif ?>
		<?php $this->BcBaser->element('lp_steps', ['current' => $freezed? 2 : 1]) ?>
	</div>
</section>
<section class="rc-fsec">
	<div class="rc-wrap rc-wrap--narrow">
		<div class="rc-fcard">
			<?php $this->BcBaser->flash() ?>
			<div class="rc-form<?= $freezed? ' is-confirm' : '' ?>">
				<?php $this->BcBaser->element('mail_form') ?>
			</div>
		</div>
	</div>
</section>
